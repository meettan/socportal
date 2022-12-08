@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Payment Detail</h2>
                <div class="dateCalenderSec">
                    <div class="calenderSec calenderSecCustome">
                    <a href="{{'paymentlist'}}" class='btn btn-primary'>Pay List</a>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
        <?php        if($payment) {    ?>
                    <table id="" class="table table-paymentiped table-bordered" style="width:100%">
                        <thead>
                           
                        </thead>
                        <tbody>
                            <tr>
                                <th>Payment Date</th>
                                <td><?php echo date("d/m/Y",strtotime($payment->trans_date)); ?></td>
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
                                } ?></td>
                            </tr>
                            <tr>
                                <th>Society Name</th>
                                <td><?php $soc_name = Auth::user()->soc_name; echo $soc_name;?></td>
                            </tr>
                            <tr>
                                <th>Payment Date</th>
                                <td><?php echo date("d/m/Y",strtotime($payment->trans_date)); ?></td>
                            </tr>
                            <tr>
                                 <th>Payment Amount</th>
                                 <td><?php echo $payment->amount; ?></td>
                            </tr>
                            <tr>
                                 <th>Order ID</th>
                                <td><?php echo $payment->order_id; ?></td>
                            </tr>
                            <tr>
                                 <th>Payment ID</th>
                                <td><?php echo $payment->payment_id; ?></td>
                            </tr>
                          <?php   if($payment->payment_mode == 'Q'){   ?>
                            <tr>
                                 <th>Cheque no</th>
                                <td><?php echo $payment->cheque_no; ?></td>
                            </tr>
                            <tr>
                                 <th>Cheque dt</th>
                                <td><?php echo $payment->cheque_dt; ?></td>
                            </tr>
                            <tr>
                                 <th>Bank name</th>
                                <td><?php echo $payment->bank_name; ?></td>
                            </tr>
                            <tr>
                                 <th>Ifs code no</th>
                                <td><?php echo $payment->ifs_code; ?></td>
                            </tr>
                            <?php } ?>
                            <?php   if($payment->payment_mode == 'I'){   ?>
                            @if (!is_null($payment->status))
                            <tr>
                                 <th>Status</th>
                                <td><?php echo $payment->status; ?></td>
                            </tr>
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
                                <td><?php echo date('d/m/Y',$payment->payment_at); ?></td>
                            </tr>
                            @endif
                            <?php } ?>
                      
                        </tbody>
                       
                    </table>
                    <?php
                               
                            }
                            
                        ?>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection