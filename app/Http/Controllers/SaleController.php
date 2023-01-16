<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Http;
use PDF;
use Helper;

class SaleController extends Controller
{   
	public function __construct()
    {
        $this->middleware('auth');
    }
    // Dispaly sale filter form and gettting data of society on date range of Sales
	// with using  table v_sale, v_ferti_soc, v_product  as view of fertilizer portal table
	//td_sale ,mm_ferti_soc,mm_product . 
    public function salesfilter(Request $request){

        DB::enableQueryLog();
		if ($request->isMethod('post')) {
			$soc_id =   Auth::user()->soc_id; 
			$frmDt  =   Helper::dateformat($request->from_date);
			$todt   =   Helper::dateformat($request->to_date);  

        $payrct = DB::select("select a.irn, a.ack,a.ack_dt,a.trans_do,a.do_dt,a.trans_type,b.soc_name,sum(a.tot_amt) as tot_amt,c.prod_desc,a.gst_type_flag,
        (select count(paid_id) from v_payment_recv where sale_invoice_no=a.trans_do) as pay_cnt
          from v_sale a,v_ferti_soc b,v_product c
          where a.soc_id='$soc_id' 
          and a.prod_id=c.prod_id
          and a.soc_id=b.soc_id
		  and a.do_dt >='$frmDt'
		  and a.do_dt <='$todt'
          group by a.irn,a.ack,a.ack_dt,a.trans_do,a.do_dt,a.trans_type,b.soc_name,c.prod_desc,a.gst_type_flag,pay_cnt
          order by a.do_dt desc");
            return view('sale_list', ['sales' => $payrct]);
		}else{
			return view('sale_list', ['sales' => '']);
		}
    }
   // print sale receipt of society of particular sale using IRN number of sale
   // using cleartax api 

    public function saleinvoice_rep(Request $request)
	{
		
			//$trans_do =$request->trans_do;
			$trans_do = 'INV/HOG/IFFCO/01/22-23/4635_1';
			$data = DB::select("SELECT a.trans_do ,b.prod_desc ,b.hsn_code,b.gst_rt,c.soc_name,c.soc_add,
		                           c.gstin,c.mfms,a.trans_no,a.do_dt,a.sale_due_dt,a.trans_type,a.soc_id,
								   a.comp_id, a.sale_ro,a.stock_point,a.gov_sale_rt,a.qty,a.sale_rt,
								   a.base_price,a.taxable_amt,a.cgst,a.sgst,a.dis,a.tot_amt,
								   a.round_tot_amt,a.paid_amt,d.ro_no,d.ro_dt
								   from v_sale a  ,v_product b,v_ferti_soc c,v_purchase d
								   where a.prod_id=b.prod_id
								   and a.sale_ro=d.ro_no
								   and a.irn is NULL
								   and a.gst_type_flag='N'
								   and a.soc_id=c.soc_id
								   and a.trans_do='$trans_do'");

			$sum_data = DB::select("SELECT a.trans_do ,sum(a.qty)as qty,sum(a.base_price) as base_price,
									sum(a.taxable_amt)as taxable_amt,sum(a.cgst)as cgst,sum(a.sgst)as sgst,
									sum(a.cgst+a.sgst)as tot_gst,sum(a.dis)as dis,sum(a.tot_amt)as tot_amt,
									sum(a.paid_amt) as paid_amt,ROUND(sum(a.round_tot_amt))as tot_amt_rnd
									from v_sale a 
									where  a.trans_do='$trans_do'");				   
		 
			return view('sale_invoice.blade', ['data' => $data[0],'sum_data' => $sum_data[0],'trans_do' =>$trans_do ]);
			
	}
   
    public function print_receipt(Request $request){

        $irns =$request->irn;
        $filename = $irns . '.pdf';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            /*****************for test server ******************* */
        //CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v2/eInvoice/download?template=62cfd0a9-d1ed-47b0-b260-fe21f57e9c5e&format=PDF&irns=' . $irns,
        
        CURLOPT_URL => 'https://api-einv.cleartax.in/v2/eInvoice/download?template=62cfd0a9-d1ed-47b0-b260-fe21f57e9c5e&format=PDF&irns=' . $irns,
        
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-cleartax-auth-token: 1.249874fd-e3cd-402c-a503-b0a47cb0711f_3d64af076bfe30480c2e74d59d4d5017d2fd57d429bc3364908b5f0ae91a7a51',
            'x-cleartax-product: EInvoice' ,
            'owner_id: fded77f8-4880-4dc6-8b6c-9d23f3374517',
            'gstin: 19AABAT0010H2ZY'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return response()->streamDownload(function () use ($response) {
            echo $response;
        }, $filename);
    
    }
	// print sale receipt of society of particular sale using IRN number of sale
   // using cleartax api Demo test for download pdf
    public function print_receipt1(Request $request){

            $irns =$request->irn;
            $filename = $irns . '.pdf';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                /*****************for test server ******************* */
            //CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v2/eInvoice/download?template=62cfd0a9-d1ed-47b0-b260-fe21f57e9c5e&format=PDF&irns=' . $irns,
            CURLOPT_URL => 'https://api-einv.cleartax.in/v2/eInvoice/download?template=62cfd0a9-d1ed-47b0-b260-fe21f57e9c5e&format=PDF&irns=' . $irns,
            
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-cleartax-auth-token: 1.249874fd-e3cd-402c-a503-b0a47cb0711f_3d64af076bfe30480c2e74d59d4d5017d2fd57d429bc3364908b5f0ae91a7a51',
                'x-cleartax-product: EInvoice' ,
                'owner_id: fded77f8-4880-4dc6-8b6c-9d23f3374517',
                'gstin: 19AABAT0010H2ZY'
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $data = $response;
            $set_mime = FALSE;
        if ($filename === '' OR $data === '')
		{
			return;
		}
		elseif ($data === NULL)
		{
			if ( ! @is_file($filename) OR ($filesize = @filesize($filename)) === FALSE)
			{
				return;
			}

			$filepath = $filename;
			$filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
			$filename = end($filename);
		}
		else
		{
			$filesize = strlen($data);
		}

		// Set the default MIME type to send
		$mime = 'application/octet-stream';

		$x = explode('.', $filename);
		$extension = end($x);

		if ($set_mime === TRUE)
		{
			if (count($x) === 1 OR $extension === '')
			{
				/* If we're going to detect the MIME type,
				 * we'll need a file extension.
				 */
				return;
			}

			// Load the mime types
			$mimes =& get_mimes();
			// Only change the default MIME if we can find one
			if (isset($mimes[$extension]))
			{
				$mime = is_array($mimes[$extension]) ? $mimes[$extension][0] : $mimes[$extension];
			}
		}

		/* It was reported that browsers on Android 2.1 (and possibly older as well)
		 * need to have the filename extension upper-cased in order to be able to
		 * download it.
		 *
		 * Reference: http://digiblog.de/2011/04/19/android-and-the-download-file-headers/
		 */
		if (count($x) !== 1 && isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Android\s(1|2\.[01])/', $_SERVER['HTTP_USER_AGENT']))
		{
			$x[count($x) - 1] = strtoupper($extension);
			$filename = implode('.', $x);
		}

		if ($data === NULL && ($fp = @fopen($filepath, 'rb')) === FALSE)
		{
			return;
		}

		// Clean output buffer
		if (ob_get_level() !== 0 && @ob_end_clean() === FALSE)
		{
			@ob_clean();
		}

		// Generate the server headers
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Expires: 0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.$filesize);
		header('Cache-Control: private, no-transform, no-store, must-revalidate');

		// If we have raw data - just dump it
		if ($data !== NULL)
		{
			exit($data);
		}

		// Flush 1MB chunks of data
		while ( ! feof($fp) && ($data = fread($fp, 1048576)) !== FALSE)
		{
			echo $data;
		}
		fclose($fp);
		exit;    
    }    
    
}