<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\PaymentModel;
use Auth;
use DB;

/**
 * Class PayuMoneyController
 */
class PayuMoneyController extends Controller
{
    const TEST_URL = 'https://test.payu.in';
    const PRODUCTION_URL = 'https://secure.payu.in';

    public function error(Request $request){
     
        $data = $request->all();
        // dd($data);
        $mihpayid = $data["mihpayid"];
        $status = $data["status"];
        $firstname = $data["firstname"];
        $amount = $data["amount"];
        $net_amount_debit = $data["net_amount_debit"];
        $txnid = $data["txnid"];
        $posted_hash = $data["hash"];
        $key = $data["key"];
        $productinfo = $data["productinfo"];
        $email = $data["email"];
        $phone = $data["phone"];
        $addedon = $data["addedon"];
        
        $udf1 = $data["udf1"];  //pan no
        $udf2 = $data["udf2"];  //soc id
        $udf3 = $data["udf3"];  //brn_id
        $udf4 = $data["udf4"];  //payment type
        $udf5 = $data["udf5"];  //invoice_id

        $salt = config('payu.salt_key');

        if (isset($data["additionalCharges"])) {
            $additionalCharges = $data["additionalCharges"];
            $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'||||||'.$udf5.'|'.$udf4.'|'.$udf3.'|'.$udf2.'|'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        } else {
            $retHashSeq = $salt.'|'.$status.'||||||'.$udf5.'|'.$udf4.'|'.$udf3.'|'.$udf2.'|'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        }
        $hash = hash("sha512", $retHashSeq);
        if ($hash != $posted_hash) {
            // echo "Invalid Transaction. Please try again";
            // return 'if';
            return view('payment.validationerror');
        } else {
            // return 'else';
            // echo "<h3>Your order status is ". $data["status"].".</h3>";
            // echo "<h4>Your transaction id for this transaction is ".$data["txnid"].". You may try making the payment by clicking the link below.</h4>";
        }
        
        $error_Message = $data['error_Message'];

        // return $errorMessage;

        $udf1_explode = explode("|", $udf1);

        if (Auth::attempt(['pan' => $udf1_explode[0],'password' => $udf1_explode[1]])) {
            $userdtl =DB::table('v_ferti_soc')
                ->leftJoin('v_district','v_ferti_soc.district','=','v_district.district_code')
                ->select('v_ferti_soc.*','v_district.district_name')
                ->where('v_ferti_soc.pan','=',$udf1_explode[0])
                ->first();
            session(['socuserdtls' => $userdtl]);
            Session::put('raw_password', $udf1_explode[1]);
            $datas = PaymentModel::where('order_id',$txnid)->first();
            $datas->payment_id = $mihpayid;
            $datas->signature = $posted_hash;
            $datas->status = $status;
            $datas->note = $error_Message;
            $datas->payment_at = $addedon;
            $datas->save();
        }
        // return view('payumoney.fail', compact('errorMessage'));

       
        // Session::forget('invoice_id');
        // Session::forget('amts');
        // Session::forget('orderId');
        // Session::forget('soc_id');
        // Session::forget('brn_id');
        // Session::forget('pay_mode');
        // Session::forget('ptype');
        return view('payment.error',['details'=>$datas]);
    }
    public function success(Request $request){

        $input = $request->all();

        // return auth()->user();
        // if (Session::get('amts')) {
            // dd(auth()->user());
            // dd($input);
        // }
        $mihpayid = $input["mihpayid"];
        $status = $input["status"];
        $firstname = $input["firstname"];
        $amount = $input["amount"];
        $net_amount_debit = $input["net_amount_debit"];
        $txnid = $input["txnid"];
        $posted_hash = $input["hash"];
        $key = $input["key"];
        $productinfo = $input["productinfo"];
        $email = $input["email"];
        $phone = $input["phone"];
        $addedon = $input["addedon"];
        
        $udf1 = $input["udf1"];  //pan no
        $udf2 = $input["udf2"];  //soc id
        $udf3 = $input["udf3"];  //brn_id
        $udf4 = $input["udf4"];  //payment type
        $udf5 = $input["udf5"];  //invoice_id
        

        $salt = config('payu.salt_key');


        if (isset($input["additionalCharges"])) {
            $additionalCharges = $input["additionalCharges"];
            $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'||||||'.$udf5.'|'.$udf4.'|'.$udf3.'|'.$udf2.'|'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        } else {
            $retHashSeq = $salt.'|'.$status.'||||||'.$udf5.'|'.$udf4.'|'.$udf3.'|'.$udf2.'|'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        }

        $hash = hash("sha512", $retHashSeq);
        if ($status == 'success'  && $hash == $posted_hash) {
            echo $retHashSeq;
            // echo "<h3>Thank You. Your order status is ".$status.".</h3>";
            // echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
            // echo "<h4>We have received a payment of Rs. ".$amount.". Your order will soon be shipped.</h4>";
            $udf1_explode = explode("|", $udf1);
            if($this->verifyPayment($key,$salt,$txnid,$status)){

                echo "<br>";
                echo $this->requestsendhash($key,$salt,$txnid);
			    $msg = "Transaction Successful, Hash Verified...Payment Verified...";
                if (Auth::attempt(['pan' => $udf1_explode[0],'password' => $udf1_explode[1]])) {
                    $userdtl =DB::table('v_ferti_soc')
                        ->leftJoin('v_district','v_ferti_soc.district','=','v_district.district_code')
                        ->select('v_ferti_soc.*','v_district.district_name')
                        ->where('v_ferti_soc.pan','=',$udf1_explode[0])
                        ->first();
                    session(['socuserdtls' => $userdtl]);
                    Session::put('raw_password', $udf1_explode[1]);
    
                    $data = PaymentModel::where('order_id',$txnid)->first();
                    if ($data->order_id==$txnid && $data->amount==$net_amount_debit) {
                        $data->payment_id = $mihpayid;
                        $data->signature = $posted_hash;
                        $data->status = $status;
                        $data->note = $msg;
                        $data->payment_at = $addedon;
                        $data->save();
                    }
                }
                return view('payment.success',['data'=>$data]);

            }else{
                $msg = "Transaction Successful, Hash Verified...Payment Verification failed...";
                if (Auth::attempt(['pan' => $udf1_explode[0],'password' => $udf1_explode[1]])) {
                    $userdtl =DB::table('v_ferti_soc')
                        ->leftJoin('v_district','v_ferti_soc.district','=','v_district.district_code')
                        ->select('v_ferti_soc.*','v_district.district_name')
                        ->where('v_ferti_soc.pan','=',$udf1_explode[0])
                        ->first();
                    session(['socuserdtls' => $userdtl]);
                    Session::put('raw_password', $udf1_explode[1]);
    
                    $data = PaymentModel::where('order_id',$txnid)->first();
                    if ($data->order_id==$txnid && $data->amount==$net_amount_debit) {
                        $data->payment_id = $mihpayid;
                        $data->signature = $posted_hash;
                        $data->status = "failed";
                        $data->note = $msg;
                        $data->payment_at = $addedon;
                        $data->save();
                    }
                }
                return view('payment.error',['data'=>$data]);

            }

            
            // return $data;
        }else{
            // return "Invalid Transaction. Please try again";
            return view('payment.validationerror');
        }





        // Session::forget('invoice_id');
        // Session::forget('amts');
        // Session::forget('orderId');
        // Session::forget('soc_id');
        // Session::forget('brn_id');
        // Session::forget('pay_mode');
        // Session::forget('ptype');
        // return view('payment.success');
    }

    public function cancel(Request $request)
    {
        $input = $request->all();
        

       // dd($input);
       return view('payment.validationerror');
    }

    public function checkHasValidHas($data)
    {
        $status = $data["status"];
        $firstname = $data["firstname"];
        $amount = $data["amount"];
        $txnid = $data["txnid"];
        $errorMessage = $data["error_Message"];

        $posted_hash = $data["hash"];
        $key = $data["key"];
        $productinfo = $data["productinfo"];
        $email = $data["email"];
        $salt = "";

        // Salt should be same Post Request

        if (isset($data["additionalCharges"])) {
            $additionalCharges = $data["additionalCharges"];
            $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        } else {
            $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        }

        $hash = hash("sha512", $retHashSeq);

        if ($hash != $posted_hash) {
            return  false;
        }
        
        return true;
    }
    public function verifyPayment($key,$salt,$txnid,$status)
    {
        $command = "verify_payment"; //mandatory parameter
        
        $hash_str = $key  . '|' . $command . '|' . $txnid . '|' . $salt ;
        $hash = strtolower(hash('sha512', $hash_str)); //generate hash for verify payment request

        $r = array('key' => $key , 'hash' =>$hash , 'var1' => $txnid, 'command' => $command);
        
        $qs= http_build_query($r);
        //for production
        //$wsUrl = "https://info.payu.in/merchant/postservice.php?form=2";
    
        //for test
        $wsUrl = "https://test.payu.in/merchant/postservice.php?form=2";
        
        try 
        {		
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $wsUrl);
            curl_setopt($c, CURLOPT_POST, 1);
            curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
            curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_SSLVERSION, 6); //TLS 1.2 mandatory
            curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
            $o = curl_exec($c);
            if (curl_errno($c)) {
                $sad = curl_error($c);
                throw new Exception($sad);
            }
            curl_close($c);
            
