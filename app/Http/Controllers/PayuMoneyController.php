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
            $data->payment_id = $mihpayid;
            $data->signature = $posted_hash;
            $data->status = $status;
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
        if ($hash != $posted_hash) {
            // return "Invalid Transaction. Please try again";
            return view('payment.validationerror');
        } else {
            // echo "<h3>Thank You. Your order status is ".$status.".</h3>";
            // echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
            // echo "<h4>We have received a payment of Rs. ".$amount.". Your order will soon be shipped.</h4>";
            $udf1_explode = explode("|", $udf1);

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
                    $data->note = $productinfo;
                    $data->payment_at = $addedon;
                    $data->save();
                }
                // $data = new PaymentModel;
                // $data->trans_date = date('Y-m-d');
                // $data->payment_type = $udf4;
                // $data->payment_mode = 'I';
                // $data->soc_id =  $udf2;
                // $data->brn_id = $udf3;
                // $data->order_id = $mihpayid;
               
                // $data->amount = $amount;
                // $data->invoice_id = $udf5;
                // $data->method = $data['method'];
                // $data->description = $details['description'];
                // $data->card_id = $details['card_id'];
                // $data->card = $data['card'];
                // $data->bank = $details['bank'];
                // $data->wallet = $details['wallet'];
                // $data->vpa = $data['vpa'];
                // $data->email = $email;
                // $data->contact = $phone;
                // $data->fee = $details['fee'];
                // $data->tax = $details['tax'];
               
            }
            // return $data;
            return view('payment.success',['data'=>$data]);
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
}
