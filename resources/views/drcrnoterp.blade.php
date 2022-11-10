<?php echo View::make('common/header'); ?>
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
                                                <h4 class="h4CustomPrintTop"> </h4>
                                            </div>
                                        </div>

                                        <div class="gstNumberSec">
                                        <h5 style="text-align:left" class="h5LeftDataCus">
                                 <?php  foreach($data as $key1);  { ?>
                                Date:
                                <strong><?php echo  date("d-m-Y", strtotime($key1->trans_dt));?></strong>.
                                <br clear="all">
                                No:<strong><?php echo  $key1->recpt_no;?></strong><br>
                                Ref:<strong><?php echo  $key1->invoice_no;?></strong>
                                    <?php
                                                        }
                                                        ?>
                                            </h5>
                                            <h5 class="h5RightDataCus">     
                                <?php
                                foreach($data as $key1);
                                { ?>
                               Customer's Name:<strong><?php echo  $key1->soc_name;?></strong><br>
                                    GST Number:<strong><?php echo  $key1->gstin;?></strong><br>
                                    <?php
                                                        }
                                                        ?>
                                    State Name: <strong>West Bengal, Code 19</strong><br>
                                    Place Of Suply:
                                    <strong>West Bengal</strong>
                                 </h5>  
                                        </div>

                                        <div class="table-responsive">
                                            <table style="width: 100%;" id="" class="table table-striped">
                                                <thead>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $tot_amount=0.00;
                                                        foreach($data as $key2)
                                                        { ?>

                                                    <tr>
                                                        <th align="left" scope="row" class="double_1Body">
                                                            <?php echo  $key2->cat_desc;?></th>
                                                        <th><?php echo  "&#2352;".$key2->tot_amt;
                                                                $tot_amount+=$key2->tot_amt;
                                                                ?></th>
                                                    </tr>
                                                    <?php
                                                                  }
                                                                  ?>

                                                    <tr>
                                                        <td align="left"><strong style="font-size: 15px;">Total
                                                                Amount:</strong></td>
                                                        <td align="left"> <strong
                                                                style="font-size: 15px;"><?php echo  "&#2352;".number_format(round($tot_amount), 2, '.', '');?></strong>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th align="left" scope="row"><strong>Amount (In
                                                                Words):</strong>{{ Helper::displaywords($tot_amount)}}
                                                        </th>
                                                        <td></td>
                                                    </tr>
                                                    <?php
                                                                    foreach($data as $key3);
                                                                    { ?>
                                                    <tr>
                                                        <th align="left" colspan="2"><strong>Remarks:</strong>
                                                            <?php echo $key3->remarks;?></th>
                                                    </tr>
                                                    <?php
                                                                            }
                                                                            ?>

                                                </tbody>
                                            </table>
                                        </div>

                                        <p align="justify">PAN: <strong><?php $pan = Auth::user()->pan; echo $pan;?></strong><br>
                                </p>
                                <h5>For The West Bengal State Co-operative Marketing Federation Ltd.</h5>
                                <h3>&nbsp;</h3>
                                <div class="billDateGroop"  style="text-align: center;">
                                    <div class="dateTop"><strong>This document is computer generated and does not require signature.</strong></div>
                                </div>
                                    </div>

                                    <div style="text-align: center;" class="printBtnSec">
                                        <button class="btn btn-primary btnCustonPrint" type="button"
                                            onclick="printDiv();">Print</button>
                                        <!-- <button class="btn btn-primary downloadBtn" type="button"
                                        onclick="generatePDF()">Download</button> -->

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo View::make('common/footer'); ?>
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
                '.gstNumberSec h5.h5LeftDataCus{float: left;}'+
                '.gstNumberSec h5.h5RightDataCus{float: right;}'+
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