            /*
            Here is json response example -
            
            {"status":1,
            "msg":"1 out of 1 Transactions Fetched Successfully",
            "transaction_details":</strong>
            {	
                "Txn72738624":
                {
                    "mihpayid":"403993715519726325",
                    "request_id":"",
                    "bank_ref_num":"670272",
                    "amt":"6.17",
                    "transaction_amount":"6.00",
                    "txnid":"Txn72738624",
                    "additional_charges":"0.17",
                    "productinfo":"P01 P02",
                    "firstname":"Viatechs",
                    "bankcode":"CC",
                    "udf1":null,
                    "udf3":null,
                    "udf4":null,
                    "udf5":"PayUBiz_PHP7_Kit",
                    "field2":"179782",
                    "field9":" Verification of Secure Hash Failed: E700 -- Approved -- Transaction Successful -- Unable to be determined--E000",
                    "error_code":"E000",
                    "addedon":"2019-08-09 14:07:25",
                    "payment_source":"payu",
                    "card_type":"MAST",
                    "error_Message":"NO ERROR",
                    "net_amount_debit":6.17,
                    "disc":"0.00",
                    "mode":"CC",
                    "PG_TYPE":"AXISPG",
                    "card_no":"512345XXXXXX2346",
                    "name_on_card":"Test Owenr",
                    "udf2":null,
                    "status":"success",
                    "unmappedstatus":"captured",
                    "Merchant_UTR":null,
                    "Settled_At":"0000-00-00 00:00:00"
                }
            }
            }
            
            Decode the Json response and retrieve "transaction_details" 
            Then retrieve {txnid} part. This is dynamic as per txnid sent in var1.
            Then check for mihpayid and status.
            
            */
            $response = json_decode($o,true);
            
            if(isset($response['status']))
            {
                // response is in Json format. Use the transaction_detailspart for status
                $response = $response['transaction_details'];
                $response = $response[$txnid];
                
                if($response['status'] == $status) {//payment response status and verify status matched
                    print_r($response);
                    return true;
                }else{

                    return false;
                }
            }
            else {
                return false;
            }
        }
        catch (Exception $e){
            return false;	
        }
    }

    public function requestsendhash($key,$salt,$txnid)
    {
        // $key = "7rnFly";//"qyt13u";
        // $salt = "pjVQAWpA";
        $command = "verify_payment";
        $var1 = $txnid; // Transaction ID


        $hash_str = $key  . '|' . $command . '|' . $var1 . '|' . $salt ;
        $hash = strtolower(hash('sha512', $hash_str));

            $r = array('key' => $key , 'hash' =>$hash , 'var1' => $var1, 'command' => $command);
            return $hash;
            // die();
            $qs= http_build_query($r);
            $wsUrl = "https://test.payu.in/merchant/postservice.php?form=1";
            //$wsUrl = "https://info.payu.in/merchant/postservice?form=1";
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