<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">	
<link rel="stylesheet" type="text/css" href="{{ url('public/css/font-awesome.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/apps.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/apps_inner.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/res.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&display=swap" rel="stylesheet"> 
</head>
<body>
<div class="page-body-wrapper">
	<nav class="sidebar sidebar-offcanvas" id="sidebar">
		<div class="float-left logo"><img src="{{ url('public/images/logo.png') }}" alt=""/> <a href="#" class="closeMenu"><i class="fa fa-bars" aria-hidden="true"></i></a>
</div>
	<ul id="accordion" class="accordion">
  <li>
    <div class="link"><a href="{{route('dashboard')}}"><i class="fa fa-tachometer"></i>Dashboard</a></div>
  </li>
  <li>
    <div class="link"><a href="{{route('receipt')}}"><i class="fa fa-code"></i>Receipt </a></div>
  </li>
	<li>
	<div class="link"><a href="{{route('report')}}"><i class="fa fa-code"></i>Report</a></div>
	</li>
	<li>
	<div class="link"><a href="#"><i class="fa fa-sign-out"></i>Log out</a></div>
	</li>
  <li>
    <div class="link"><i class="fa fa-mobile"></i>Dropdown 1<i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="#">Menu 1</a></li>
      <li><a href="#">Menu 2</a></li>
      <li><a href="#">Menu 3</a></li>
    </ul>
  </li>
  <li>
    <div class="link"><i class="fa fa-globe"></i>Dropdown 2<i class="fa fa-chevron-down"></i></div>
    <ul class="submenu">
      <li><a href="#">Menu 1</a></li>
      <li><a href="#">Menu 2</a></li>
      <li><a href="#">Menu 3</a></li>
    </ul>
  </li>
</ul>
</nav>	
	<div class="main-panel">
		<div class="float-left navRightSec">
		<ul class="topDate">
<li><a href="#"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
</ul>
		<div class="topDateRight">
		<ul class="nav topDateRight">
			<li class="nav-item dropdown">
                    <a href="#" class="nav-link">Branch Office <i class="fa fa-user-circle" aria-hidden="true"></i> </a>
                </li>
            </ul>
		</div>
</div>
<div id='ajaxview'>  <!--  Div Statr For Getting Ajax data and page  -->