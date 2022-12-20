<?php

namespace App\Http\Controllers;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Session;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\PaymentModel;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    const TEST_URL = 'https://test.payu.in';
    const PRODUCTION_URL = 'https://secure.payu.in';
    
    public function payment(){

        return view('payment/paymenthome');
    }
    public function advpayment(Request $request){

        if ($request->isMethod('post')) {
            $imageName = '';
            $soc_id =   Auth::user()->soc_id; 
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            $pay = new PaymentModel;
            $pay->trans_date = request('tr_date');
            $pay->payment_type =request('ptype');
            $pay->soc_id = $soc_id;
            $pay->brn_id = Session::get('socuserdtls')->district;
            $pay->amount = request('amt');
            $pay->payment_mode = request('pay_mode');
            $pay->cheque_no = request('cheque_no');
            $pay->cheque_dt = request('cheque_dt');
            $pay->bank_name = request('bank_name');
            $pay->ifs_code  = request('ifs_code');
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
            $pay->cheque_img = $imageName;
            $pay->created_by = 'demo';
            $pay->save();
        }else{
            return view('payment/advpayment');
        }
        
    }

   
    public function paymentlist(){

        $payment_list = PaymentModel::orderBy('id', 'DESC')->get();
        return view('payment.payment_list', ['payment_list' => $payment_list]);

    }

    public function paymentrequest(Request $request){
        $pay_mode = $request->input('pay_mode');
        if(request('amt') >= 1){
        
            if($pay_mode == 'I')
            {
                if(request('amt') > 500000){
                    return redirect()->back()->with('amt_error','Maximum allowable amount exceed.');
                }else{
                $name = $request->input('name');
                $amount = $request->input('amt');
                // $api = new Api('rzp_test_OWzJfVy5ZI6cj1', 'PmjFWLtnnGS6AeCQ1Sk2okrH');
                $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                $orderId = $order['id'];
                Session::forget('invoice_id');
                Session::put('amts',  $amount);
                Session::put('orderId',  $orderId);
                Session::put('soc_id',  Auth::user()->soc_id);
                Session::put('brn_id',  Session::get('socuserdtls')->district);
                Session::put('pay_mode',  'I');
                Session::put('ptype', request('ptype'));
                $data = array(
                    'order_id' => $orderId,
                    'amount' => $amount * 100
                );
                // Session::put('order_id', $orderId);
                return redirect()->route('paywithroza')->with('data', $data);
                }
            }else{
                $imageName = '';
                $soc_id =   Auth::user()->soc_id; 
                // $request->validate([
                //     'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                // ]);
                $pay = new PaymentModel;
                $pay->trans_date = date('Y-m-d');
                $pay->payment_type =request('ptype');
                $pay->soc_id = $soc_id;
                $pay->brn_id = Session::get('socuserdtls')->district;
                $pay->amount = request('amt');
                $pay->payment_mode = request('pay_mode');
                $pay->cheque_no = request('cheque_no');
                $pay->cheque_dt = request('cheque_dt');
                $pay->bank_name = request('bank_name');
                $pay->ifs_code  = request('ifs_code');
                if($imageName != ''){
                $imageName = time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('images'), $imageName);
                }
                $pay->cheque_img = $imageName;
                $pay->created_by = Auth::user()->id;
                $pay->save();
                return redirect()->route('paymentlist');
        }

       }else{
        return redirect()->back()->with('amt_error','Minimum amount must be 1');
       }
        
    }
    
    public function paywithroza(Request $request)
    {   
        // return Session::get('data');
        return view('payment.paywithrozapay')->with('data',Session::get('data'));
    }

    public function pay(Request $request){
        $data = $request->all();
        // return $data;
       
        if(count($data)==0){
            return redirect()->route('dashboard');
        }
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $success  = false;
        try{
            $attributes = array(
                'razorpay_signature' => $data['razorpay_signature'],
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_order_id' => $data['razorpay_order_id']
            );
            $order = $api->utility->verifyPaymentSignature($attributes);
            $details=$api->payment->fetch($data['razorpay_payment_id']);
            
            if(Session::get('orderId') == $details['order_id'] &&  Session::get('amts') == $details['amount']/100){
            $data = new PaymentModel;
            $data->order_id = $details['order_id'];
            $data->payment_id = $details['id'];
            $data->signature = $data['razorpay_signature'];
            $data->status = $details['status'];
            $data->payment_type = Session::get('ptype');
            $data->amount = $details['amount']/100;
            $data->payment_mode = Session::get('pay_mode');
            $data->brn_id = Session::get('brn_id');
            $data->soc_id = Session::get('soc_id');
            $data->invoice_id = Session::get('invoice_id')?Session::get('invoice_id'):NULL;
            $data->method = $data['method'];
            $data->description = $details['description'];
            $data->card_id = $details['card_id'];
            $data->card = $data['card'];
            $data->bank = $details['bank'];
            $data->wallet = $details['wallet'];
            $data->vpa = $data['vpa'];
            $data->email = $details['email'];
            $data->contact = $details['contact'];
            $data->note = $data['notes'];
            $data->fee = $details['fee'];
            $data->tax = $details['tax'];
            $data->trans_date = date('Y-m-d');
            $data->created_by = Auth::user()->id;
            $data->payment_at = $details['created_at'];
            $data->save();
            $success = true;
            $sdata = PaymentModel::where('order_id',$details['order_id'])->first();
            }
           
        }catch(SignatureVerificationError $e){

            $succes = false;
        }
        if($success == true){
           
            return redirect()->route('success')->with('data', $sdata);
        }else{
            // return 
            $details=$api->payment->fetch($data['razorpay_payment_id']);
            if(Session::get('orderId') == $details['order_id'] &&  Session::get('amts') == $details['amount']/100){
                $data = new PaymentModel;
                $data->order_id = $details['order_id'];
                $data->payment_id = $details['id'];
                $data->signature = $data['razorpay_signature'];
                $data->status = $details['status'];
                $data->payment_type = Session::get('ptype');
                $data->amount = $details['amount']/100;
                $data->payment_mode = Session::get('pay_mode');
                $data->brn_id = Session::get('brn_id');
                $data->soc_id = Session::get('soc_id');
                $data->invoice_id = Session::get('invoice_id') ? Session::get('invoice_id'):NULL;
                $data->method = $data['method'];
                $data->description = $details['description'];
                $data->card_id = $details['card_id'];
                $data->card = $data['card'];
                $data->bank = $details['bank'];
                $data->wallet = $details['wallet'];
                $data->vpa = $data['vpa'];
                $data->email = $details['email'];
                $data->contact = $details['contact'];
                $data->note = $data['notes'];
                $data->fee = $details['fee'];
                $data->tax = $details['tax'];
                $data->trans_date = date('Y-m-d');
                $data->created_by = Auth::user()->id;
                $data->payment_at = $details['created_at'];
                $data->save();
                $success = true;
                $sdata = PaymentModel::where('order_id',$details['order_id'])->first();
                return redirect()->route('success')->with('data', $sdata);
                }else{

                    // $details=$api->payment->fetch($data['razorpay_payment_id']);
                    // $data = new PaymentModel;
                    // $data->trans_date = date('Y-m-d');
                    // $data->order_id = isset($details['order_id']) ? $details['order_id'] : 'ERROR';
                    // $data->payment_id = isset($details['id']) ? $details['id']: 'ERROR';
                    // $data->status = 'Parameter mismatched payment failed';
                    // $data->payment_type = Session::get('ptype') ? Session::get('ptype') : 'I';
                    // $data->amount = isset($details['amount']) ? ($details['amount']/100) : 0;
                    // $data->payment_mode = Session::get('pay_mode') ? Session::get('pay_mode') : 'I';
                    // $data->brn_id = Session::get('brn_id') ? Session::get('brn_id') : 0 ;
                    // $data->soc_id = Session::get('soc_id') ? Session::get('soc_id') : 0 ;
                    // $data->invoice_id = Session::get('invoice_id') ? Session::get('invoice_id'):NULL;
                    // $data->method = isset($data['method']) ? $data['method'] : NULL;
                    // $data->description = isset($details['description']) ? $details['description'] : NULL;
                    // $data->card_id = isset($details['card_id']) ?  $details['card_id'] : NULL;
                    // $data->card = isset($data['card']) ? $data['card'] : NULL;
                    // $data->bank = isset($details['bank']) ? $details['bank'] : NULL;
                    // $data->wallet = isset($details['wallet']) ? $details['wallet'] : NULL;
                    // $data->vpa = isset($data['vpa']) ? $data['vpa'] : NULL;
                    // $data->email = isset($details['email']) ? $details['email'] : NULL;
                    // $data->contact = isset($details['contact']) ? $details['contact'] : NULL;
                    // $data->note = isset($data['notes']) ? $data['notes'] : NULL;
                    // $data->fee = isset($details['fee']) ? $details['fee'] : NULL;
                    // $data->tax = isset($details['tax']) ? $details['tax'] : NULL;
                    // $data->created_by = Auth::user()->id;
                    // $data->payment_at = isset($details['created_at']) ? $details['created_at'] : NULL;
                    // $data->save();
                    return view('payment.validationerror');

                }
                

            // return redirect()->route('paymentlist');
        }
        
    }

    public function failedresponse(Request $request)
    {
        $order_id = $request->order_id;
        $payment_id =  $request->payment_id;
        $code       =  $request->code;
        $description  =  $request->description;
        $data = new PaymentModel;
        $data->amount = Session::get('amts');
        $data->trans_date = date('Y-m-d');
        $data->payment_type = Session::get('ptype');
        $data->payment_mode = Session::get('pay_mode');
        $data->invoice_id = Session::get('invoice_id') ? Session::get('invoice_id'):NULL;
        $data->brn_id = Session::get('brn_id');
        $data->soc_id = Session::get('soc_id');
        $data->order_id = $order_id;
        $data->payment_id = $payment_id;
        $data->status = $request->reason.' '.$description;
        $data->payment_at = strtotime(date("Y-m-d h:i:s"));
        $data->created_by = Auth::user()->id;
        $data->save();
        echo $payment_id;
    }

    public function paymentdetail(Request $request)
    {
        $order_id  = $request->get('id');
        $payment_data = PaymentModel::where('id',$order_id)->first();
        return view('payment.payment_detail', ['payment' => $payment_data]);
    }



    // invoice payment list 
    public function invpayment(){
        DB::enableQueryLog(); 
        $soc_id = Auth::user()->soc_id;
        $br_cd  = Session::get('socuserdtls')->district; 
        $invoice_list = DB::select("select distinct trans_do,do_dt,sale_ro from v_sale 
                                                where br_cd = '$br_cd'
                                                 and soc_id='$soc_id'
                                                 and round_tot_amt-paid_amt > 0 
                                                 and round_tot_amt-paid_amt < 500000 
                                                 and trans_do NOT IN (SELECT invoice_id FROM td_payment where status='success')
                                                 ");
        return view('payment.invoice_list', ['invoice_list' => $invoice_list]);
    }

    // in invoice payment list page click on pay button
    public function invpayform(Request $request){

        $sale_invoice_no = $request->input('trans_do');
            $invoice_amt = 0;$cr_amt = 0;
            $ro_no = $request->input('ro'); 
            $soc_id = Auth::user()->soc_id;
            $dt   = $request->input('dt');
            $data = DB::select("select ifnull(sum(tot_amt),0) - 
                        (SELECT ifnull(sum(a.paid_amt),0)  
                                            FROM v_payment_recv a 
                                            WHERE a.soc_id ='$soc_id'
                                            and sale_invoice_no='$sale_invoice_no'
                                            and ro_no='$ro_no' and  a.pay_type<>'O') +
                    (SELECT ifnull(sum(a.tot_recvble_amt),0)  - ifnull(sum(a.paid_amt),0)
                    FROM v_payment_recv a 
                    WHERE a.soc_id ='$soc_id'
                    and sale_invoice_no='$sale_invoice_no'
                    and ro_no='$ro_no'  and a.pay_type='O')as net_amt,
                    ifnull(sum(round_tot_amt),0) - 
                        (SELECT ifnull(sum(a.paid_amt),0)  
                                            FROM v_payment_recv a 
                                            WHERE a.soc_id ='$soc_id'
                                            and sale_invoice_no='$sale_invoice_no'
                                            and ro_no='$ro_no' and  a.pay_type<>'O') +
                        (SELECT ifnull(sum(a.tot_recvble_amt),0)  - ifnull(sum(a.paid_amt),0)
                        FROM v_payment_recv a 
                        WHERE a.soc_id ='$soc_id'
                        and sale_invoice_no='$sale_invoice_no'
                        and ro_no='$ro_no'  and a.pay_type='O')as rnd_net_amt,
                                   ifnull(sum(tot_amt),0)+
                                   (SELECT ifnull(sum(a.tot_recvble_amt),0)  - ifnull(sum(a.paid_amt),0)
                                   FROM v_payment_recv a 
                                   WHERE a.soc_id ='$soc_id'
                                   and sale_invoice_no='$sale_invoice_no'
                                   and ro_no='$ro_no' and a.pay_type='O' )as tot_ro_amt
                                   from  v_sale where  trans_do = '$sale_invoice_no'
                                   and sale_ro='$ro_no'");
            $invoice_amt = $data[0]->tot_ro_amt;
            $cr = DB::select("SELECT ifnull(sum(tot_amt),0) -(select  ifnull(sum(tot_amt),0) 
																	FROM v_dr_cr_note
																	WHERE soc_id='$soc_id'
																	and note_type='D' 
																	and trans_flag='A' and invoice_no='$sale_invoice_no')  - 
																	(select  ifnull(sum(paid_amt),0) 
																	FROM v_payment_recv
																	WHERE soc_id='$soc_id'
																	and pay_type='6' 
																	and sale_invoice_no= '$sale_invoice_no')  AS tot_amt
									FROM v_dr_cr_note
									WHERE soc_id='$soc_id'
									and note_type='D' 
									and trans_flag='R' and invoice_no='$sale_invoice_no'");
            $cr_amt = $cr[0]->tot_amt;
            $pay_amt = round($invoice_amt-$cr_amt);
            Session::put('amts', $pay_amt);
            Session::put('ro_no', $ro_no);
            Session::put('invoice_id', $sale_invoice_no);
            Session::put('payment_type', 'I');

            // return auth()->user();
        return redirect()->route('redirectToPayU');
    }

     //    Code for invoice payment request to payu
    public function redirectToPayU(Request $request)
    {
        $data = $request->all();
        // return $data;
        if (count($data)>0) {
            $data['amount']=Session::get('amts');
        }
        $MERCHANT_KEY = config('payu.merchant_key');
        $SALT = config('payu.salt_key');

        $PAYU_BASE_URL = config('payu.test_mode') ? self::TEST_URL : self::PRODUCTION_URL;
        $action = '';

        $posted = array();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $posted[$key] = $value;
            }
        }

        $formError = 0;

        if (empty($posted['txnid'])) {
            // Generate random transaction id
            $txnid = substr(hash('sha256', mt_rand().microtime()), 0, 20);
        } else {
            $txnid = $posted['txnid'];
        }
        $hash = '';
        // Hash Sequence
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        if (empty($posted['hash']) && sizeof($posted) > 0) {
            if (
                empty($posted['key'])
                || empty($posted['txnid'])
                || empty($posted['amount'])
                || empty($posted['firstname'])
                || empty($posted['email'])
                || empty($posted['phone'])
                || empty($posted['productinfo'])
                || empty($posted['surl'])
                || empty($posted['furl'])
                || empty($posted['service_provider'])
            ) {
                $formError = 1;
            } else {
                $hashVarsSeq = explode('|', $hashSequence);
                $hash_string = '';
                foreach ($hashVarsSeq as $hash_var) {
                    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                    $hash_string .= '|';
                }

                $hash_string .= $SALT;

                $hash = strtolower(hash('sha512', $hash_string));
                $action = $PAYU_BASE_URL.'/_payment';

            }
        } elseif (!empty($posted['hash'])) {
            $hash = $posted['hash'];
            $action = $PAYU_BASE_URL.'/_payment';

        }

        $pay_mode=$request->pay_mode;
        // return $pay_mode;
        if ($pay_mode =='') {
            return view('payment.invpayform', [
                'formError'=>$formError,
                'hash'=>$hash,
                'action'=>$action,
                'MERCHANT_KEY'=>$MERCHANT_KEY,
                'txnid'=>$txnid,
                'formError'=>$formError,
                'posted'=>$posted,
                'SALT'=>$SALT,
            ]);
        }else{
            if($pay_mode != 'I') {
                //return $pay_mode;
                        $imageName = request()->image;
                        $soc_id =   Auth::user()->soc_id; 
                        // $request->validate([
                        //     'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                        // ]);
                        $pay = new PaymentModel;
                        $pay->trans_date = date('Y-m-d');
                        $pay->payment_type ='I';
                        $pay->soc_id = $soc_id;
                        $pay->brn_id = Session::get('socuserdtls')->district;
                        $pay->amount = Session::get('amts');
                        $pay->payment_mode = request('pay_mode');
                        $pay->cheque_no = request('cheque_no');
                        $pay->cheque_dt = request('cheque_dt');
                        $pay->bank_name = request('bank_name');
                        $pay->ifs_code  = request('ifs_code');
                        if($imageName != ''){
                        $imageName = time().'.'.request()->image->getClientOriginalExtension();
                        request()->image->move(public_path('images'), $imageName);
                        }
                       
                        $pay->cheque_img = $imageName;
                        $pay->created_by = Auth::user()->id;
                        $pay->save();
                        return redirect()->route('paymentlist');
            }else{
                // return $pay_mode;
                // return $data;
                //  insert record into db
                $data = new PaymentModel;
                $data->trans_date = date('Y-m-d');
                $data->payment_type = $request->udf4;
                $data->payment_mode = $pay_mode;
                $data->soc_id = auth()->user()->soc_id;
                $data->brn_id = Session::get('socuserdtls')->district;
                $data->order_id = $request->txnid;
                $data->amount =  $request->amount;
                $data->invoice_id = $request->udf5;
                $data->email = $request->email;
                $data->contact = $request->phone;
                $data->created_by = auth()->user()->id;
                $data->save();

                return view('payment.invpayform', [
                    'formError'=>$formError,
                    'hash'=>$hash,
                    'action'=>$action,
                    'MERCHANT_KEY'=>$MERCHANT_KEY,
                    'txnid'=>$txnid,
                    'formError'=>$formError,
                    'posted'=>$posted,
                    'SALT'=>$SALT,
                ]);
            }
        }
        
    }

    // Advance payment redirect
    public function advredirectToPayU(Request $request)
    {
        $adv_invoice_id=auth()->user()->soc_id.'_'.date('Ymd_his');
        Session::put('payment_type', 'A');
        if (!Session::get('adv_invoice_id')) {
            Session::put('adv_invoice_id', $adv_invoice_id);
        }

        $data = $request->all();
        // return $data;
        $MERCHANT_KEY = config('payu.merchant_key');
        $SALT = config('payu.salt_key');

        $PAYU_BASE_URL = config('payu.test_mode') ? self::TEST_URL : self::PRODUCTION_URL;
        $action = '';

        $posted = array();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $posted[$key] = $value;
            }
        }
        // return $posted;

        $formError = 0;

        if (empty($posted['txnid'])) {
            // Generate random transaction id
            $txnid = substr(hash('sha256', mt_rand().microtime()), 0, 20);
        } else {
            $txnid = $posted['txnid'];
        }
        $hash = '';
        // Hash Sequence
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        if (empty($posted['hash']) && sizeof($posted) > 0) {
            if (
                empty($posted['key'])
                || empty($posted['txnid'])
                || empty($posted['amount'])
                || empty($posted['firstname'])
                || empty($posted['email'])
                || empty($posted['phone'])
                || empty($posted['productinfo'])
                || empty($posted['surl'])
                || empty($posted['furl'])
                || empty($posted['service_provider'])
            ) {
                $formError = 1;
            } else {
                $hashVarsSeq = explode('|', $hashSequence);
                $hash_string = '';
                foreach ($hashVarsSeq as $hash_var) {
                    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                    $hash_string .= '|';
                }

                $hash_string .= $SALT;

                $hash = strtolower(hash('sha512', $hash_string));
                $action = $PAYU_BASE_URL.'/_payment';

            }
        } elseif (!empty($posted['hash'])) {
            $hash = $posted['hash'];
            $action = $PAYU_BASE_URL.'/_payment';

        }

        $pay_mode=$request->pay_mode;
        // return $pay_mode;
        if ($pay_mode =='') {
            return view('payment.advpayment', [
                'formError'=>$formError,
                'hash'=>$hash,
                'action'=>$action,
                'MERCHANT_KEY'=>$MERCHANT_KEY,
                'txnid'=>$txnid,
                'formError'=>$formError,
                'posted'=>$posted,
                'SALT'=>$SALT,
            ]);
        }else{
            if($pay_mode != 'I') {
                //return $pay_mode;
                $imageName = '';
                        $soc_id =   Auth::user()->soc_id; 
                        $imageName = request()->image;
                        // $request->validate([
                        //     'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                        // ]);
                        $pay = new PaymentModel;
                        $pay->trans_date = date('Y-m-d');
                        $pay->payment_type ='A';
                        $pay->soc_id = $soc_id;
                        $pay->brn_id = Session::get('socuserdtls')->district;
                        $pay->amount = request('amount');
                        $pay->payment_mode = request('pay_mode');
                        $pay->cheque_no = request('cheque_no');
                        $pay->cheque_dt = request('cheque_dt');
                        $pay->bank_name = request('bank_name');
                        $pay->ifs_code  = request('ifs_code');
                        if($imageName != ''){
                        $imageName = time().'.'.request()->image->getClientOriginalExtension();
                        request()->image->move(public_path('images'), $imageName);
                        }
    
                        $pay->cheque_img = $imageName;
                        $pay->created_by = Auth::user()->id;
                        $pay->save();
                        return redirect()->route('paymentlist');
            }else{
                // return $pay_mode;
                // return $data;
                //  insert record into db
                $data = new PaymentModel;
                $data->trans_date = date('Y-m-d');
                $data->payment_type = $request->udf4;
                $data->payment_mode = $pay_mode;
                $data->soc_id = auth()->user()->soc_id;
                $data->brn_id = Session::get('socuserdtls')->district;
                $data->order_id = $request->txnid;
                $data->amount =  $request->amount;
                $data->invoice_id = $request->udf5;
                $data->email = $request->email;
                $data->contact = $request->phone;
                $data->created_by = auth()->user()->id;
                $data->save();

                return view('payment.advpayment', [
                    'formError'=>$formError,
                    'hash'=>$hash,
                    'action'=>$action,
                    'MERCHANT_KEY'=>$MERCHANT_KEY,
                    'txnid'=>$txnid,
                    'formError'=>$formError,
                    'posted'=>$posted,
                    'SALT'=>$SALT,
                ]);
            }
        }
        
    }



    public function invpaymentrequest(Request $request)
    {      
        // return $request;
        $pay_amt = Session::get('amts');
       
            if($pay_amt > 500000){
                // return $request;
                $data = array(
                    'amount' => Session::get('amts'),
                    'ro_no'  => $request->ro_no,
                    'invoice_id' =>$request->invoice_id,
                    'do_dt' => date('Y-m-d'),
                    'invoice_amt'=>Session::get('amts'),
                    'pay_amt'=>Session::get('amts')
                );
                return view('payment.invpayform', ['data' => $data])->with('amt_error','Maximum allowable amount exceed.');
            }else{ 
                $dt      = $request->input('do_dt');
                $ro_no   = $request->input('ro_no');
                $sale_invoice_no = $request->input('invoice_id');
                $invoice_amt  = $request->input('invoice_amt');
                $pay_mode = $request->input('pay_mode');
                
                if($pay_mode == 'I')
                {
                   
                    $orderId='';
                        Session::put('invoice_id',  $sale_invoice_no);
                        Session::put('orderId',  $orderId);
                        Session::put('soc_id',  Auth::user()->soc_id);
                        Session::put('brn_id',  Session::get('socuserdtls')->district);
                        Session::put('pay_mode',  'I');
                        Session::put('ptype', 'I');
                    $data = array(
                        'order_id' => $orderId,
                        'amount' => $pay_amt * 100,
                        'ro_no'  => $ro_no,
                        'invoice_id' =>$sale_invoice_no,
                        'do_dt' => $dt,
                        'pay_amt'=>$pay_amt
                    );
                    // Session::put('order_id', $orderId);

                    return view('payment.invpaywithrozapay',[
                        'data'=>$data,
                        'hash'=>$hash,
                        'action'=>$action,
                        'MERCHANT_KEY'=>$MERCHANT_KEY,
                        'formError'=>$formError,
                        'txnid'=>$txnid,
                        'txnid'=>$txnid,
                        'posted'=>$posted,
                        'SALT'=>$SALT,
                    ]);

                    // return redirect()->route('invpaywithroza')->with('data', $data);


                }else{

                    $imageName = '';
                    $soc_id =   Auth::user()->soc_id; 
                    // $request->validate([
                    //     'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                    // ]);
                    $pay = new PaymentModel;
                    $pay->trans_date = date('Y-m-d');
                    $pay->payment_type ='I';
                    $pay->soc_id = $soc_id;
                    $pay->brn_id = Session::get('socuserdtls')->district;
                    $pay->amount = $pay_amt;
                    $pay->payment_mode = request('pay_mode');
                    $pay->cheque_no = request('cheque_no');
                    $pay->cheque_dt = request('cheque_dt');
                    $pay->bank_name = request('bank_name');
                    $pay->ifs_code  = request('ifs_code');
                    if($imageName != ''){
                    $imageName = time().'.'.request()->image->getClientOriginalExtension();
                    request()->image->move(public_path('images'), $imageName);
                    }

                    $pay->cheque_img = $imageName;
                    $pay->created_by = Auth::user()->id;
                    $pay->save();
                    return redirect()->route('paymentlist');
                }
        }
    }

    // redirect to redirectToPayU
    public function invpaywithroza(Request $request)
    {   
        // return Session::get('data');
        return view('payment.invpaywithrozapay')->with('data',Session::get('data'));
    }


    public function error(){
     
        $data = $request->all();
        $validHash = $this->checkHasValidHas($data);

        if (!$validHash) {
            echo "Invalid Transaction. Please try again";
        } else {
            echo "<h3>Your order status is ". $data["status"].".</h3>";
            echo "<h4>Your transaction id for this transaction is ".$data["txnid"].". You may try making the payment by clicking the link below.</h4>";
        }
        
        $errorMessage = $data['error_Message'];

        // return $errorMessage;
        return view('payumoney.fail', compact('errorMessage'));

       
        // Session::forget('invoice_id');
        // Session::forget('amts');
        // Session::forget('orderId');
        // Session::forget('soc_id');
        // Session::forget('brn_id');
        // Session::forget('pay_mode');
        // Session::forget('ptype');
        // return view('payment.error',['details'=>$details]);
    }
    public function success(Request $request){

        $input = $request->all();

        dd($input);
        $status = $input["status"];
        $firstname = $input["firstname"];
        $amount = $input["amount"];
        $txnid = $input["txnid"];
        $posted_hash = $input["hash"];
        $key = $input["key"];
        $productinfo = $input["productinfo"];
        $email = $input["email"];
        $salt = config('payu.salt_key');


        if (isset($input["additionalCharges"])) {
            $additionalCharges = $input["additionalCharges"];
            $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        } else {
            $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        }
        $hash = hash("sha512", $retHashSeq);
        if ($hash != $posted_hash) {
            return "Invalid Transaction. Please try again";
        } else {
            echo "<h3>Thank You. Your order status is ".$status.".</h3>";
            echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
            echo "<h4>We have received a payment of Rs. ".$amount.". Your order will soon be shipped.</h4>";
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

    public function FunctionName(Type $var = null)
    {
        $api = new Api($key_id, $secret);
        $api->invoice->create(array ('type' => 'invoice','date' => 1589994898, 'customer_id'=> 'cust_E7q0trFqXgExmT', 'line_items'=>array(array('item_id'=>'item_DRt61i2NnL8oy6'))));
    }

    public function payhistory(){

        DB::enableQueryLog(); 
        $soc_id = Auth::user()->soc_id;
        $br_cd  = Session::get('socuserdtls')->district; 
        $invoice_list = DB::select("select distinct trans_do,do_dt,sale_ro from v_sale 
                                                where br_cd = '$br_cd'
                                                 and soc_id='$soc_id'
                                                 and round_tot_amt-paid_amt > 0 
                                                 and trans_do IN (SELECT invoice_id FROM td_payment where status='captured')
                                                 ");
        return view('payment.invpay_history', ['invoice_list' => $invoice_list]);

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