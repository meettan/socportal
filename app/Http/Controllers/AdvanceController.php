<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use Helper;


class AdvanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Display Advance filter for society to get advance list using date range
    // From date and to date is required filed using table v_advance,v_ferti_soc as the view of 
    // fertilizer portal td_advance and mm_ferti_soc 
    public function advancefilter(Request $request)
    {   DB::enableQueryLog();
        if ($request->isMethod('post')) {
        $soc_id =   Auth::user()->soc_id; 
        $frmDt  =   Helper::dateformat($request->from_date);
		$todt   =   Helper::dateformat($request->to_date); 
        $dr_notes = DB::select("select a.trans_dt,a.receipt_no,a.soc_id,a.trans_type,b.soc_name,a.adv_amt,a.forward_flag forward_flag,
        (SELECT count(*) no_of_rcpt FROM v_adv_details c where a.receipt_no=c.receipt_no)as no_of_rcpt
         FROM v_advance a, v_ferti_soc b
            WHERE a.soc_id = b.soc_id
            AND  a.trans_dt >= '$frmDt'
            AND  a.trans_dt <= '$todt'
            AND  a.soc_id = $soc_id");
                   
            return view('advance', ['data' => $dr_notes]);

        }else{

            return view('advance', ['data' => '']);
        }
    }
    // Display Advance report filter of society using receipt no 
    //  using table v_advance,v_ferti_soc as the view of 
    // fertilizer portal td_advance and mm_ferti_soc 
    public function socadvReport(Request $request){
        DB::enableQueryLog();
        $soc_id =   Auth::user()->soc_id;
        $receipt_no = $request->receipt_no;
	    $adv['receipt_no'] = $receipt_no;  
        $adv = DB::select("select  a.trans_dt,a.sl_no,a.receipt_no,a.soc_id,b.soc_name,a.trans_type, a.adv_amt,a.inv_no,a.ro_no,a.remarks
        from v_advance a ,v_ferti_soc b
        where a.soc_id=b.soc_id
        and a.receipt_no='$receipt_no' ");
        // return $adv;
        return view('advreceipt', ['data' => $adv[0]]);

    }
}
