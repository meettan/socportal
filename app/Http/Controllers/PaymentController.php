<?php

namespace App\Http\Controllers;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Session;
use Illuminate\Http\Request;
use Auth;
use App\PaymentModel;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // public $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
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

    public function invpayment(){

        //return view('payment/paymenthome');
    }
    public function paymentlist(){

        $payment_list = PaymentModel::orderBy('id', 'DESC')->get();
        return view('payment.payment_list', ['payment_list' => $payment_list]);

    }

    public function paymentrequest(Request $request){
        $pay_mode = $request->input('pay_mode');
        if($pay_mode == 'I')
        {
            $name = $request->input('name');
            $amount = $request->input('amt');
            // $api = new Api('rzp_test_OWzJfVy5ZI6cj1', 'PmjFWLtnnGS6AeCQ1Sk2okrH');
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
            $orderId = $order['id'];
            $pay = new PaymentModel;
            $pay->trans_date = date('Y-m-d');
            $pay->payment_type =request('ptype');
            $pay->soc_id = Auth::user()->soc_id;
            $pay->brn_id = Session::get('socuserdtls')->district;
            $pay->amount = request('amt');
            $pay->payment_mode = request('pay_mode');
            $pay->order_id = $orderId;
            $pay->created_by = 'demo';
            $pay->save();
            $data = array(
                'order_id' => $orderId,
                'amount' => $amount * 100
            );
            // Session::put('order_id', $orderId);
            return redirect()->route('paywithroza')->with('data', $data);
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
            $pay->created_by = 'demo';
            $pay->save();
            return redirect()->route('paymentlist');
       }
    }
    
    public function paywithroza(Request $request)
    {   
        // return Session::get('data');
        return view('payment.paywithrozapay')->with('data',Session::get('data'));
    }

    public function pay(Request $request){
        $data = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try{
            $attributes = array(
                'razorpay_signature' => $data['razorpay_signature'],
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_order_id' => $data['razorpay_order_id']
            );
            $order = $api->utility->verifyPaymentSignature($attributes);
            $details=$api->payment->fetch($data['razorpay_payment_id']);
            
            $data = PaymentModel::where('order_id',$details['order_id'])->first();
            $data->payment_id = $details['id'];
            $data->signature = $data['razorpay_signature'];
            $data->status = $details['status'];
            $data->invoice_id = $details['invoice_id'];
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
            $data->payment_at = $details['created_at'];
            $data->save();
            $success = true;
        }catch(SignatureVerificationError $e){

            $succes = false;
        }
        if($success){
            // $user->save();
            return redirect()->route('success');
        }else{

            return redirect()->route('error');
        }
    }

    public function failedresponse(Request $request)
    {
        $order_id = $request->order_id;
        $payment_id =  $request->payment_id;
        $code       =  $request->code;
        $description  =  $request->description;
        $data = PaymentModel::where('order_id',$order_id)->first();
        $data->payment_id = $payment_id;
        $data->status = $request->reason.' '.$description;
        $data->payment_at = strtotime(date("Y-m-d h:i:s"));
        $data->save();
        echo '1';
    }

    public function paymentdetail(Request $request)
    {
        $order_id  = $request->get('order_id');
        $payment_data = PaymentModel::where('order_id',$order_id)->first();
        return view('payment.payment_detail', ['payment' => $payment_data]);
    }




    public function error(){
        return view('payment.error');
    }
    public function success(){
        return view('payment.success');
    }


        

    

}
