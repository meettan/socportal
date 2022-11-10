<?php echo View::make('common/header'); ?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Advance</h2>
                <div class="dateCalenderSec">
                    <div class="calenderSec calenderSecCustome">
                    <form method="POST" action="{{ url('advancefilter') }}" id='' class="formCustom">
		                          @csrf
                        <label class="dateCustom"><span>Start Date:</span><span>
                            <input type="text" name="from_date" class="form-control" id="datepicker" placeholder="dd-mm-yyyy" required
                                    aria-controls="example"></span></label>
                        <label class="dateCustom"><span>End Date:</span><span><input type="text" name="to_date"
                                    class="form-control" id="datepicker2" placeholder="dd-mm-yyyy" required
                                    aria-controls="example"></span></label>
                        <button type="submit" class="btn btn-primary floatNone">Submit</button>
                        </form>
                    </div>
                    <!-- <button type="button" class="btn btn_export floatNone">Export as CSV</button> -->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
        <?php         if($data) {    ?>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl.No.</th>
                                <th>Date</th>
                                <th>Receipt No.</th>
                                <th>Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                        $i=0;
                        if($data) {
                                foreach($data as $value) {
		            ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo date('d/m/Y',strtotime($value->trans_dt)); ?></td>
                                <td><?php echo $value->receipt_no; ?></td>
                                <td>
                                    <a href="{{ route('socadvReport',['receipt_no'=>$value->receipt_no])}}"
                                        title="Print">
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
                                <th>Sl.No.</th>
                                <th>Date</th>
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