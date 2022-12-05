<?php

namespace App\Http\Controllers;
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


        

    

}
