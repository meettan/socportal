<?php echo View::make('common/header'); ?>
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
    <div class="content-wrapper">
		<div class="card">
            <div class="card-body">
                <div class="titleSec">
                    <h2>Please Give valid date range</h2>
                    <div class="dateCalenderSec"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12"> 
                        <div id="divToPrint">
                            <div class="wrapper_fixed">
                            <form method="POST" action="{{ url('purrep') }}" id='signupForm' class="validatedForm">
		                          @csrf
                                <div class="row">
                                <label for="to_date" class="col-sm-1 col-form-label">From Date:</label>
                                <div class="col-md-3">
                                <input type="date" name="from_date" class="form-control required" value="" min='' max="" />  
                                </div>
                                <label for="to_date" class="col-sm-1 col-form-label">To Date:</label>
                                <div class="col-md-3">
                                    <input type="date" name="to_date" class="form-control required" value=""  min='' max=""/> 
                                </div>
                                <div class="col-md-2"><input type="submit" class="form-control required"></div>
                                </div>
                              </form>
                              
                <?php   if($all_data) {    ?>
                    <div class="row">
                <div class="col-lg-12 contant-wraper">
                    <div id="divToPrint">
                        <div style="text-align:center;">
                            <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                            <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
                            <h4>Purchase Between: <?php echo date('d/m/Y',strtotime($frmDt)); ?> To <?php echo date('d/m/Y',strtotime($toDt)); ?></h4>
                            <h5 style="text-align:left"><label>Gst No: </label> <?php $gstin = Auth::user()->gstin; echo $gstin;?></h5>
                        </div>
                        <br>  
                        <table style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Company</th>
                                <th>Product</th>
                                <th>Society</th>
                                <th>Sale invoice</th>
                                <th>Ro dt</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Taxable Amt</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>Discount</th>
                                <th>Total amt</th>
                                <th>Cotainer</th>
                            </tr>

                            </thead>

                            <tbody>

                                <?php

                                    if($all_data){ 
                                        
                                $i = 1;
                                $total      = 0.00;
                                $tot_cgst   = 0.00;
                                $tot_sgst   = 0.00;
                                $tot_taxamt = 0.00;
                                $tot_dis    = 0.00;
                                $tot_qty    = 0.00;
                                $val        = 0;
                                $sal_qty     =0.00;
                                $totsld_sal  = 0.00;
                                $totlqd_sal  = 0.00;

                                        foreach($all_data as $sal){
                                ?>
                                    <tr class="rep">
                                        <td class="report"><?php echo $i++; ?></td>
                                        <td class="report"><?php echo $sal->short_name; ?></td>
                                        <td class="report"><?php echo $sal->PROD_DESC; ?></td>
                                        <td class="report"><?php //echo get_fersociety_name($sal->soc_id);?></td>
                                        <td class="report"><?php echo $sal->trans_do; ?></td>
                                        <td  class="report"><?php echo date("d/m/Y",strtotime($sal->do_dt)); ?></td>
                                        <!-- <td class="report"><?php //echo $sal->trans_type; ?></td> -->
                                        <td class="report"><?php 
                                        if($sal->unit==1 ||$sal->unit==2 ||$sal->unit==4 || $sal->unit==6){
                                                    echo "MTS" ;  
                                                }elseif($sal->unit==3||$sal->unit==5){
                                                    echo "LTR" ;
                                                }
                                                ?>
                                                </td>
                                        
                                        <td class="report">
                                            <?php 
                                            // echo $sal->qty;
                                            if($sal->unit==1){

                                                echo $sal->qty; 
                                            $sal_qty=$sal->qty*1000/$sal->qty_per_bag;
                                            $totsld_sal+=$sal->qty;
                                            }elseif($sal->unit==2){
                                                echo ($sal->qty)/1000; 
                                                $sal_qty=($sal->qty)/$sal->qty_per_bag; 
                                                $totsld_sal+=($sal->qty)/1000;
                                            }elseif($sal->unit==4){
                                                echo ($sal->qty)/10;
                                                $sal_qty=($sal->qty)/10;
                                                $totsld_sal+=$sal_qty;
                                            }elseif($sal->unit==6){
                                                echo ($sal->qty)/1000000;
                                                $sal_qty=($sal->qty)*1000/$sal->qty_per_bag;
                                                $totsld_sal+=($sal->qty)/1000000;
                                            }elseif($sal->unit==3){
                                                echo $sal->qty;
                                                $sal_qty=$sal->qty*1000/($sal->qty_per_bag);
                                                $totlqd_sal+=$sal->qty;
                                            }elseif($sal->unit==5){
                                                echo ($sal->qty)/1000; 
                                                $sal_qty=($sal->qty)/($sal->qty_per_bag); 
                                                $totlqd_sal+=($sal->qty)/1000;
                                            }

                                        //   $tot_qty += $sal->qty;
                                        $tot_qty +=$sal_qty;
                                        ?>
                                        </td>
                                        <!-- <td class="report"><?php echo $sal->sale_rt; ?></td> -->
                                        <td class="report"><?php echo $sal->taxable_amt; 
                                        $tot_taxamt += $sal->taxable_amt;?></td>
                                        <td class="report"><?php echo $sal->cgst; 
                                        $tot_cgst += $sal->cgst;?></td>
                                        
                                        <td class="report"><?php echo $sal->sgst; 
                                        $tot_sgst += $sal->sgst;?></td>
                                        
                                        <td class="report"><?php echo $sal->dis;
                                        $tot_dis += $sal->dis; ?></td>
                                        <td class="report"><?php echo $sal->tot_amt; 
                                        $total += $sal->tot_amt; ?>
                                        </td>
                                        <td class="report" type="text"colspan="8"id="container">
                                            <?php 
                                                // foreach($opening as $opndtls){
                                                //     if($prodtls->prod_id==$opndtls->prod_id){
                                                        if($sal->unit==1){

                                                            echo ceil(number_format((float)($sal->qty*1000 )/$sal->qty_per_bag,3,'.',''));                                                      
                                                        
                                                        }elseif($sal->unit==2){
                                                            echo ceil(number_format((float)( $sal->qty)/$sal->qty_per_bag,3,'.',''));                                          
                                                        }elseif($sal->unit==4){
                                                            echo ceil(number_format((float)( $sal->qty)*100/$sal->qty_per_bag,3,'.',''));
                                                        
                                                        }elseif($sal->unit==6){
                                                        echo ceil(number_format((float)( $sal->qty)*1000/$sal->qty_per_bag,3,'.',''));
                                                        }elseif($sal->unit==3){
                                                        echo ceil(number_format((float)( $sal->qty)/$sal->qty_per_bag,3,'.',''));
                                                    
                                                        }elseif($sal->unit==5){
                                                    echo ceil(number_format((float)( $sal->qty*1000)/$sal->qty_per_bag,3,'.',''));
                                                    //     }
                                                    // }
                                                }
                                                
                                            ?>
                                        </td>
                                    
                                    </tr>
    
                                    <?php  
                                                            
                                        }
                                    ?>
    
                                    <?php 
                                        }
                                    else{

                                        echo "<tr> <td></td><td></td><td></td>
                                        <td></td><td></td><td></td><td></td>
                                        <td></td><td></td><td></td>
                                        <td></td><td  style='text-align:center;'>No Data Found</td>
                                        <td></td><td></td><td></td>
                                        </tr>";

                                    }   
                                ?>
                                
                                
                            </tbody>
                            <tfooter>
                                <tr>
                                <td class="report" colspan="7" style="text-align:right">Total</td> 
                                <!-- <td class="report"><?=$tot_qty?></td> -->
                                <td class="report"></td>
                                <td class="report"><?=$tot_taxamt?></td>
                                <td class="report"><?=$tot_cgst?></td>
                                <td class="report"><?=$tot_sgst?></td> 
                                <td class="report"><?=$tot_dis?></td>
                                <td class="report"><?=$total?></td>  
                                </tr>
                                <tr>
                                <td class="report" colspan="12" style="text-align:left" bgcolor="silver" ><b>Summary</b></td>

                                <td class="report" colspan="1" style="text-align:center" bgcolor="silver"><b>Sale</b></td>
                                
                                </tr>
                                <tr>
                                <td class="report" colspan="12" style="text-align:left" bgcolor="silver"><b>Solid( MTS) </b></td> 
                                <td class="report" colspan="1" style="text-align:center" bgcolor="silver"><?=$totsld_sal?></td>
                                </tr>
                                <tr>
                                <tr>
                                <td class="report" colspan="12" style="text-align:left" bgcolor="silver"><b>Liquid( LTR ) </b></td> 
                                <td class="report" colspan="1" style="text-align:center" bgcolor="silver"><?= $totlqd_sal?></td>
                                </tr>
                            </tfooter>
                        </table>
                    </div>   
                </div>
                </div>
                <div style="text-align: center;">
                    <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
                   <!-- <button class="btn btn-primary" type="button" id="btnExport" >Excel</button> -->
                </div>
            <?php } ?>
            
            
               
                        </div>
                    </div>
                </div>
		    </div>
        </div>
<?php echo View::make('common/footer'); ?>
