<?php echo View::make('common/header'); ?>
<div class="content-wrapper">
			
			<div class="card">
			 <div class="card-body">
				 
				 
				 <div class="titleSec">
					 
				 <h2>Download All Receipt</h2> 
					 
					 <div class="dateCalenderSec">
						 <div class="calenderSec">
						 <label class="dateCustom"><span>Start Date:</span><span><input type="date" class="form-control form-control-sm" placeholder="" aria-controls="example"></span></label>
						 
						 <label class="dateCustom"><span>End Date:</span><span><input type="date" class="form-control form-control-sm" placeholder="" aria-controls="example"></span></label>
						 <button type="submit" class="btn btn-primary floatNone">Submit</button>
						</div>
						 <button type="button" class="btn btn_export floatNone">Export as CSV</button>
						 
						 </div>
				 </div>
				 
				<div class="row">
					 <div class="col-sm-12"> 
			<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Book Name</th>
                <th>Author Name</th>
                <th>ISBN No.</th>
                <th>Category</th>
				<th>SubCategory</th>
				<th>Publisher</th>
				<th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>Taxation Laws</td>
				<td>International Taxation</td>
				<td>Somnath Thakur</td>
				<td>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="approvBtn">Approve</a>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="rejectBtn">Reject</a>
				</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>Taxation Laws</td>
				<td>International Taxation</td>
				<td>Somnath Thakur</td>
				<td>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="approvBtn">Approve</a>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="rejectBtn">Reject</a>
				</td>
            </tr>
			
			<tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>Taxation Laws</td>
				<td>International Taxation</td>
				<td>Somnath Thakur</td>
				<td>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="approvBtn">Approve</a>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="rejectBtn">Reject</a>
				</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>Taxation Laws</td>
				<td>International Taxation</td>
				<td>Somnath Thakur</td>
				<td>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="approvBtn">Approve</a>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="rejectBtn">Reject</a>
				</td>
            </tr>
			
			<tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>Taxation Laws</td>
				<td>International Taxation</td>
				<td>Somnath Thakur</td>
				<td>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="approvBtn">Approve</a>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="rejectBtn">Reject</a>
				</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>Taxation Laws</td>
				<td>International Taxation</td>
				<td>Somnath Thakur</td>
				<td>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="approvBtn">Approve</a>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="rejectBtn">Reject</a>
				</td>
            </tr>
			
			<tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>Taxation Laws</td>
				<td>International Taxation</td>
				<td>Somnath Thakur</td>
				<td>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="approvBtn">Approve</a>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="rejectBtn">Reject</a>
				</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>Taxation Laws</td>
				<td>International Taxation</td>
				<td>Somnath Thakur</td>
				<td>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="approvBtn">Approve</a>
				<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit" class="rejectBtn">Reject</a>
				</td>
            </tr>

		</tbody>
        <tfoot>
            <tr>
              <th>No</th>
              <th>Book Name</th>
              <th>Author Name</th>
              <th>ISBN No.</th>
              <th>Category</th>
			  <th>SubCategory</th>
			  <th>Publisher</th>
			  <th>Status</th>
            </tr>
        </tfoot>
    </table>
				</div>
				</div>
			</div>
			</div>
			
			
			
		</div>
<?php echo View::make('common/footer'); ?>