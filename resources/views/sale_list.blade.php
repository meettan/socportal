@extends('common.master')
@section('content')
<div class="content-wrapper">
			<div class="card">
			 <div class="card-body">
				 <div class="titleSec">
				 <h2>Sale Receipt</h2> 
					 <div class="dateCalenderSec">
						 <div class="calenderSec calenderSecCustome">
                         <form method="POST" action="{{ url('salesfilter') }}" id='' class="formCustom">
		                          @csrf
						 <label class="dateCustom"><span>Start Date:</span><span><input type="text" class="form-control"  name="from_date" id="datepicker" placeholder="dd-mm-yyyy" required></span></label>
						 <label class="dateCustom"><span>End Date:</span><span><input type="text" class="form-control" name="to_date" id="datepicker2" placeholder="dd-mm-yyyy" required ></span></label>
						 <button type="submit" class="btn btn-primary floatNone">Submit</button>
                         </form>
						</div>
						 <!-- <button type="button" class="btn btn_export floatNone">Export as CSV</button> -->
						 </div>
				 </div>
				<div class="row">
					 <div class="col-sm-12"> 
                     <?php         if($sales) {    ?>
			<table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                <th>Sl No.</th>
                <th>Invoice Date</th>
                <th>Invoice No.</th>
                <th>Print</th>
                </tr>
                </thead>
                <tbody>

                <?php
                    $i=0;
                    if($sales) {
                        foreach($sales as $value) {
                        $disable_prnt=$value->irn? 'hidden' : '';
                        $disable_btn = $value->irn ||$value->pay_cnt ? 'hidden' : '';
                        //$enable_btn = $value->irn ? '' : 'hidden';
                        $enable_btn ='';
                ?>
        <tr>
            <td><?php echo ++$i; ?></td>
            <td ><?php echo date("d/m/Y",strtotime($value->do_dt)); ?></td>
            <td><?php echo $value->trans_do; ?></td>
            <td>
            
                <?php if($value->irn == '') {  ?>
                    
                    <a href="{{ route('saleinvoice_rep',['trans_do'=>$value->trans_do])}}" target="_blank" title="Download"><i class="fa fa-download fa-2x" style="color:green;"></i></a>

                <?php }else { ?>
                <button type="button" name="download_<?= $i ?>" class="btn download_custom" id="download"    
                data-toggle="tooltip" data-placement="bottom" title="download_" <?= $enable_btn; ?>>
                <a href="{{ route('print_receipt',['irn'=>$value->irn])}}" id="down_clk_td_<?= $i ?>" title="Download"><i class="fa fa-download fa-2x" style="color:green;"></i></a>

                <?php } ?>
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
        <th>Invoice Date</th>
        <th>Invoice No.</th>
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
        @endsection
@section('script')
@endsection