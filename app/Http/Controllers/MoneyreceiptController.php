<?php

namespace App\Http\Controllers;
use App\Helper;
use Illuminate\Http\Request;
use Auth;
use DB;

class MoneyreceiptController extends Controller
{
    public function socpayment(Request $request)
    {  
        DB::enableQueryLog();
        $soc_id =   Auth::user()->soc_id;  
        $payrct = DB::select("select distinct a.paid_id,a.sl_no,a.paid_dt paid_dt,a.soc_id,b.soc_name,a.ro_no,c.comp_id,c.prod_id,d.prod_desc,c.rate,c.ro_no as pur_inv,a.approval_status,sum(a.paid_amt)amount,0 as sale_qty,a.sale_invoice_no
		from  v_payment_recv a , v_ferti_soc b,v_purchase c,v_product d
		where a.soc_id=b.soc_id
		and a.ro_no=c.ro_no
		and c.prod_id = d.prod_id
        and a.soc_id='1349'
		group by a.sl_no,a.paid_id,a.paid_dt,a.soc_id,b.soc_name,a.ro_no,c.comp_id,c.prod_id,d.prod_desc,c.rate,c.ro_no,a.approval_status,a.sale_invoice_no
		union
		select a.paid_id,a.sl_no,a.paid_dt,a.soc_id,b.soc_name,a.ro_no,a.comp_id,a.prod_id,d.prod_desc,a.ro_rt,a.ro_no as pur_inv,a.approval_status,sum(a.paid_amt)amount,0 as sale_qty,a.sale_invoice_no
		from  v_payment_recv a , v_ferti_soc b, v_product d
		where a.soc_id=b.soc_id	
		and a.prod_id = d.prod_id
		and a.soc_id='1349'
		group by a.sl_no,a.paid_id,a.paid_dt,a.soc_id,b.soc_name,a.ro_no,a.comp_id,a.prod_id,d.prod_desc,a.ro_rt,a.ro_no,a.approval_status,a.sale_invoice_no
		order by paid_dt");
        return view('moneyreceipt_list', ['soc_pay' => $payrct]);
    }
    public function moneyrecpt(Request $request)
    {
        
        $soc_id =   Auth::user()->soc_id;
        $receipt_no = $request->paid_id;
        $data = DB::select("SELECT a.paid_id,a.paid_dt,b.soc_name,c.bank_name,a.sale_invoice_no,a.bnk_id,a.remarks,sum(a.paid_amt)as amt 
        FROM v_payment_recv a,v_ferti_soc b,v_feri_bank c
        WHERE a.soc_id=b.soc_id
        and a.bnk_id=c.sl_no
        and a.paid_id='$receipt_no'
        group by a.paid_id,a.paid_dt,b.soc_name,a.sale_invoice_no,a.bnk_id,c.bank_name,a.remarks");

        return view('moneyreceipt', ['data' => $data[0]]);

    }
}
