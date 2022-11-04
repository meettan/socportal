<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use PDF;
class SocietyController extends Controller
{  
   public function __construct()
    {
        $this->middleware('auth');
    }
    public function socledger(Request $request){
        DB::enableQueryLog();

        if ($request->isMethod('post')) {
        //$soc_id =   Auth::user()->soc_id; 
        $soc_id = Auth::user()->soc_id; 
        $frmDt  =   $request->from_date;
        $toDt  =   $request->to_date;
        $data = DB::select("select  trans_dt,prod,inv_no, soc_id,soc_name,sum(paid_amt) as tot_paid,sum(paybl) as tot_payble,sum(cgst)cgst,sum(sgst)sgst,ro_no,ro_dt,sum(qty) qty ,sum(tot_recv) tot_recv,remarks
        from( 
          SELECT c.op_dt as trans_dt,'' prod,'' as inv_no, c.soc_id soc_id,b.soc_name,if(sum(c.balance)<0,
          sum(c.balance),0) as paid_amt,
          0 paybl,0 cgst,0 sgst,''ro_no,'' as ro_dt,0 as qty,
            if(sum(c.balance)>0,sum(c.balance),0) tot_recv ,'Opening' remarks
            FROM v_soc_opening c,v_ferti_soc b 
            where c.soc_id=b.soc_id 
            and c.soc_id = '$soc_id'
            and c.op_dt='$frmDt'
           union
            SELECT paid_dt,'' prod,c.paid_id  as inv_no, c.soc_id soc_id,soc_name,0 as paid_amt,0 paybl,0 cgst,0 sgst,''ro_no,d.ro_dt as ro_dt,0 as qty,
            sum(c.paid_amt) tot_recv ,'Cheque Adj' remarks
            FROM v_payment_recv c,v_ferti_soc b,v_purchase d where c.soc_id=b.soc_id and c.soc_id = '$soc_id'
             and c.ro_no = d.ro_no
            and c.pay_type=3 
            and c.paid_dt between '$frmDt' and '$toDt' group by soc_name,c.soc_id,c.paid_id,d.ro_dt,paid_dt
             Union
             SELECT paid_dt,'' prod,c.paid_id  as inv_no, c.soc_id soc_id,soc_name,0 as paid_amt,0 paybl,0,0,'' ro_no,d.ro_dt as ro_dt,0 as qty ,sum(c.paid_amt) tot_recv , 'Draft Adj' remarks
             FROM v_payment_recv c,v_ferti_soc b,v_purchase d where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.ro_no = d.ro_no 
             and c.pay_type=4 
             and c.paid_dt between '$frmDt' and '$toDt' group by soc_name,c.soc_id,c.paid_id,d.ro_dt,paid_dt
             Union
             SELECT paid_dt,'' prod,c.paid_id  as inv_no, c.soc_id soc_id,soc_name,0 as paid_amt,0 paybl,0,0,'' as ro_no,d.ro_dt as ro_dt,0 as qty,sum(c.paid_amt) tot_recv ,'Pay Order Adj' remarks
             FROM v_payment_recv c,v_ferti_soc b,v_purchase d where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.ro_no = d.ro_no and c.pay_type=5 and c.paid_dt between '$frmDt' and '$toDt' group by soc_name,c.soc_id,c.paid_id,d.ro_dt,paid_dt
             Union
             SELECT paid_dt,'' prod,c.paid_id as inv_no, c.soc_id soc_id,soc_name,0 as paid_amt,0 paybl,0,0,'' ro_no,d.ro_dt as ro_dt,0 as qty ,sum(c.paid_amt) tot_recv ,'NEFT Adj' remarks
             FROM v_payment_recv c,v_ferti_soc b,v_purchase d where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.ro_no = d.ro_no and c.pay_type=7 and c.paid_dt between '$frmDt' and '$toDt' group by soc_name,c.soc_id,c.paid_id,d.ro_dt,paid_dt
         Union
         SELECT trans_dt,'' prod,recpt_no as inv_no, c.soc_id soc_id,soc_name,c.tot_amt as paid_amt,0 paybl,0,0,c.ro as ro_no,trans_dt as ro_dt,0 as qty ,0,'Cr note' remarks
            FROM v_dr_cr_note c,v_ferti_soc b,v_sale d where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.invoice_no = d.trans_do and c.trans_flag='R' and c.trans_dt between '$frmDt' and '$toDt' 
         Union
         SELECT trans_dt,'' prod,receipt_no as inv_no, c.soc_id soc_id,soc_name,c.adv_amt as paid_amt,0 paybl,0,0,''as ro_no,trans_dt as ro_dt,0 as qty ,0,'Advance' remarks
            FROM v_advance c,v_ferti_soc b where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.trans_type='I' and c.trans_dt between '$frmDt' and '$toDt'
         Union
         SELECT c.do_dt,e.prod_desc prod,c.trans_do as inv_no, c.soc_id,b.soc_name,0 tot_paid ,c.taxable_amt as tot_payble,c.cgst ,c.sgst,c.sale_ro,d.ro_dt,c.qty ,0,'Sale' remarks
            FROM v_ferti_soc b ,v_sale c,v_purchase d ,v_product e
            where c.br_cd=b.district  
            and c.soc_id=b.soc_id and b.soc_id = '$soc_id'
            and c.sale_ro = d.ro_no and c.do_dt between '$frmDt' and '$toDt' 
            and c.prod_id=e.prod_id
           )a
            group by soc_id,soc_name,ro_no,ro_dt,inv_no,trans_dt,remarks,prod 
            ORDER BY `a`.`trans_dt`,`a`.`inv_no`");

        return view('societyledger', ['all_data' => $data,'frmDt'=>$frmDt,'toDt'=>$toDt]);
        
      }else{
         return view('societyledger', ['all_data' => '']);
      }
      

    }
    public function socledgerrep(Request $request){

        $soc_id =  Auth::user()->soc_id; 
        $frmDt  =   $request->from_date;
        $toDt  =   $request->to_date;
        $data = DB::select("select  trans_dt,prod,inv_no, soc_id,soc_name,sum(paid_amt) as tot_paid,sum(paybl) as tot_payble,sum(cgst)cgst,sum(sgst)sgst,ro_no,ro_dt,sum(qty) qty ,sum(tot_recv) tot_recv,remarks
        from( 
          SELECT c.op_dt as trans_dt,'' prod,'' as inv_no, c.soc_id soc_id,b.soc_name,if(sum(c.balance)<0,
          sum(c.balance),0) as paid_amt,
          0 paybl,0 cgst,0 sgst,''ro_no,'' as ro_dt,0 as qty,
            if(sum(c.balance)>0,sum(c.balance),0) tot_recv ,'Opening' remarks
            FROM v_soc_opening c,v_ferti_soc b 
            where c.soc_id=b.soc_id 
            and c.soc_id = '$soc_id'
            and c.op_dt='$frmDt'
           union
            SELECT paid_dt,'' prod,c.paid_id  as inv_no, c.soc_id soc_id,soc_name,0 as paid_amt,0 paybl,0 cgst,0 sgst,''ro_no,d.ro_dt as ro_dt,0 as qty,
            sum(c.paid_amt) tot_recv ,'Cheque Adj' remarks
            FROM v_payment_recv c,v_ferti_soc b,v_purchase d where c.soc_id=b.soc_id and c.soc_id = '$soc_id'
             and c.ro_no = d.ro_no
            and c.pay_type=3 
            and c.paid_dt between '$frmDt' and '$toDt' group by soc_name,c.soc_id,c.paid_id,d.ro_dt,paid_dt
             Union
             SELECT paid_dt,'' prod,c.paid_id  as inv_no, c.soc_id soc_id,soc_name,0 as paid_amt,0 paybl,0,0,'' ro_no,d.ro_dt as ro_dt,0 as qty ,sum(c.paid_amt) tot_recv , 'Draft Adj' remarks
             FROM v_payment_recv c,v_ferti_soc b,v_purchase d where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.ro_no = d.ro_no 
             and c.pay_type=4 
             and c.paid_dt between '$frmDt' and '$toDt' group by soc_name,c.soc_id,c.paid_id,d.ro_dt,paid_dt
             Union
             SELECT paid_dt,'' prod,c.paid_id  as inv_no, c.soc_id soc_id,soc_name,0 as paid_amt,0 paybl,0,0,'' as ro_no,d.ro_dt as ro_dt,0 as qty,sum(c.paid_amt) tot_recv ,'Pay Order Adj' remarks
             FROM v_payment_recv c,v_ferti_soc b,v_purchase d where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.ro_no = d.ro_no and c.pay_type=5 and c.paid_dt between '$frmDt' and '$toDt' group by soc_name,c.soc_id,c.paid_id,d.ro_dt,paid_dt
             Union
             SELECT paid_dt,'' prod,c.paid_id as inv_no, c.soc_id soc_id,soc_name,0 as paid_amt,0 paybl,0,0,'' ro_no,d.ro_dt as ro_dt,0 as qty ,sum(c.paid_amt) tot_recv ,'NEFT Adj' remarks
             FROM v_payment_recv c,v_ferti_soc b,v_purchase d where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.ro_no = d.ro_no and c.pay_type=7 and c.paid_dt between '$frmDt' and '$toDt' group by soc_name,c.soc_id,c.paid_id,d.ro_dt,paid_dt
         Union
         SELECT trans_dt,'' prod,recpt_no as inv_no, c.soc_id soc_id,soc_name,c.tot_amt as paid_amt,0 paybl,0,0,c.ro as ro_no,trans_dt as ro_dt,0 as qty ,0,'Cr note' remarks
            FROM v_dr_cr_note c,v_ferti_soc b,v_sale d where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.invoice_no = d.trans_do and c.trans_flag='R' and c.trans_dt between '$frmDt' and '$toDt' 
         Union
         SELECT trans_dt,'' prod,receipt_no as inv_no, c.soc_id soc_id,soc_name,c.adv_amt as paid_amt,0 paybl,0,0,''as ro_no,trans_dt as ro_dt,0 as qty ,0,'Advance' remarks
            FROM v_advance c,v_ferti_soc b where c.soc_id=b.soc_id and c.soc_id = '$soc_id' and c.trans_type='I' and c.trans_dt between '$frmDt' and '$toDt'
         Union
         SELECT c.do_dt,e.prod_desc prod,c.trans_do as inv_no, c.soc_id,b.soc_name,0 tot_paid ,c.taxable_amt as tot_payble,c.cgst ,c.sgst,c.sale_ro,d.ro_dt,c.qty ,0,'Sale' remarks
            FROM v_ferti_soc b ,v_sale c,v_purchase d ,v_product e
            where c.br_cd=b.district  
            and c.soc_id=b.soc_id and b.soc_id = '$soc_id'
            and c.sale_ro = d.ro_no and c.do_dt between '$frmDt' and '$toDt' 
            and c.prod_id=e.prod_id
           )a
            group by soc_id,soc_name,ro_no,ro_dt,inv_no,trans_dt,remarks,prod 
            ORDER BY `a`.`trans_dt`,`a`.`inv_no`");

      $pdf = PDF::loadView('societyledgerrep', ['all_data' => $data]);
      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');
        
    }
    public function purrep(Request $request){
      if ($request->isMethod('post')) {
      $soc_id =  Auth::user()->soc_id;
      $frmDt  =   $request->from_date;
      $toDt  =   $request->to_date;
      $data = DB::select("select a.trans_do,a.do_dt,a.trans_type,a.sale_ro,a.qty,a.soc_id,b.unit,b.QTY_PER_BAG as qty_per_bag,
      a.sale_rt,a.taxable_amt,a.cgst,a.sgst,a.dis,a.tot_amt,c.short_name,b.PROD_DESC
                     from v_sale a,v_product b,v_company_dtls c
                     where  a.prod_id = b.PROD_ID
                     and    a.comp_id = c.COMP_ID
                     and    a.soc_id   = '$soc_id'
                     and    a.do_dt between '$frmDt' and '$toDt'
                     order by c.short_name, a.do_dt");
           
      return view('societypur', ['all_data' => $data,'frmDt'=>$frmDt,'toDt'=>$toDt]);

      }else{

         return view('societypur', ['all_data' => '']);
      }
    }
}
