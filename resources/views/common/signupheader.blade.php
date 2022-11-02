<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sign Up</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" type="text/css" href="{{ url('public/css/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/apps.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/apps_inner.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/res.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>	
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js" type="text/javascript"></script>	
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
<!--font-family: 'Roboto', sans-serif;-->
<link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&display=swap" rel="stylesheet"> 
<!--font-family: 'Gorditas', cursive;-->
</head>
<body>
 <div class="headerTop">
   <div class="wrapperCus headerTopSub">
	 <a href="{{route('login')}}"><div class="topLogo"><img src="{{ url('public/images/logo.png') }}" alt=""/></div></a>
	 <div class="userDetailsRight"></div>
   </div>
	</div>
	