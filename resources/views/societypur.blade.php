@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Purchase History</h2>
                <div class="dateCalenderSec"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="">
                        <div class="wrapper_fixed">
                            <form method="POST" action="{{ url('purrep') }}" id='signupForm' class="validatedForm">
                                @csrf
                                <div class="row groupDataStatFrom">
                                    <label for="to_date" class="col-sm-2 col-form-label">From Date:</label>
                                    <div class="col-md-3">
                                        <input type="date" name="from_date" class="form-control required" id='from_date' value=""
                                            min='' max="" />
                                    </div>
                                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                                    <div class="col-md-3">
                                        <input type="date" name="to_date" id='to_date' class="form-control required" value="" min=''
                                            max="" />
                                    </div>
                                    <div class="col-md-2"><input type="submit"
                                            class="btn btn-primary form-control required"></div>
                                </div>
                            </form>

                            <?php   if($all_data) {    ?>
                            <div class="row">
                                <div class="col-lg-12 contant-wraper">
                                    <div id="divToPrint" class="divToPrintClass">
                                        <div class="topPrintHeadMain" class="divToPrintClass">
                                            <div class="topPrintLogo"><img src="{{ url('public/images/logo.png') }}"
                                                    alt="" /></div>
                                            <div class="topPrintLogoRight">
                                                <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                                                <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, <br>
                                                    1582 RAJDANGA MAIN ROAD,
                                                    KOLKATA-700107.</h4>
                                                <h4 class="h4CustomPrintTop">Purchase History Between:
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
                                            <table style="width: 100%;" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Sl No.</th>
                                                        <th>Company</th>
                                                        <th>Product</th>
                                                        <!-- <th>Society</th> -->
                                                        <th>Sale invoice</th>
                                                        <th>Date</th>
                                                        <th>Unit</th>
                                                        <th>Qty</th>
                                                        <th>Taxable Amt</th>
                                                        <th>CGST</th>
                                                        <th>SGST</th>
                                                        <!-- <th>Discount</th> -->
                                                        <th>Total amt</th>
                                                        <!-- <th>Cotainer</th> -->
                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <?php

                                    if($all_data){ 
                                        
                                $i = 1;
                                $total      = 0.00;
                                $tot_cgst   = 0.00;
                                $tot_sgst   = 0.00;
                                $tot_taxamt = 0.00;
                                $tot_dis    = 0.00;
                                $tot_qty    = 0.00;
                                $val        = 0;
                                $sal_qty     =0.00;
                                $totsld_sal  = 0.00;
                                $totlqd_sal  = 0.00;

                                        foreach($all_data as $sal){
                                ?>
                                                    <tr class="rep">
                                                        <td class="report"><?php echo $i++; ?></td>
                                                        <td class="report"><?php echo $sal->short_name; ?></td>
                                                        <td class="report"><?php echo $sal->PROD_DESC; ?></td>
                                                       
                                                        <td class="report"><?php echo $sal->trans_do; ?></td>
                                                        <td class="report">
                                                            <?php echo date("d/m/Y",strtotime($sal->do_dt)); ?></td>
                                                  
                                                        <td class="report"><?php 
                                        if($sal->unit==1 ||$sal->unit==2 ||$sal->unit==4 || $sal->unit==6){
                                                    echo "MTS" ;  
                                                }elseif($sal->unit==3||$sal->unit==5){
                                                    echo "LTR" ;
                                                }
                                                ?>
                                                        </td>

                                                        <td class="report">
                                                            <?php 
                                            // echo $sal->qty;
                                            if($sal->unit==1){

                                                echo $sal->qty; 
                                            $sal_qty=$sal->qty*1000/$sal->qty_per_bag;
                                            $totsld_sal+=$sal->qty;
                                            }elseif($sal->unit==2){
                                                echo ($sal->qty)/1000; 
                                                $sal_qty=($sal->qty)/$sal->qty_per_bag; 
                                                $totsld_sal+=($sal->qty)/1000;
                                            }elseif($sal->unit==4){
                                                echo ($sal->qty)/10;
                                                $sal_qty=($sal->qty)/10;
                                                $totsld_sal+=$sal_qty;
                                            }elseif($sal->unit==6){
                                                echo ($sal->qty)/1000000;
                                                $sal_qty=($sal->qty)*1000/$sal->qty_per_bag;
                                                $totsld_sal+=($sal->qty)/1000000;
                                            }elseif($sal->unit==3){
                                                echo $sal->qty;
                                                $sal_qty=$sal->qty*1000/($sal->qty_per_bag);
                                                $totlqd_sal+=$sal->qty;
                                            }elseif($sal->unit==5){
                                                echo ($sal->qty)/1000; 
                                                $sal_qty=($sal->qty)/($sal->qty_per_bag); 
                                                $totlqd_sal+=($sal->qty)/1000;
                                            }
                                        $tot_qty +=$sal_qty;
                                        ?>
                                                        </td>
                                                        <td class="report"><?php echo $sal->taxable_amt; 
                                        $tot_taxamt += $sal->taxable_amt;?></td>
                                                        <td class="report"><?php echo $sal->cgst; 
                                        $tot_cgst += $sal->cgst;?></td>

                                                        <td class="report"><?php echo $sal->sgst; 
                                        $tot_sgst += $sal->sgst;?></td>

                                                       
                                                        <td class="report"><?php echo $sal->tot_amt; 
                                        $total += $sal->tot_amt; ?>
                                                        </td>
                                                      
                                                </tr>
                                                <?php  
                                            }      
                                        }
                                    else{

                                        echo "<tr> <td></td><td></td><td></td>
                                        <td></td><td></td><td></td><td></td>
                                        <td></td><td></td><td></td>
                                        <td></td><td  style='text-align:center;'>No Data Found</td>
                                        <td></td><td></td>
                                        </tr>";
                                    }   
                                ?>
                                        </tbody>
                                        <tfooter>
                                                    <tr style="font-weight: bold;">
                                                        <td class="report" colspan="7" style="text-align:right">Total</td>
                                                       
                                                        <td class="report"><?=$tot_taxamt?></td>
                                                        <td class="report"><?=$tot_cgst?></td>
                                                        <td class="report"><?=$tot_sgst?></td>
                                                     
                                                        <td class="report"><?=$total?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="report" colspan="10" style="text-align:left"
                                                            bgcolor="silver"><b>Summary</b></td>
                                                        <td class="report" colspan="1" style="text-align:center"
                                                            bgcolor="silver"><b>Sale</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="report" colspan="10" style="text-align:left"
                                                            bgcolor="silver"><b>Solid( MTS) </b></td>
                                                        <td class="report" colspan="1" style="text-align:center"
                                                            bgcolor="silver"><?=$totsld_sal?></td>
                                                    </tr>
                                                    <tr>
                                                    <tr>
                                                        <td class="report" colspan="10" style="text-align:left"
                                                            bgcolor="silver"><b>Liquid( LTR ) </b></td>
                                                        <td class="report" colspan="1" style="text-align:center"
                                                            bgcolor="silver"><?= $totlqd_sal?></td>
                                                    </tr>
                                                </tfooter>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: center;" class="printBtnSec">
                                        <button class="btn btn-primary btnCustonPrint" type="button"
                                            onclick="printDiv();">Print</button>
                                        <!-- <button class="btn btn-primary downloadBtn" type="button"
                                        onclick="generatePDF()">Download</button> -->

                            </div>
                            <?php } ?>
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