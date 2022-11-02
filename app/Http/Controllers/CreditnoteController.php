<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Auth;
use DB;
class CreditnoteController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function drcrnote(Request $request)
    {   DB::enableQueryLog();

        if ($request->isMethod('post')) {
        $soc_id =   Auth::user()->soc_id;
        $frmDt  =   $request->from_date;
        $todt   =   $request->to_date;  
        $dr_notes = DB::select("SELECT b.soc_name,a.recpt_no, 
         (select nwirn from v_sale_cancel where trans_do=a.invoice_no) as irn,
          a.trans_dt, a.trans_no, a.soc_id, sum(a.tot_amt)tot_amt,a.trans_flag,a.invoice_no,
          a.fwd_flag FROM v_dr_cr_note a, v_ferti_soc b
            WHERE a.soc_id = b.soc_id 
            AND a.trans_flag = 'R' 
            AND a.soc_id = '$soc_id'
            AND a.note_type = 'D' 
            AND a.trans_dt >= '$frmDt' AND a.trans_dt <= '$todt'group by a.invoice_no,a.recpt_no,a.trans_dt,a.trans_no, a.soc_id,a.fwd_flag ORDER BY a.trans_dt");
           return view('drcrnote', ['dr_notes' => $dr_notes]);
        }else{

            return view('drcrnote', ['dr_notes' => '']);
        }
    }

    public function drnoteReport(Request $request)
    {
        $receipt_no = $request->invoice_no;
        $cr['receipt_no'] = $receipt_no;
       $cr = DB::select("select a.trans_dt,a.recpt_no,a.trans_no,a.soc_id,b.soc_name,b.gstin,a.comp_id,a.invoice_no,a.ro,a.catg,sum(a.tot_amt) as tot_amt ,a.trans_flag,a.note_type,a.remarks,c.cat_desc
       from v_dr_cr_note a ,v_ferti_soc b,v_cr_note_category c
        where a.soc_id=b.soc_id and  a.catg = c.sl_no
        and invoice_no ='$receipt_no'
        group by c.cat_desc,a.trans_dt,a.recpt_no,a.trans_no,a.soc_id,b.soc_name,b.gstin,a.comp_id,a.invoice_no,a.ro,a.trans_flag,a.note_type,a.remarks,a.catg");
        return view('drcrnoterp', ['data' => $cr]);
    }
}
