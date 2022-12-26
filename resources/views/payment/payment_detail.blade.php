@extends('common.master')
@section('content')
<style>
    .table thead th {
    vertical-align: bottom;
    border-bottom: 0px solid ! important;
    }
</style>
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
                                <div class="topPrintLogo"><img src="{{ url('public/images/logo.png') }}"
                                        alt=""></div>
                                <div class="topPrintLogoRight">
                                    <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                                    <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, <br>
                                        1582 RAJDANGA MAIN ROAD,
                                        KOLKATA-700107.</h4>
                                </div>
                            </div>

                            <br clear="all">
                            <h4 style="text-align:center;margin-bottom:5px"><u>Money Receipt </u></h4>
                            <div class="tableBottomBorder">
                                <!-- <table width="100%" border="0" cellspacing="0" cellpadding="0"> -->
                                    <!-- <tbody>
                                        <tr>
                                            <td align="left">
                                                <table width="100%" class="table tableCus">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" class="equal_1" scope="col">Receipt with
                                                                thanks from:</th>
                                                            <th scope="col" class="equal_2">
                                                                <?php //echo  $data->soc_name;?></th>

                                                        </tr>
                                                        <tr>
                                                            <th align="left" scope="row"><strong>Amount :</strong></th>
                                                            <th><strong><?php //echo "**"."&#2352;".$data->adv_amt."/-";?></strong>
                                                            </th>
                                                          
                                                        </tr>
                                                        <tr>
                                                            <th align="left" scope="row"><strong>The sum of :</strong>
                                                            </th>
                                                            <th>{{ Helper::displaywords($payment->amount)}}</th>

                                                        </tr>
                                                        <tr>
                                                            <th align="left" scope="row"><strong>By:</strong></th>
                                                            <th style="vertical-align: bottom !important;">The West
                                                                Bengal State Co-operative Marketing Federation Ltd</th>
                                                        </tr>
                                                        <tr>
                                                            <th align="left" scope="row"><strong>Remarks:</strong> </th>
                                                            <th style="vertical-align: bottom !important;">
                                                                <?php //echo  $data->remarks;?></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody> -->
                                    <!-- <tbody>
                                        <tr>
                                            <td align="left"> -->
                                                <table width="100%" class="table tableCus border" style="border-collapse: collapse;">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" class="equal_1" scope="col">Payment Date
                                                            </th>
                                                            <td><?php echo date("d/m/Y",strtotime($payment->trans_date)); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Payment Type</th>
                                                            <td><?php if($payment->payment_type == 'A'){ echo 'ADVANCE';}else{
                                                            echo 'INVOICE';
                                                        } ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Payment Mode</th>
                                                                            <td><?php if($payment->payment_mode == 'C'){ echo 'CASH';}
                                                        elseif($payment->payment_mode == 'Q'){
                                                            echo 'CHEQUE';
                                                        }else{
                                                            echo 'INTERNET BANKING';
                                                        } ?>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Society Name</th>
                                                            <td><?php $soc_name = Auth::user()->soc_name; echo $soc_name;?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Payment Date</th>
                                                            <td><?php echo date("d/m/Y",strtotime($payment->trans_date)); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Payment Amount</th>
                                                            <td><?php echo $payment->amount; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Payment Amount (In words)</th>
                                                            <td>{{ Helper::displaywords($payment->amount)}}</td>
                                                        </tr>
                                                        @if ($payment->payment_mode == 'I')
                                                        <tr>
                                                            <th>Order ID</th>
                                                            <td><?php echo $payment->order_id; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Payment ID</th>
                                                            <td><?php echo $payment->payment_id; ?></td>
                                                        </tr>
                                                        @endif
                                                        <?php   if($payment->payment_mode == 'Q'){   ?>
                                                        <tr>
                                                            <th>Cheque no</th>
                                                            <td><?php echo $payment->cheque_no; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Cheque dt</th>
                                                            <td><?php echo date("d/m/Y",strtotime($payment->cheque_dt)) ; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Bank name</th>
                                                            <td><?php echo $payment->bank_name; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Ifs code</th>
                                                            <td><?php echo $payment->ifs_code; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Cheque Image</th>
                                                            <td>
                                                                <img src="{{url('public/images')}}{{'/'.$payment->cheque_img}}" alt="Cheque Image" style="height: 200px ! important" /></img>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        <?php   if($payment->payment_mode == 'I'){   ?>
                                                        @if (!is_null($payment->status))
                                                        <tr>
                                                            <th>Status</th>
                                                            <td><?php echo $payment->status; ?></td>
                                                        </tr>
                                                        @endif

                                                        @if ($payment->payment_type == 'I')
                                                        @if (!is_null($payment->invoice_id))
                                                        <tr>
                                                            <th>Invoice id</th>
                                                            <td><?php echo $payment->invoice_id; ?></td>
                                                        </tr>
                                                        @endif
                                                        @endif

                                                        @if (!is_null($payment->method))
                                                        <tr>
                                                            <th>Method</th>
                                                            <td><?php echo $payment->method; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->description))
                                                        <tr>
                                                            <th>description</th>
                                                            <td><?php echo $payment->description; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->card_id))
                                                        <tr>
                                                            <th>Card id</th>
                                                            <td><?php echo $payment->card_id; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->card))
                                                        <tr>
                                                            <th>Card </th>
                                                            <td><?php echo $payment->card; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->bank))
                                                        <tr>
                                                            <th>Bank</th>
                                                            <td><?php echo $payment->bank; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->wallet))
                                                        <tr>
                                                            <th>Wallet</th>
                                                            <td><?php echo $payment->wallet; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->email))
                                                        <tr>
                                                            <th>Email</th>
                                                            <td><?php echo $payment->email; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->contact))
                                                        <tr>
                                                            <th>Contact</th>
                                                            <td><?php echo $payment->contact; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->note))
                                                        <tr>
                                                            <th>Note</th>
                                                            <td><?php echo $payment->note; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->fee))
                                                        <tr>
                                                            <th>Fee</th>
                                                            <td><?php echo $payment->fee; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->tax))
                                                        <tr>
                                                            <th>Tax</th>
                                                            <td><?php echo $payment->tax; ?></td>
                                                        </tr>
                                                        @endif
                                                        @if (!is_null($payment->payment_at))
                                                        <tr>
                                                            <th>Payment at</th>
                                                            <td><?php echo date('d/m/Y h:s:ia',strtotime($payment->payment_at)); ?>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        <?php } ?>

                                                    </thead>
                                                </table>
                                            <!-- </td>
                                        </tr>
                                    </tbody>
                                </table> -->
                            </div>

                            <p align="justify"><br>
                            </p>
                            <div class="billDateGroop">
                                <div class="crmBill"><strong><?php //echo "**"."&#2352;".$data->adv_amt."/-";?></strong>
                                </div>
                                <div class="dateTop">
                                    <strong><?php //echo  date("d-m-Y", strtotime($data->trans_dt));?></strong>
                                </div>
                            </div>
                            <br clear="all">

                            
                            <p style="padding:0; margin:0; font-size:14px; text-align: left;">This document is
                                computer generated and does not require signature.</p>  
                            <br>
                            <p style="padding:0; margin:0; float:left; font-size:14px;"><b>Note</b>: This is a temporary receipt.Actual receipt will be generated subject to payment realization, within 2 working days.</p>
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