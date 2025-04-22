<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use App\userModel;
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
    $soc =   Auth::user()->soc_id;
    $count = 0;
    $opn_amt =0;
    //Getting From date from opening balance table
    $rtndate = DB::select("select max(op_dt) date from   v_soc_opening where  op_dt <= '" . $date . "' and soc_id =" . $soc);
    $maxdate = $rtndate[0]->date;
    //Opening Balance Retrieval
    $rtncount = DB::select("select count(*) row_count from   v_soc_opening where  op_dt = '" . $maxdate . "' and soc_id =" . $soc);

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

      $rtndata = DB::select("select sum(adv_amt)adv_amt
      from   v_advance where  soc_id 	= '".$soc."' and    trans_type = 'I'
      and    trans_dt between '".$maxdate."' and '".$date."'");
      $adv_amt=$rtndata[0]->adv_amt;

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

        $rtndata = DB::select("select sum((tot_amt))sale_amt
        from   v_sale where  soc_id 	= '".$soc."' and    do_dt between '".$maxdate."' and '".$date."'");
        $sale_amt=$rtndata[0]->sale_amt;
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

      // $rtndata = DB::select("select sum((tot_amt))cr_amt
      // from   v_dr_cr_note
      // where  soc_id 	= '".$soc."'
      // and    trans_flag = 'R'
      // and    recpt_no like '%Crnote%'
      // and    trans_dt  between '".$maxdate."' and '".$date."'");
      $rtndata = DB::select("select sum((v_dr_cr_note.tot_amt))cr_amt
      from   v_dr_cr_note,v_sale
      where  v_dr_cr_note.soc_id = '".$soc."'
      and v_dr_cr_note.invoice_no = v_sale.trans_do
      and    v_dr_cr_note.trans_flag = 'R'
      and    v_dr_cr_note.recpt_no like '%Crnote%'
      and    v_dr_cr_note.trans_dt  between '".$maxdate."' and '".$date."'");

      $cr_amt=$rtndata[0]->cr_amt;
    }else{
      $cr_amt = 0;

    }

    //Other Adjustment Amount Retrieval
    $count    = 0;
    $rtncount = 0;
    $rtndata  = 0;
    $oth_amt   = 0;

    $rtncount = DB::select("select count(*) row_count from   v_payment_recv  where  soc_id 	= '".$soc."'
    and    pay_type not in (2,6,8)
    and    paid_dt    between '".$maxdate."' and '".$date."'");


    $count = $rtncount[0]->row_count;

    if ($count > 0 ){

      $rtndata = DB::select("select sum(((paid_amt)))oth_amt
      from   v_payment_recv
      where  soc_id 	= '".$soc."'
      and    pay_type not in (2,6,8)
      and    paid_dt   between '".$maxdate."' and '".$date."'");
      $oth_amt=$rtndata[0]->oth_amt;
    }else{
      $oth_amt = 0;

    }

   // if ($count > 0 ){

      $tcsdata = DB::select("select sum(((tot_amt)))tcs_amt
      from   v_drnote_tcs
      where  soc_id   = '".$soc."'
     and    trans_dt   between '".$maxdate."' and '".$date."'");
     if($tcsdata[0]) {
      $tcs_amt= $tcsdata[0]->tcs_amt;
     }else{
      $tcs_amt= 0;
     }

   // }else{
   //   $tcs_amt = 0;

   // }

    $cls_amt = 0;
    $cls_amt = ($opn_amt + $adv_amt + $cr_amt + $oth_amt) - ($sale_amt + $tcs_amt) ;
    $soc_balance_amt = $cls_amt;
    // $soc_balance_amt = $count;
    if ($soc_balance_amt < 0) {
			$soc_balance_amt_data = "Dr.";
		} else {
			$soc_balance_amt_data =  "Cr.";
		}

        return view('dashboard',['soc_balance_amt_data'=>$soc_balance_amt_data,'amt'=>abs($soc_balance_amt)]);
    }
    public function profile()
    {
      $id = Auth::user()->id;
      $user = userModel::where('id', $id)->first();
      return view('profile',['users'=>$user]);
    }
    public function profile_update(Request $request){

        $User = userModel::find(request('id'));
        $User->soc_name = request('soc_name');
        $User->email = request('email');
        $User->soc_address = request('soc_address');
        $User->gstin = request('gstin');
        $User->mfms =request('mfms');
        $User->ph_number =request('ph_number');
        $User->updated_by =Auth::user()->pan;
        $User->save();
        Session::flash('msg','Registration is successfully');
        return redirect()->route('profile');
    }
    public function password_update(Request $request){

      $pan = Auth::user()->pan;
      $id  = Auth::user()->id;
      if (Auth::attempt(['pan' => $pan, 'password' => $request->old_password])) {
        $User = userModel::find($id);
        $User->password = Hash::make(request('password'));
        $User->updated_by =Auth::user()->pan;
        $User->save();
        Session::flash('success','Password change successfully');
        return redirect()->route('profile');
      }else{
        Session::flash('error','Password not change. Old password is not correct');
        return redirect()->route('profile');
      }

    }
}
