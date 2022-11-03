<?php echo View::make('common/header'); ?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Profile</h2>
                <div class="dateCalenderSec"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="">
                        <div class="wrapper_fixed">
                           
                            <div class="row">
                              
                            <div class="signUpCardLayoutMain">
                            <div class="signUpCardLayout-card memberShipArea" style="padding-bottom: 0;">
		
                            <ul class="tabUl nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
    <li><a data-toggle="tab" href="#menu1"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change Password</a></li>

  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active tabContent">
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>Pan No:</span> <input type="text" name="pan" value="{{Auth::user()->pan}}">
		</div>
		</div>
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>Name Of Society:</span> <input type="text" name="soc_name" value="{{Auth::user()->soc_name}}">
		</div>	
		</div>
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>Email Id:</span><input type="email" name="email" value="{{Auth::user()->email}}">
		</div>
		</div>
	<div class="full_field_col3_full">
		<div class="textFieldSec">
		<span>Address:</span><textarea name="soc_address">{{Auth::user()->soc_address}}</textarea>
		</div>
		</div>
	
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>Mobile:</span> <input type="text" name="ph_number" value="{{Auth::user()->ph_number}}">
		</div>
		</div>
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>GSTIN:</span> <input type="text" name="gstin" value="{{Auth::user()->gstin}}" />
		</div>
		</div>
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>mFMS</span> <input type="text" name="mfms" value="{{Auth::user()->mfms}}" />
		</div>
		</div>
	
<!--	<div class="full_field_col3_full"><input type="submit" value="Submit"></div>-->
		
    </div>
    <div id="menu1" class="tab-pane fade tabContent">
      
	<div class="full_field_col3_full"><input type="password" placeholder="Old Password"></div>
		
	<div class="full_field_col3Half"><input type="password" placeholder="New Password"></div>
		
	<div class="full_field_col3Half"><input type="text" placeholder="Confirm Password"></div>
	
	<div class="full_field_col3_full"><input type="submit" value="Confirm"></div>
    </div>
  </div>
</div>		
		
		
	</div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo View::make('common/footer'); ?>