@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Payment List</h2>
                <div class="dateCalenderSec">
                    <div class="calenderSec calenderSecCustome">
                    <!-- <a href="{{'payment'}}" class='btn btn-primary'>Pay now</a> -->
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
        <?php        if($invoice_list) {    ?>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th> Date</th>
                                <th>Invoice No.</th>
                                <th>Ro No.</th>
                                <th>Option </th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $i=0;
                            if($invoice_list) {
                            foreach($invoice_list as $pay) {
                        ?>

                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo date("d/m/Y",strtotime($pay->do_dt)); ?></td>
                                <td><?php echo $pay->trans_do; ?></td>
                                <td><?php echo $pay->sale_ro; ?></td>
                                
                                <td>
                                    <button class="btn btn-success">Paid</button>
                                    
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
                                <th> Date</th>
                                <th>Invoice No.</th>
                                <th>Ro No.</th>
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