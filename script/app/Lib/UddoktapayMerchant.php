<?php

namespace App\Lib;

use App\Library\UPLibrary;
use Session;
use Illuminate\Http\Request;

class UddoktapayMerchant
{

    public static function redirect_if_payment_success()
    {
        if (Session::has('fund_callback')) {
            return url(Session::get('fund_callback')['success_url']);
        } else {
            return url('partner/payment/success');
        }
    }

    public static function redirect_if_payment_faild()
    {
        if (Session::has('fund_callback')) {
            return url(Session::get('fund_callback')['cancel_url']);
        } else {
            return url('partner/payment/failed');
        }
    }
    
    public static function fallbacksub()
    {
        if (tenant() != null) {
            return url('/order/payment/uddoktapay');
        }
        return url('payment/uddoktapay');
    }

    public static function fallback()
    {
        if (tenant() != null) {
            return 'https://multipurc.com/order/payment/uddoktapaymerchant';
        }
        return 'https://multipurc.com/payment/uddoktapaymerchant';
    }

    public static function make_payment($array)
    {
        $api_key    = env('UDDOKTAPAY_API_KEY');
        $api_url    = env('UDDOKTAPAY_API_URL');
        $currency   = strtoupper($array['currency']);
        $email      = $array['email'];
        $amount     = round($array['pay_amount']);
        $name       = $array['name'];

        $data = [
            'api_key'       => $api_key,
            'api_url'       => $api_url,
            'payment_mode'  => 'uddoktapay',
            'amount'        => $amount,
            'charge'        => $array['charge'],
            'main_amount'   => $array['amount'],
            'getway_id'     => $array['getway_id'],
            'payment_type'  => $array['payment_type'] ?? ''
        ];


        Session::put('uddoktapay_credentials', $data);
        $gateway = new UPLibrary($api_key, $api_url);

        $payment_data = [
            'full_name'     => $name,
            'email'         => $email,
            'amount'        => $amount,
            'metadata'      => [
                'success_url'       => UddoktapayMerchant::fallbacksub()
            ],
            'redirect_url'  => UddoktapayMerchant::fallback(),
            'return_type'   => 'GET',
            'cancel_url'    => UddoktapayMerchant::redirect_if_payment_faild()
        ];
        
        //dd($payment_data);

        try {
            $paymentUrl = $gateway->init_payment($payment_data);
            return redirect($paymentUrl);
        } catch (Exception $e) {
            return redirect(UddoktapayMerchant::redirect_if_payment_faild());
        }
    }
    
    public function statussub(Request $request)
    {
        abort_if(!Session::has('uddoktapay_credentials'), 404);
        $credentials = Session::get('uddoktapay_credentials');
        $gateway = new UPLibrary($credentials['api_key'], $credentials['api_url']);
        $response = $gateway->verify_payment($request->invoice_id);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $data['payment_id'] = $response['transaction_id'];
            $data['payment_method'] = "uddoktapay";
            $data['getway_id'] = $credentials['getway_id'];
            $data['amount'] = $credentials['main_amount'];
            $data['charge'] = $credentials['charge'];
            $data['status'] = 1;
            $data['payment_status'] = 1;

            Session::put('payment_info', $data);
            Session::forget('uddoktapay_credentials');

            return redirect(UddoktapayMerchant::redirect_if_payment_success());
        } else {
            $data['payment_status'] = 0;
            Session::put('payment_info', $data);
            Session::forget('uddoktapay_credentials');
            return redirect(Uddoktapay::redirect_if_payment_faild());
        }
    }

    public function status(Request $request)
    {
        $api_key    = env('UDDOKTAPAY_API_KEY');
        $api_url    = env('UDDOKTAPAY_API_URL');
        //abort_if(!Session::has('uddoktapay_credentials'), 404);
        $credentials = Session::get('uddoktapay_credentials');
        $gateway = new UPLibrary($api_key, $api_url);
        $response = $gateway->verify_payment($request->invoice_id);
        //dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $success_url = $response['metadata']['success_url']; //?invoice_id=0M7etxQCZmIWHvPnUedl
            return redirect($success_url . '?invoice_id=' . $request->invoice_id);
        } else {
            die('Something went wrong');
        }
    }
}