<div class="col-lg-12 contant-wraper">
                
                <div id="divToPrint" class="divToPrintClass">

                    <div style="text-align:center;">

                        <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                        <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
                        <h4>Society Ledger Between: <?php //echo $_SESSION['date']; ?></h4>
                        <h5 style="text-align:left"><label>District: </label> <?php //echo $br_name->district_name; ?></h5>
						<h5 style="text-align:left"><label>Society: </label> <?php if($all_data) { foreach($all_data as $prodtls);echo $prodtls->soc_name; }?></h5>
						<h5 style="text-align:left"><label>Gst No: </label> <?php if($all_data) ?></h5>

                    </div>
                    <br>  

                    <table style="width: 100%;" id="example">
                        <thead>

                            <tr>
                                <th>Sl No.</th>
                                <th>Remarks</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Invoice/
                                    Receipt No.</th>
                                <th>RO</th>
                                <th>RO/
                                    Deposit Date</th>
                                <th>Qty</th>
                                <th>Taxable 
                                    Amount</th>
                                <th>CGST</th>
                                <th>SGST</th>
								<th>Total 
                                    Amount</th>
                                <th>Advance/
								    Credit Note</th>
                                <th>Adjusted 
                                    Amount
                                    (Cheque/Draft/
                                    Payorder/NEFT/
                                    RTGS)
                                 </th>
                                 <th>Dr</th>
                                 <th>Cr</th>
                                
                            </tr>

                        </thead>

                        <tbody>

                            <?php

                                if($all_data){ 
									
                                    $i = 1;
                                    $total = 0.00;
                                    $tot_sale = 0.00;
                                    $tot_pur  = 0.00;
                                    $taxable=0.00;
                                    $val =0;
                                    $qty=0.000;
                                    $tot_cgst=0.00;
                                    $tot_sgst=0.00;
                                    $totalamount=0.00;
                                    $advCrnote=0.00;
                                    $adjustable=0.00;
                                    $saleAmt=0.00;
                                    $totalamt=0.00;

                                    foreach($all_data as $prodtls){
                            ?>

                                <tr class="rep">
                                     <td class="report"><?php echo $i++; ?></td>                            <!--SL. No.--->
                                     <td><?php echo $prodtls->remarks; ?></td>                              <!--Remarks--->
                                     <td class="report opening" id="opening">                               <!--Date--->
                                        <?php echo date('d/m/Y',strtotime($prodtls->trans_dt)); ?>
									 </td>
                                     <td><?php echo $prodtls->prod; ?></td>                               
                                     <td><?= $prodtls->inv_no; ?></td>                                      <!--Invoice/Receipt no.--->
                                     <td class="report"><?php echo $prodtls->ro_no; ?></td>                 <!--RO--->
                                     <td class="report opening" id="opening">                               <!--Ro Date/Deposit Date--->
                                        <?php if($prodtls->remarks!='Opening'){ echo date('d/m/Y',strtotime($prodtls->ro_dt));} ?>
									 </td>
                                     <td class="report purchase" id="purchase">                             <!--Quantity--->
                                        <?php echo $prodtls->qty; $qty+=$prodtls->qty; ?>
                                     </td>
									 <td class="report purchase" id="purchase">                            <!--Taxable Amount--->
                                        <?php echo $prodtls->tot_payble;
                                              $taxable += $prodtls->tot_payble  ?>
                                     </td>
									 <td class="report sale" id="sale">                                     <!--CGST--->
                                        <?php echo $prodtls->cgst; 
                                            $tot_cgst += $prodtls->cgst;?>
                                     </td>
                                     <td class="report sale" id="sale">                                     <!--SGST--->
                                        <?php echo $prodtls->sgst; 
                                        $tot_sgst += $prodtls->sgst ;?>
                                     </td>
                                     <td class="report sale" id="sale">                                     <!--Total Amount--->
                                        <?php  echo  $prodtls->tot_payble +$prodtls->cgst + $prodtls->sgst;  
                                                $totalamount += $prodtls->tot_payble +$prodtls->cgst + $prodtls->sgst;
                                                $saleAmt += $prodtls->tot_payble +$prodtls->cgst + $prodtls->sgst; ?>
                                     </td>
                                     <td>                                                                   <!--Advance/Credit Note Amount--->
                                        <?php  if($prodtls->remarks=='Opening'){                          
										        echo '0.00';
									          }else{
										        echo round(abs($prodtls->tot_paid),2) ; $advCrnote+=$prodtls->tot_paid;}
									    ?>
                                     </td>
									 <td class="report sale" id="sale">                                     <!--Adjustable Amount--->
                                        <?php if($prodtls->remarks=='Opening'){
										    echo '0.00';
										}else{	echo ($prodtls->tot_recv);
										    $adjustable +=($prodtls->tot_recv);
									    }
									   ?>
                                     </td>
                                     <?php 
										
                                     if($prodtls->remarks=='Opening'){
                                       	 
                                        $totalamt = (($prodtls->tot_recv) +($prodtls->tot_paid));
                                       
                                        if($totalamt>0){
                                            $totalamt =$totalamt;
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs($totVal)."</td>";
                                            echo"<td></td>";
                                        }
                                        if($totalamt<0){
                                            $totalamt =$totalamt;
                                            echo"<td></td>";
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                           
                                        }
                                     
                                     }elseif($prodtls->remarks=='Advance'||$prodtls->remarks=='Cr note'){

                                        $totalamt -= (($prodtls->tot_paid));

                                        if($totalamt>0){
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs($totVal)."</td>";
                                            echo"<td></td>";
                                        }
                                        if($totalamt<0){
                                            echo"<td></td>";
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                           
                                        }

                                    }elseif( $prodtls->remarks=='NEFT Adj' || $prodtls->remarks=='Pay Order Adj' || $prodtls->remarks=='Draft Adj'|| $prodtls->remarks=='Cheque Adj'){
                                        
										$totalamt -= (($prodtls->tot_recv));
                                        if($totalamt>0){
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs($totVal)."</td>";
                                            echo"<td></td>";
                                        }
                                        if($totalamt<0){
                                            echo"<td></td>";
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                           
                                        }

                                     }elseif($prodtls->remarks=='Sale'){
                                      
                                      $totalamt += $prodtls->tot_payble +$prodtls->cgst + $prodtls->sgst;
  
                                        if($totalamt>0){
                                           
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                            echo"<td></td>";
                                        }
                                        if($totalamt<0){
                                            echo"<td></td>";
                                            $totVal=round($totalamt, 2);
                                            echo"<td>".abs( $totVal)."</td>";
                                           
                                        }
                                     }
                                     ?>
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
							<tr style="font-weight: bold;">
                            <td></td><td></td><td></td><td></td>
                            <td></td><td></td><td></td>
                               <td class="report" style="text-align:right">Total</td> 
                               <td class="report"><?=$taxable?></td>
                                <td class="report"><?=$tot_cgst?></td>  
                                <td class="report"><?=$tot_sgst?></td>  
                                <td class="report"><?=$totalamount?></td>  
                                <td class="report"><?=$advCrnote?></td>  
                                <td class="report"><?=$adjustable?></td> 
                                <td></td> 
                                <td></td>
                            </tr>
							
                        </tbody>
                    </table>
                </div>   
                
                <div style="text-align: center;">
                    <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
                   <!-- <button class="btn btn-primary" type="button" id="btnExport" >Excel</button> -->
                </div>
            </div>