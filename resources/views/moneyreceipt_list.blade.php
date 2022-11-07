<?php echo View::make('common/header'); ?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Money Receipt</h2>
                <div class="dateCalenderSec">
                    <div class="calenderSec calenderSecCustome">
                        <form method="POST" action="{{ url('socpayment') }}" id='' class="formCustom">
                            @csrf
                            <label class="dateCustom"><span>Start Date:</span><span>
                                    <input type="date" name="from_date" class="form-control" id="from_date"
                                     aria-controls="example"></span></label>
                            <label class="dateCustom"><span>End Date:</span><span><input type="date" name="to_date"
                                                  class="form-control" id="to_date"
                                        aria-controls="example"></span></label>
                            <button type="submit" class="btn btn-primary floatNone">Submit</button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
        <?php        if($soc_pay) {    ?>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Receipt Date</th>
                                <th>Receipt No.</th>
                                <th>Print</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
        $i=0;
    if($soc_pay) {
            foreach($soc_pay as $pay) {
?>

                            <tr>

                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $pay->paid_id; ?></td>
                                <td><?php echo date("d/m/Y",strtotime($pay->paid_dt)); ?></td>
                                <td>
                                    <a href="{{ route('moneyrecpt',['paid_id'=>$pay->paid_id])}}" title="Print">
                                        <i class="fa fa-download fa-2x" style="color:green;"></i>
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
                                <th>Receipt Date</th>
                                <th>Receipt No.</th>
                                <th>Print</th>

                            </tr>
                        </tfoot>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo View::make('common/footer'); ?>