<?php echo View::make('common/header'); ?>
    <div class="content-wrapper">
		<div class="card">
            <div class="card-body">
                <div class="titleSec">
                    <h2>{{ Helper::test() }}</h2>
                    <div class="dateCalenderSec"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12"> 
                        <div id="divToPrint">
                            <div class="wrapper_fixed">
                            <form method="POST" action="{{ url('socledgerrep') }}" id='signupForm' class="validatedForm">
		                          @csrf
                                <div class="row">
                               
                                <label for="to_date" class="col-sm-1 col-form-label">From Date:</label>
                                <div class="col-md-3">
                                <input type="date" name="from_date" class="form-control required" value="<?php echo '2022-04-01'?>" min='' max="" readonly/>  
                                </div>
                                <label for="to_date" class="col-sm-1 col-form-label">To Date:</label>
                                <div class="col-md-3">
                                    <input type="date" name="to_date" class="form-control required" value=""  min='' max=""/> 
                                </div>
                                <div class="col-md-2"><input type="submit" class="form-control required"></div>
                                 
                                </div>
                              </form>
                              <div class="row">
           
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
            '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
            '                                       ' +
            '                                   } } </style>');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function () {
            WindowObject.close();
        }, 10);
  }
  </script>