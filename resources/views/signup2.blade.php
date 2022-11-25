<?php echo View::make('common/signupheader'); ?>
	<div class="innerPageSecSignUp">
	<div class="signUpLeftInner">
	
		<div class="signUpLeftForm">
		<h2>Sign up</h2>
			
			<p>By signing up, I agree to the Asana Privacy Policy and Terms of Service.</p>
			
			<form method="POST" action="{{ url('registercomplete') }}" id='signupForm'>
			@csrf
			<input type="text" hidden name="prev_pan" id="prev_pan" value="{{$datas->pan}}">
			<input type="text" hidden name="prev_email" id="prev_email" value="{{$datas->email}}">
			<input type="text" hidden name="prev_password" id="prev_password" value="{{$datas->password}}">
			<input type="text" hidden name="prev_soc_id" id="prev_soc_id" value="{{$soc_id}}">


			<label class="full_fieldSignHalf_1"><span>Pan No.</span>
			<input type="text" class="nonEdit" name="pan" value="{{Session::get('soctemp_detail')[0]->pan}}"></label>
			
			<label class="full_fieldSignHalf_2"><span>Email Id</span>
			<input type="email"  class="nonEdit" name="email" value="{{Session::get('soctemp_detail')[0]->email}}"> </label>
			<label class="full_fieldSign">
			<span>Name Of Society</span>
			<input type="text" class="nonEdit" name="soc_name" value="{{Session::get('soctemp_detail')[0]->soc_name}}">
			</label>
			<label class="full_fieldSign">
			<span>Address</span>
			<textarea class="nonEdit" name="soc_address">{{Session::get('soctemp_detail')[0]->soc_add}}</textarea>
			</label>
			<label class="full_fieldSignHalf_1"><span>GSTIN</span>
			<input type="text" class="nonEdit" name="gstin" value="{{Session::get('soctemp_detail')[0]->gstin}}"></label>
			
			<label class="full_fieldSignHalf_2"><span>mFMS</span>
			<input type="text" class="nonEdit" name="mfms" value="{{Session::get('soctemp_detail')[0]->mfms}}"></label>
			
			<label class="full_fieldSign">
			<span>Phone Number</span>
			<input type="tel" class="nonEdit" name="ph_number" value="{{Session::get('soctemp_detail')[0]->ph_no}}">
			</label>
			<input type="submit" value="Submit" class="signUpBtn">
        </form>
		</div>
		
	</div>
		
	<div class="signUpRightInner">
	<div class="signUpRightInnerSub">
		<div class="signUpRightInnerSubMain">
		<img class="feature-callout__img" src="{{ url('public/images/005100.png') }}" alt="Image of team" width="112">
			<h2>Your plan includes</h2>
			
			<div class="list">
				<ul>
				<li>Unlimited tasks and projects</li>
				<li>Unlimited tasks and projects</li>
				<li>Unlimited tasks and projects</li>
				<li>Unlimited tasks and projects</li>
				</ul>
		</div>
	</div>	
	</div>
	
		
		</div>
	</div>	

<div class="footerSec">
	<div class="footerSecSub1">
	<div class="wrapperCus">
	<div class="col-sm-6 float-left">
		<h2>Contact Us</h2>
		<p><strong>The West Bengal State Co-operative Marketing Federation Ltd.</strong>
Southend Conclave, 3rd Floor,
1582 Rajdanga Main Road,
Kolkata - 700 107.</p>
<p>Phone: +91 33 2441 4366/67, Fax: +91 33 2441-4372<br>
Email: info@benfed.org</p>
		
	</div>
	<div class="col-sm-6 float-left">
		<h2>Head Office</h2>
		<p><strong>The West Bengal State Co-operative Marketing Federation Ltd.</strong>
Southend Conclave, 3rd Floor,
1582 Rajdanga Main Road,
Kolkata - 700 107.</p>
<p>Phone: +91 33 2441 4366/67, Fax: +91 33 2441-4372<br>

Email: info@benfed.org</p>
	</div>
	</div>
	</div>
	
	<div class="footerSecSub2">
		<div class="wrapperCus">
		Copyright © 2022 benfed.org. All Rights Reserved.
		</div>
	</div>
	
</div>




<script src="{{ url('public/js/bootstrap.min.js') }}"></script>
<script src="{{ url('public/js/main_javascript.js') }}"></script>
<script src="{{ url('public/js/main_jquery.js') }}"></script>
</body>
</html>
