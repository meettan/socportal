<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\PaymentModel;

class HdfcresponseController extends Controller
{
    public function settlementdetails(Request $request){
        
        $key = config('payu.merchant_key');
        $salt = config('payu.salt_key');
        $command = "get_settlement_details";
        $var1 = "2023-01-02"; // Transaction ID
        $hash_str = $key  . '|' . $command . '|' . $var1 . '|' . $salt ;
        $hash = strtolower(hash('sha512', $hash_str));
        $r = array('key' => $key , 'hash' =>$hash , 'var1' => $var1, 'command' => $command);
            
        $qs= http_build_query($r);
        $wsUrl = "https://info.payu.in/merchant/postservice.php?form=1";

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $wsUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $o = curl_exec($c);
        if (curl_errno($c)) {
        $sad = curl_error($c);
        throw new Exception($sad);
        }
        curl_close($c);

        $valueSerialized = @unserialize($o);
        if($o === 'b:0;' || $valueSerialized !== false) {
        print_r($valueSerialized);
        }
        print_r($o);

    }
}
