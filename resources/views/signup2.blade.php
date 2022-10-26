<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sign Up</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/apps.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/apps_inner.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/res.css') }}">
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>	
	
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
<!--font-family: 'Roboto', sans-serif;-->
	
<link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&display=swap" rel="stylesheet"> 
<!--font-family: 'Gorditas', cursive;-->
	
</head>
<body>

 <div class="headerTop">
   <div class="wrapperCus headerTopSub">
	 <div class="topLogo"><img src="{{ url('public/images/logo.png') }}" alt=""/></div>
	 <div class="userDetailsRight"></div>
   </div>
	</div>
	
	<div class="innerPageSecSignUp">
	<div class="signUpLeftInner">
	
		<div class="signUpLeftForm">
		<h2>Sign up</h2>
			
			<p>By signing up, I agree to the Asana Privacy Policy and Terms of Service.</p>
			
			<form method="POST" action="{{ url('registercomplete') }}" id='signupForm'>
			@csrf
			<label class="full_fieldSignHalf_1"><span>Pan No.</span>
			<input type="text" class="nonEdit" name="pan" value="{{Session::get('soctemp_detail')[0]->pan}}"></label>
			
			<label class="full_fieldSignHalf_2"><span>Email Id</span>
			<input type="email"  class="nonEdit" name="email" value="{{Session::get('soctemp_detail')[0]->email}}"> </label>
			<input type="hidden" class="nonEdit" name="id" value="{{$id}}">
			<label class="full_fieldSign">
			<span>Name Of Society</span>
			<input type="text" class="nonEdit" name="soc_name">
			</label>
			<label class="full_fieldSign">
			<span>Address</span>
			<textarea class="nonEdit" name="soc_address"></textarea>
			</label>
			<label class="full_fieldSignHalf_1"><span>GSTIN</span>
			<input type="text" class="nonEdit" name="gstin"></label>
			
			<label class="full_fieldSignHalf_2"><span>mFMS</span>
			<input type="text" class="nonEdit" name="mfms"></label>
			
			<label class="full_fieldSign">
			<span>Phone Number</span>
			<input type="tel" class="nonEdit" name="ph_number">
			</label>
			<input type="submit" value="Continue" class="signUpBtn">
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
