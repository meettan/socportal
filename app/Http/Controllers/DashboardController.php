<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard()
    {
      
    $date = date('Y-m-d');
    $soc  = 848;
    $count = 0;
    $opn_amt =0;
    //Getting From date from opening balance table
    $rtndate = DB::select("select max(op_dt) date from   v_soc_opening where  op_dt <= '" . $date . "' and soc_id =" . $soc);
    $maxdate = $rtndate[0]->date;
    //Opening Balance Retrieval
    $rtncount = DB::select("select count(*) row_count from   v_soc_opening where  op_dt = '" . $maxdate . "' and soc_id =" . $soc);
    //$rtncount = $ci->db->query("select count(*) row_count from   td_soc_opening where  op_dt = '" . $maxdate . "' and soc_id =" . $soc)->row();  
 
    if (count($rtncount) > 0) {
   // if ($count > 0 ){
        $rtndata = DB::select("select (-1) * sum(balance) opn_amt
        from   v_soc_opening
        where  soc_id 	= $soc
        and    op_dt    = '".$maxdate."'");
      $opn_amt=$rtndata[0]->opn_amt;
    }else{
      $opn_amt = 0;
    }
    //Advance Amount Retrieval
    $count = 0;
    $rtncount = 0;
    $rtndata  = 0;
    $adv_amt  = 0;
    $rtncount = DB::select("select count(*) row_count from   v_advance  where  soc_id 	= '".$soc."'
    and    trans_type = 'I'
    and    trans_dt between '".$maxdate."' and '".$date."'");
    
    $count = $rtncount[0]->row_count;

    if ($count > 0 ){
      $rtndata = $ci->db->query("select sum(adv_amt)adv_amt
                                 from   v_advance
                                 where  soc_id 	= '".$soc."'
                                 and    trans_type = 'I'
                                 and    trans_dt between '".$maxdate."' and '".$date."'")->row();      
      $adv_amt=$rtndata->adv_amt;
    }else{
      $adv_amt = 0;
    
    }
    //Sale Amount Retrieval
    $count    = 0;
    $rtncount = 0;
    $rtndata  = 0;
    $sale_amt  = 0;

    $rtncount = DB::select("select count(*) row_count from   v_sale  where  soc_id 	= '".$soc."'
    and    do_dt  between '".$maxdate."' and '".$date."'");

    $count = $rtncount[0]->row_count;
    if ($count > 0 ){
      $rtndata = $ci->db->query("select sum((tot_amt))sale_amt
                                 from   v_sale
                                 where  soc_id 	= '".$soc."'
                                 and    do_dt between '".$maxdate."' and '".$date."'")->row();
                                 
      $sale_amt=$rtndata->sale_amt;
    }else{
      $sale_amt = 0;
    }
    //Credit Note Amount Retrieval
    $count    = 0;
    $rtncount = 0;
    $rtndata  = 0;
    $cr_amt   = 0;

  
    $rtncount = DB::select("select count(*) row_count from   v_dr_cr_note  where  soc_id 	= '".$soc."'
    and    trans_flag = 'R' and  recpt_no like '%Crnote%'
    and    trans_dt   between '".$maxdate."' and '".$date."'");

    $count = $rtncount[0]->row_count;

    if ($count > 0 ){
      $rtndata = $ci->db->query("select sum((tot_amt))cr_amt
                                  from   v_dr_cr_note
                                  where  soc_id 	= '".$soc."'
                                  and    trans_flag = 'R'
                                  and    recpt_no like '%Crnote%'
                                  and    trans_dt  between '".$maxdate."' and '".$date."'")->row();
                                  
      $cr_amt=$rtndata->cr_amt;
    }else{
      $cr_amt = 0;
    
    }

    //Other Adjustment Amount Retrieval
    $count    = 0;
    $rtncount = 0;
    $rtndata  = 0;
    $oth_amt   = 0;

    $rtncount = DB::select("select count(*) row_count from   v_payment_recv  where  soc_id 	= '".$soc."'
    and    pay_type not in (2,6)
    and    paid_dt    between '".$maxdate."' and '".$date."'");
  

    $count = $rtncount[0]->row_count;

    if ($count > 0 ){
      $rtndata = $ci->db->query("select sum(((paid_amt)))oth_amt
                                  from   v_payment_recv
                                  where  soc_id 	= '".$soc."'
                                  and    pay_type not in (2,6)
                                  and    paid_dt   between '".$maxdate."' and '".$date."'")->row();
                                  
      $oth_amt=$rtndata->oth_amt;
    }else{
      $oth_amt = 0;
    
    }

    $cls_amt = 0;
    $cls_amt = ($opn_amt + $adv_amt + $cr_amt + $oth_amt) - $sale_amt;

    // $cls_amt;
   
        return view('dashboard');
    }
}
