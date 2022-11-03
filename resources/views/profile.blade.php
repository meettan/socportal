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
		<span>Member Id:</span> #1245215
		</div>
		</div>
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>Name:</span> Suvendu Das
		</div>	
		</div>
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>Branch Code:</span>12458
		</div>
		</div>
	<div class="full_field_col3_full">
		<div class="textFieldSec">
		<span>Address:</span> Acropolis, Module 7/18, 1858/1 Rajdanga Main Road Kolkata-107. West Bengal, India
		</div>
		</div>
	
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>Mobile:</span> 033 4600 6717 
		</div>
		</div>
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>Member Type:</span> General
		</div>
		</div>
	<div class="full_field_col3">
		<div class="textFieldSec">
		<span>D.O.B.:</span> 31/08/1983
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
        <script>
        function printDiv() {
            var divToPrint = document.getElementById('divToPrint');
            var WindowObject = window.open('', 'Print-Window');
            WindowObject.document.open();
            WindowObject.document.writeln('<!DOCTYPE html>');
            WindowObject.document.writeln('<html><head><title></title><style type="text/css">');

            WindowObject.document.writeln('@media print { .center { text-align: center;}' +
                '                                         .inline { display: inline; }' +
                '                                         .underline { text-decoration: underline; }' +
                '                                         .left { margin-left: 315px;} ' +
                '                                         .right { margin-right: 375px; display: inline; }' +
                '                                          table { border-collapse: collapse; font-size: 12px;}' +
                '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 6px;}' +
                '                                           th, td {text-align: left;}' +
                '                                         .border { border: 1px solid black; } ' +
                '                                         .bottom { bottom: 5px; width: 100%; position: fixed} ' +
                '                                         .topPrintHeadMain{width: 100%; display: flex;}' +
                '.topPrintLogo{padding-right: 15px; width: 15%; float:left;}' +
                '.topPrintLogoRight{padding-left: 15px; width: 85%; float:left;}' +
                '.topPrintLogoRight h2{color: #333;font-size: 20px;margin: 0 0 6px 0;padding: 0; text-align: center;}' +
                '.topPrintLogoRight h4{color: #333;font-size: 14px;margin: 0 0 16px 0;padding: 0;line-height: 19px; text-align: center;}' +
                '.topPrintLogoRight h4.h4CustomPrintTop{color: #333;font-size: 16px; text-align: center;}' +
                '.topPrintLogoRight h5{color: #000;font-size: 14px;margin: 0 0 11px 0;padding: 0;line-height: 18px; text-align: center;}' +
                '.topPrintLogoRight h5 label{padding: 0; margin: 0;}' +
                '.gstNumberSec{width: 100%; text-align: left;}' +
                '.gstNumberSec h5{color: #000;font-size: 14px;margin: 0 0 11px 0;padding: 0;line-height: 18px;}' +
                '.gstNumberSec h5 label{padding: 0; margin: 0;} ' +
                '                                       ' +
                '                                   } } </style>');
            WindowObject.document.writeln('</head><body onload="window.print()">');
            WindowObject.document.writeln(divToPrint.innerHTML);
            WindowObject.document.writeln('</body></html>');
            WindowObject.document.close();
            setTimeout(function() {
                WindowObject.close();
            }, 10);
        }
        </script>