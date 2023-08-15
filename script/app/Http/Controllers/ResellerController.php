<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\Term;




use App\Models\Category;

use App\Models\Price;
use App\Models\Productoption;
use DB;
use DNS1D;
use DNS2D;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use Auth;




















use App\Models\Plan;
use App\Models\User;
use App\Models\Option;
use App\Models\Order;
use App\Models\Tenantorder;
use App\Models\Getway;

use Str;
use Session;
use App\Models\Tenantmeta;
use Storage;

//use App\Models\Term;

//use Artesaos\SEOTools\Facades\SEOMeta;
//use Artesaos\SEOTools\Facades\OpenGraph;
//use Artesaos\SEOTools\Facades\TwitterCard;
//use Artesaos\SEOTools\Facades\JsonLd;
//use Artesaos\SEOTools\Facades\JsonLdMulti;
//use Artesaos\SEOTools\Facades\SEOTools;
class ResellerController extends Controller
{
    public function reseller($email)
    {
        $user_data=User::select('id')->where('email',$email)->get();
       $use_id=$user_data[0]['id'];
       $id=Auth()->user();
      
       $posts=Tenant::where('user_id',$use_id)->latest()->paginate(50);
        return view('reseller.sell_my_product',compact('posts'));
        
    }
    
 
    
    
    
   
}
