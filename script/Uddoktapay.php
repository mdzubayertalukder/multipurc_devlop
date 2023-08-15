<?php

namespace App\Lib;

use App\Library\UPLibrary;
use Session;
use Illuminate\Http\Request;

class Uddoktapay
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

    public static function fallback()
    {
        if (tenant() != null) {
            return url('/order/payment/uddoktapay');
        }
        return url('payment/uddoktapay');
    }

    public static function make_payment($array)
    {
        $api_key    = $array['api_key'];
        $api_url    = $array['api_url'];
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
                'getway_id' => $array['getway_id']
            ],
            'redirect_url'  => Uddoktapay::fallback(),
            'return_type'   => 'GET',
            'cancel_url'    => Uddoktapay::redirect_if_payment_faild(),
            'webhook_url'   => Uddoktapay::fallback(),
        ];

        try {
            $paymentUrl = $gateway->init_payment($payment_data);
            return redirect($paymentUrl);
        } catch (Exception $e) {
            return redirect(UddoktaPay::redirect_if_payment_faild());
        }
    }

    public function status(Request $request)
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

            return redirect(Uddoktapay::redirect_if_payment_success());
        } else {
            $data['payment_status'] = 0;
            Session::put('payment_info', $data);
            Session::forget('uddoktapay_credentials');
            return redirect(Uddoktapay::redirect_if_payment_faild());
        }
    }
}