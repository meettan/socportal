@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Payment List</h2>
                <div class="dateCalenderSec">
                    <div class="calenderSec calenderSecCustome">
                    <a href="{{'payment'}}" class='btn btn-primary'>Pay now</a>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
        <?php        if($payment_list) {    ?>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Payment Date</th>
                                <th>Payment Type</th>
                                <th>Amount.</th>
                                <th>Transaction ID.</th>
                                <th>Invoice ID</th>
                                <th>Status </th>
                                <th>Option </th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $i=0;
                            if($payment_list) {
                            foreach($payment_list as $pay) {
                        ?>

                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo date("d/m/Y",strtotime($pay->trans_date)); ?></td>
                                <td><?php if($pay->payment_type == 'A'){ echo 'ADVANCE';}else{
                                    echo 'INVOICE';
                                } ?></td>
                                <td><?php echo $pay->amount; ?></td>
                                
                                <td><?php echo $pay->order_id; ?></td>
                                <td> @if ($pay->payment_type == 'I')
                                    <?php echo $pay->invoice_id; ?>
                                    @endif
                                </td>
                                <td><?php echo $pay->status; ?></td>
                                <td>
                                    <a href="{{ route('paymentdetail',['id'=>$pay->id])}}" title="Print">
                                        <i class="fa fa-eye fa-2x" style="color:green;"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php
                                }
                            }
                            else {
                                echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
                            }
                        ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl No.</th>
                                <th>Payment Date</th>
                                <th>Payment Type</th>
                                <th>Amount.</th>
                                <th>Transaction ID.</th>
                                <th>Invoice ID</th>
                                <th>Status </th>
                                <th>Option </th>

                            </tr>
                        </tfoot>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection