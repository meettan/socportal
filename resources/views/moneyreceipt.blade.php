@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Credit Note</h2>
                <div class="dateCalenderSec"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <div class="wrapper_fixed">
                            <div class="row">
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
                                                <h4 class="h4CustomPrintTop">Money Receipt </h4>
                                            </div>
                                        </div>

                                        <div class="gstNumberSec">
                                            <h5 style="text-align:left" class="h5LeftDataCus">
                                                                                          
                                                No: <strong><?php echo  $data->paid_id;?></strong><br>
                                                Date:<strong><?php echo  date("d-m-Y", strtotime( $data->paid_dt));?></strong>.
                                                
                                                
                                            </h5>
                                            <h5 class="h5RightDataCus">

                                            </h5>
                                        </div>

                                        <div class="table-responsive">
                                            <table style="width: 100%;" id="" class="table table-striped">
                                                <thead>
                                                <tr>
                                                            <th scope="col" colspan="" class="double_1">Particulars</th>
                                                            <th scope="col" class="double_2">Amount</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                               
                                                        <tr>
                                                            <td scope="row" class="double_1Body">
                                                                <strong>Account:</strong><?php echo  $data->soc_name;?>
                                                            </td>
                                                            <td><?php echo "&#2352;".$data->amt;?></td>
                                                        </tr>

                                                        <?php if(!empty($payTypePaidDetails)){ ?>

                                                        <tr>
                                                            <th scope="col" class="double_1" style="text-align: left;">
                                                                Payment Break Up</th>
                                                            <!-- <th scope="col" class="double_2">Reference Date</th>
                        <th scope="col" class="double_3">Reference No</th> -->
                                                            <th scope="col" class="double_2"></th>
                                                        </tr>
                                                        <?php foreach ($payTypePaidDetails as $pTPD) { ?>
                                                        <tr>
                                                            <td scope="row" class="double_1Body"><?php if($pTPD->pay_type==1){
                          echo 'Cash';
                          }else if($pTPD->pay_type==2){
                            echo 'Advance';
                          }else if($pTPD->pay_type==3){
                            echo 'Cheque';
                          }else if($pTPD->pay_type==4){
                            echo 'Draft';
                          }else if($pTPD->pay_type==5){
                            echo 'Pay Order';
                          }else if($pTPD->pay_type==6){
                            echo 'CR Note';
                          }else if($pTPD->pay_type==7){
                            echo 'NEFT/RTGS';
                          }; ?></td>
                                                            <!-- <td scope="row" class="double_1Body"><?php //date("d/m/Y", strtotime($pTPD->ref_dt)); ?></td>
                        <td scope="row" class="double_1Body"><?php //$pTPD->ref_no; ?></td> -->
                                                            <td scope="row" class="double_1Body">
                                                                र<?= $pTPD->paid_amt; ?></td>
                                                        </tr>
                                                        <?php } ?>

                                                        <?php } ?>



                                                        <tr>
                                                            <td scope="row">
                                                                <p><strong>Through: </strong><br>
                                                                    <?php echo  $data->bank_name;?></p>
                                                                <p><strong>On Account Of: </strong><br>
                                                                    Received against invoice No
                                                                    <?php echo  $data->sale_invoice_no;?>.<?php echo  $data->remarks;?>
                                                                    <br>
                                                                </p>
                                                                <p style="margin: 0; padding: 0;"><strong>Amount (In
                                                                        Word):</strong> INR
                                                                    {{ Helper::displaywords($data->amt)}}</p>
                                                            </td>
                                                            <td style="vertical-align: bottom !important;">
                                                                <strong><?php echo "&#2352;".$data->amt;?></strong>
                                                            </td>
                                                        </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="billDateGroop" style="text-align: center;">
                                            <div class="dateTop"><strong>This document is computer generated and does
                                                    not require signature.</strong></div>
                                        </div>
                                    </div>

                                    <div style="text-align: center;" class="printBtnSec">
                                        <button class="btn btn-primary btnCustonPrint" type="button"
                                            onclick="printDiv();">Print</button>
                                     
                                    </div>
                                </div>

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
                '.gstNumberSec h5.h5LeftDataCus{float: left;}' +
                '.gstNumberSec h5.h5RightDataCus{float: right;}' +
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