@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Ledger</h2>
                <div class="dateCalenderSec"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <?php if (date('m') <= 4) {//Upto June 2014-2015
                                    $financial_yearst = (date('Y')-1).'-04-01';
                                } else {//After June 2015-2016
                                    $financial_yearst = date('Y').'-04-01' ;
                                }
                        ?>
                        <div class="wrapper_fixed">
                            <form method="POST" action="{{ url('socledger') }}" id='signupForm' class="validatedForm">
                                @csrf
                                <div class="row groupDataStatFrom">
                                    <label for="to_date" class="col-sm-2 col-form-label">From Date:</label>
                                    <div class="col-md-3">
                                        <input type="date" name="from_date" class="form-control required" value="<?=$financial_yearst?>"
                                            min='' readonly/>
                                    </div>
                                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                                    <div class="col-md-3">
                                        <input type="date" name="to_date" id='to_date' class="form-control" value="<?=$toDt?>"  required/>
                                    </div>
                                    <div class="col-md-2"><input type="submit"
                                            class="btn btn-primary form-control required"></div>
                                </div>
                            </form>
                            <div class="row">
                                <?php   if($all_data) {    ?>
                                <div class="col-lg-12 contant-wraper">

                                    <div id="divToPrint" class="divToPrintClass">
                                        <div class="topPrintHeadMain">
                                            <div class="topPrintLogo"><img src="{{ url('public/images/logo.png') }}"
                                                    alt="" /></div>
                                            <div class="topPrintLogoRight">
                                                <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                                                <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, <br>
                                                    1582 RAJDANGA MAIN ROAD,
                                                    KOLKATA-700107.</h4>
                                                <h4 class="h4CustomPrintTop">Society Ledger Between:
                                                    <?php echo date('d/m/Y',strtotime($frmDt)); ?>
                                                    To <?php echo date('d/m/Y',strtotime($toDt)); ?></h4>
                                            </div>
                                        </div>

                                        <div class="gstNumberSec">
                                            <h5 style="text-align:left">
                                                <label>Society: </label> <?php $soc_name = Auth::user()->soc_name; echo $soc_name;?><br>
                                                <label>Gst No: </label>
                                                <?php $gstin = Auth::user()->gstin; echo $gstin;?>
                                            </h5>
                                        </div>

                                        <div class="table-responsive">
                                            <table style="width: 100%;" id="" class="table table-striped">
                                                <thead>

                                                    <tr>
                                                        <th>Sl No.</th>
                                                        <th>Remarks</th>
                                                        <th>Date</th>

                                                        <th>Invoice/
                                                            Receipt No.</th>
                                                        <th>Sale
                                                            Amount</th>
                                                        <th>Advance/
                                                            Credit Note</th>
                                                        <th>Adjusted
                                                            Amount
                                                            (Cheque/<br>Draft/
                                                            Payorder/NEFT/
                                                            RTGS)
                                                        </th>
                                                        <th>Dr</th>
                                                        <th>Cr</th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <?php

                                if($all_data){ 
									
                                    $i = 1;
                                    $total = 0.00;
                                    $tot_sale = 0.00;
                                    $tot_pur  = 0.00;
                                    $taxable=0.00;
                                    $val =0;
                                    $qty=0.000;
                                    $tot_cgst=0.00;
                                    $tot_sgst=0.00;
                                    $totalamount=0.00;
                                    $advCrnote=0.00;
                                    $adjustable=0.00;
                                    $saleAmt=0.00;
                                    $totalamt=0.00;

                                    foreach($all_data as $prodtls){
                            ?>

                                                    <tr class="rep">
                                                        <td class="report"><?php echo $i++; ?></td>
                                                        <!--SL. No.--->
                                                        <td><?php echo $prodtls->remarks; ?></td>
                                                        <!--Remarks--->
                                                        <td class="report opening" id="opening">
                                                            <!--Date--->
                                                            <?php echo date('d/m/Y',strtotime($prodtls->trans_dt)); ?>
                                                        </td>
                                                        <!-- <td><?php //echo $prodtls->prod; ?></td>                                -->
                                                        <td><?= $prodtls->inv_no; ?></td>
                                                        <!--Invoice/Receipt no.--->
                                                        <td class="report sale" id="sale">
                                                            <!--Total Amount--->
                                                            <?php  echo  $prodtls->tot_payble +$prodtls->cgst + $prodtls->sgst;  
                                                $totalamount += $prodtls->tot_payble +$prodtls->cgst + $prodtls->sgst;
                                                $saleAmt += $prodtls->tot_payble +$prodtls->cgst + $prodtls->sgst; ?>
                                                        </td>
                                                        <td>
                                                            <!--Advance/Credit Note Amount--->
                                                            <?php  if($prodtls->remarks=='Opening'){                          
										        echo '0.00';
									          }else{
										        echo round(abs($prodtls->tot_paid),2) ; $advCrnote+=$prodtls->tot_paid;}
									    ?>
                                                        </td>
                                                        <td class="report sale" id="sale">
                                                            <!--Adjustable Amount--->
                                                            <?php if($prodtls->remarks=='Opening'){
										    echo '0.00';
										}else{	echo ($prodtls->tot_recv);
										    $adjustable +=($prodtls->tot_recv);
									    }
									   ?>

                                                        </td>

                                                        <?php 
										
                                     if($prodtls->remarks=='Opening'){
                                       	 
                                        $totalamt = (($prodtls->tot_recv) +($prodtls->tot_paid));
                                       
                                        if($totalamt>0){
                                            $totalamt =$totalamt;
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs($totVal)."</td>";
                                            echo"<td></td>";
                                          
                                        }
                                        if($totalamt<0){
                                            $totalamt =$totalamt;
                                            echo"<td></td>";
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                          
                                           
                                        }
                                       
                                     }elseif($prodtls->remarks=='Advance'||$prodtls->remarks=='Cr note'){

                                        $totalamt -= (($prodtls->tot_paid));

                                        if($totalamt>0){
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs($totVal)."</td>";
                                            echo"<td></td>";
                                        }
                                        if($totalamt<0){
                                            echo"<td></td>";
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                           
                                        }

                                    }elseif( $prodtls->remarks=='NEFT Adj' || $prodtls->remarks=='Pay Order Adj' || $prodtls->remarks=='Draft Adj'|| $prodtls->remarks=='Cheque Adj' || $prodtls->remarks=='Net Banking' ){
                                        
										$totalamt -= (($prodtls->tot_recv));
                                        if($totalamt>0){
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs($totVal)."</td>";
                                            echo"<td></td>";
                                        }
                                        if($totalamt<0){
                                            echo"<td></td>";
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                           
                                        }

                                     }elseif($prodtls->remarks=='Sale'){
                                      
                                      $totalamt += $prodtls->tot_payble +$prodtls->cgst + $prodtls->sgst;
  
                                        if($totalamt>0){
                                           
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                            echo"<td></td>";
                                        }
                                        if($totalamt<0){
                                            echo"<td></td>";
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                           
                                        }
                                     }
                                     elseif($prodtls->remarks=='TCS'){
                                        
                                        $totalamt += $prodtls->tot_payble ;
                                        if($totalamt>0){
                                        $totVal=round($totalamt, 2);
                                         echo"<td>".abs( $totVal)."</td>";
                                         echo"<td></td>";
                                        }
                                        if($totalamt<0){
                                         echo"<td></td>";
                                         $totVal=round($totalamt, 2);
                                         echo"<td>".abs( $totVal)."</td>";
                                        
                                         }
                                        }
                                     ?>
                                                    </tr>
                                                    <?php  
                                    }
                                ?>
                                                    <?php 
                                       }
                                else{

                                    echo "<tr> <td></td><td></td><td></td>
                                    <td></td><td></td><td></td><td></td>
                                    <td></td><td></td><td></td>
                                    <td></td><td  style='text-align:center;'>No Data Found</td>
                                     <td></td><td></td><td></td>
                                     </tr>";
                                }   
                            ?>
                                                    <tr style="font-weight: bold;">
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="report" style="text-align:right">Total</td>
                                                        <!-- <td class="report"><?=$taxable?></td>
                                <td class="report"><?=$tot_cgst?></td>  
                                <td class="report"><?=$tot_sgst?></td>   -->
                                                        <td class="report"><?=$totalamount?></td>
                                                        <td class="report"><?=$advCrnote?></td>
                                                        <td class="report"><?=$adjustable?></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div style="text-align: center;" class="printBtnSec">
                                        <button class="btn btn-primary btnCustonPrint" type="button"
                                            onclick="printDiv();">Print</button>
                                        <!-- <button class="btn btn-primary downloadBtn" type="button"
                                        onclick="generatePDF()">Download</button> -->

                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('script')
        <script>
        function printDiv() {
            var divToPrint = document.getElementById('divToPrint');
            var WindowObject = window.open('', 'Print-Window');
            WindowObject.document.open();
            WindowObject.document.writeln('<!DOCTYPE html>');
            WindowObject.document.writeln('<html><head><title></title><style type="text/css">');

            WindowObject.document.writeln('@media print { .center { text-align: center;}' +
                '                                         .inline { display: inline; }' +
                '                                         .underline { text-decoration: underline; }' +
                '                                         .left { margin-left: 315px;} ' +
                '                                         .right { margin-right: 375px; display: inline; }' +
                '                                          table { border-collapse: collapse; font-size: 12px;}' +
                '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 6px;}' +
                '                                           th, td {text-align: left;}' +
                '                                         .border { border: 1px solid black; } ' +
                '                                         .bottom { bottom: 5px; width: 100%; position: fixed} ' +
                '                                         .topPrintHeadMain{width: 100%; display: flex;}' +
                '.topPrintLogo{padding-right: 15px; width: 15%; float:left;}' +
                '.topPrintLogoRight{padding-left: 15px; width: 85%; float:left;}' +
                '.topPrintLogoRight h2{color: #333;font-size: 20px;margin: 0 0 6px 0;padding: 0; text-align: center;}' +
                '.topPrintLogoRight h4{color: #333;font-size: 14px;margin: 0 0 16px 0;padding: 0;line-height: 19px; text-align: center;}' +
                '.topPrintLogoRight h4.h4CustomPrintTop{color: #333;font-size: 16px; text-align: center;}' +
                '.topPrintLogoRight h5{color: #000;font-size: 14px;margin: 0 0 11px 0;padding: 0;line-height: 18px; text-align: center;}' +
                '.topPrintLogoRight h5 label{padding: 0; margin: 0;}' +
                '.gstNumberSec{width: 100%; text-align: left;}' +
                '.gstNumberSec h5{color: #000;font-size: 14px;margin: 0 0 11px 0;padding: 0;line-height: 18px;}' +
                '.gstNumberSec h5 label{padding: 0; margin: 0;} ' +
                '                                       ' +
                '                                   } } </style>');
            WindowObject.document.writeln('</head><body onload="window.print()">');
            WindowObject.document.writeln(divToPrint.innerHTML);
            WindowObject.document.writeln('</body></html>');
            WindowObject.document.close();
            setTimeout(function() {
                WindowObject.close();
            }, 10);
        }
        </script>
        @endsection