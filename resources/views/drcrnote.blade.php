@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Credit Note</h2>
                <div class="dateCalenderSec">
                    <div class="calenderSec calenderSecCustome">
                        <form method="POST" action="{{ url('drcrnote') }}" id='' class="formCustom">
                            @csrf
                            <label class="dateCustom"><span>Start Date:</span><span>
                                    <input type="text" name="from_date" id="datepicker" class="form-control" placeholder="dd-mm-yyyy" required
                                        aria-controls="example"></span></label>
                            <label class="dateCustom"><span>End Date:</span><span><input type="text" name="to_date" placeholder="dd-mm-yyyy" required
                                        class="form-control" id="datepicker2" aria-controls="example"></span></label>
                            <button type="submit" class="btn btn-primary floatNone">Submit</button>
                        </form>
                    </div>
                    <!-- <button type="button" class="btn btn_export floatNone">Export as CSV</button> -->
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php if($dr_notes) {     ?>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Date</th>
                                <th>Receipt No</th>
                                <th>Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $i=0;
						$disable_btn = '';
						$enable_btn  = '';
						$disable_del_btn = '';
                        if($dr_notes) { 
                                foreach($dr_notes as $dr) {
                                   
                                   $disable_btn = $dr->irn ? 'hidden' : '';
                                    $enable_btn = $dr->irn ? '' : 'hidden';
		            ?>

                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo date("d/m/Y",strtotime($dr->trans_dt)); ?></td>
                                <td><?php echo $dr->recpt_no;?></td>

                                <td>
                                    <button type="button" name="Print<?= $i ?>" class="btn download_custom"
                                        id="download" data-toggle="tooltip" data-placement="bottom" title="Print_"
                                        <?= $disable_btn; ?>>

                                        <a href="{{ route('drnoteReport',['invoice_no'=>$dr->invoice_no])}}"
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
                                <th>Sl No.</th>
                                <th>Date</th>
                                <th>Receipt No</th>
                                <th>Print</th>

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