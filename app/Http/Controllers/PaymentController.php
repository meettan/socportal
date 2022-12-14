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
            $pay->created_by = Auth::user()->id;
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
            $pay->created_by = Auth::user()->id;
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
          //  $data->invoice_id = $details['invoice_id'];
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
            $sdata = PaymentModel::where('order_id',$details['order_id'])->first();
           
        }catch(SignatureVerificationError $e){

            $succes = false;
        }
        if($success){
            // $user->save();
           
            return redirect()->route('success')->with('data', $sdata);
        }else{  
            
            
            return redirect()->route('error')->with('data', $sdata);
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
        echo $payment_id;
    }

    public function paymentdetail(Request $request)
    {
        $order_id  = $request->get('order_id');
        $payment_data = PaymentModel::where('order_id',$order_id)->first();
        return view('payment.payment_detail', ['payment' => $payment_data]);
    }

    public function invpayment(){
        DB::enableQueryLog(); 
        $soc_id = Auth::user()->soc_id;
        $br_cd  = Session::get('socuserdtls')->district; 
        $invoice_list = DB::select("select distinct trans_do,do_dt,sale_ro from v_sale 
                                                where br_cd = '$br_cd'
                                                 and soc_id='$soc_id'
                                                 and round_tot_amt-paid_amt > 0 ");
                                                
           
        return view('payment.invoice_list', ['invoice_list' => $invoice_list]);

    }

    public function invpaymentrequest(Request $request)
    {       
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
            // $api = new Api('rzp_test_OWzJfVy5ZI6cj1', 'PmjFWLtnnGS6AeCQ1Sk2okrH');
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $order  = $api->order->create(array('receipt' => '123', 'amount' => $pay_amt * 100 , 'currency' => 'INR')); // Creates order
            $orderId = $order['id'];
            $pay = new PaymentModel;
            $pay->trans_date = date('Y-m-d');
            $pay->payment_type ='I';
            $pay->soc_id = Auth::user()->soc_id;
            $pay->brn_id = Session::get('socuserdtls')->district;
            $pay->amount = $pay_amt;
            $pay->payment_mode = 'I';
            $pay->order_id = $orderId;
            $pay->invoice_id = $sale_invoice_no;
            $pay->created_by = Auth::user()->id;
            $pay->save();
            $data = array(
                'order_id' => $orderId,
                'amount' => $pay_amt * 100,
                'ro_no'  => $ro_no,
                'invoice_id' =>$sale_invoice_no,
                'do_dt' => $dt,
                'invoice_amt'=>$invoice_amt,
                'pay_amt'=>$pay_amt
            );
            // Session::put('order_id', $orderId);
            return redirect()->route('invpaywithroza')->with('data', $data);
    }
    public function invpaywithroza(Request $request)
    {   
        // return Session::get('data');
        return view('payment.invpaywithrozapay')->with('data',Session::get('data'));
    }


    public function error($payment_id){
     
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $details=$api->payment->fetch($payment_id);
        // $sdata = PaymentModel::where('order_id',$fdetail['order_id'])->first();
        return view('payment.error',['details'=>$details]);
    }
    public function success(Request $request){
        return view('payment.success');
    }

    public function FunctionName(Type $var = null)
    {
        $api = new Api($key_id, $secret);
        $api->invoice->create(array ('type' => 'invoice','date' => 1589994898, 'customer_id'=> 'cust_E7q0trFqXgExmT', 'line_items'=>array(array('item_id'=>'item_DRt61i2NnL8oy6'))));
    }


        

    

}
