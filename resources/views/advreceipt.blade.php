@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2></h2>
                <div class="dateCalenderSec"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="divToPrint">
                        <div class="wrapper_fixed">
                        <div class="topPrintHeadMain">
                                            <div class="topPrintLogo"><img src="http://localhost/socportal/public/images/logo.png" alt=""></div>
                                            <div class="topPrintLogoRight">
                                                <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                                                <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, <br>
                                                    1582 RAJDANGA MAIN ROAD,
                                                    KOLKATA-700107.</h4>
                                              </div>
                        </div>
                            <div class="billDateGroop">
                                <div class="crmBill">No: <strong><?php echo  $data->receipt_no;?></strong></div>
                                <div class="dateTop">Date:
                                    <strong><?php echo  date("d-m-Y", strtotime($data->trans_dt));?></strong>.</div>
                            </div>
                            <br clear="all">
                            <h4 style="text-align:center"><u>Receipt - BAN Voucher </u></h4>
                            <div class="tableBottomBorder">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td align="left">
                                                <table width="100%" class="table tableCus">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" class="equal_1" scope="col">Receipt with
                                                                thanks from:</th>
                                                            <th scope="col" class="equal_2">
                                                                <?php echo  $data->soc_name;?></th>

                                                        </tr>
                                                        <tr>
                                                            <th align="left" scope="row"><strong>Amount :</strong></th>
                                                            <th><strong><?php echo "**"."&#2352;".$data->adv_amt."/-";?></strong>
                                                            </th>
                                                            <!-- <td rowspan="3" style="width: 67%;padding: 4px;" ></td> -->
                                                        </tr>
                                                        <tr>
                                                            <th align="left" scope="row"><strong>The sum of :</strong>
                                                            </th>
                                                            <th>{{ Helper::displaywords($data->adv_amt)}}</th>

                                                        </tr>
                                                        <tr>
                                                            <th align="left" scope="row"><strong>By:</strong></th>
                                                            <th style="vertical-align: bottom !important;">The West
                                                                Bengal State Co-operative Marketing Federation Ltd</th>
                                                        </tr>
                                                        <tr>
                                                            <th align="left" scope="row"><strong>Remarks:</strong> </th>
                                                            <th style="vertical-align: bottom !important;">
                                                                <?php echo  $data->remarks;?></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <p align="justify"><br>
                            </p>
                            <div class="billDateGroop">
                                <div class="crmBill"><strong><?php echo "**"."&#2352;".$data->adv_amt."/-";?></strong>
                                </div>
                                <div class="dateTop">Date:
                                    <strong><?php echo  date("d-m-Y", strtotime($data->trans_dt));?></strong></div>
                            </div>
                            <br clear="all">
                            <p style="padding:0; margin:0; float:left; font-size:12px;">**Subjet to Realisation</p>
                            <p style="padding:0; margin:0; font-size:12px; text-align: center;">This document is computer generated and does not require signature.</p>
                            <br>
                        </div>
                       
                    </div>
                    <div style="text-align: center;">
                            <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
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
@endsection
