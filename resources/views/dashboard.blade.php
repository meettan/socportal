@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="samllWrapper">
        <div class="contentHeaderTop">
            <p><?=date("l F j ")?></p>
            <h2><?php
					date_default_timezone_set('Asia/Calcutta'); 
					/* This sets the $time variable to the current hour in the 24 hour clock format */
					$time = date("H");
				    /* If the time is less than 1200 hours, show good morning */
					if ($time < "12") {
						echo "Good morning";
					} else
					/* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
					if ($time >= "12" && $time < "17") {
						echo "Good afternoon";
					} else
					/* Should the time be between or equal to 1700 and 1900 hours, show good evening */
					if ($time >= "17" && $time < "19") {
						echo "Good evening";
					} else
					/* Finally, show good night if the time is greater than or equal to 1900 hours */
					if ($time >= "19") {
						echo "Good night";
					}
                    ?>
            </h2>
        </div>
        <div class="twoColomSec">
            <div class="col-sm-6 float-left">
                <div class="boxSecMain">
                    <h2>Outstanding</h2>
                    <div class="boxSecMainDescrip">
                        <div class="price"><i class="fa fa-inr" aria-hidden="true"></i> <span>{{round($amt, 2)}}
                            <?php if($soc_balance_amt_data == 'Cr.') { ?>
                                <strong class="crCus" style="color: #0000b9 !important">
                             {{$soc_balance_amt_data}}</strong>
                            <?php }else{  ?>
                            <strong class="crCus">
                             {{$soc_balance_amt_data}}</strong>
                            <?php } ?>
                        </span>
                    </div>
                    </div>
                    <a href="{{route('payment')}}" class="buttonBoxOut">Pay Now</a>
                </div>
            </div>
            <div class="col-sm-6 float-left">
                <div class="boxSecMain">
                    <h2>Download Invoice / Receipts</h2>
                    <div class="boxSecMainDescrip">
                        <ul class="downList">
                            <li>
                                <a href="{{route('salesfilter')}}">
                                    <div class="iconSec boxColor1"><img src="{{ url('public/images/sale.png') }}"
                                            alt="" /></div> Sale
                                </a>
                            </li>

                            <li>
                                <a href="{{route('drcrnote')}}">
                                    <div class="iconSec boxColor2"><img src="{{ url('public/images/credit.png') }}"
                                            alt="" /></div> Credit Note
                                </a>
                            </li>

                            <li>
                                <a href="{{route('advancefilter')}}">
                                    <div class="iconSec boxColor3"><img src="{{ url('public/images/advance.png') }}"
                                            alt="" /></div> Advance
                                </a>
                            </li>
                            <li>
                                <a href="{{route('socpayment')}}">
                                    <div class="iconSec boxColor4"><img src="{{ url('public/images/moneyRece.png') }}"
                                            alt="" /></div> Money Receipt
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>


            </div>
        </div>


        <div class="twoColomSec">
            <div class="col-sm-12">
                <div class="boxSecMain">

                    <h2>Reports</h2>

                    <div class="reportBoxMain">
                        <div class="row">

                            <div class="col-sm-4 float-left">
                                <div class="reportBoxMainList">
                                    <div class="imgsec"><img src="{{ url('public/images/society_icon.png') }}" alt="" />
                                    </div>
                                    <h5>Society ledger</h5>
                                    <!-- <p>Assign a task to start collaborating</p> -->
                                    <a href="{{route('socledger')}}"><button type="button" class="viewMore">View
                                            More</button></a>

                                </div>

                            </div>

                            <div class="col-sm-4 float-left">
                                <div class="reportBoxMainList">
                                    <div class="imgsec"><img src="{{ url('public/images/perchase_icon.png') }}"
                                            alt="" /></div>
                                    <h5>Purchase history</h5>
                                    <!-- <p>Assign a task to start collaborating</p> -->
                                    <a href="{{route('purrep')}}"><button type="button" class="viewMore">View More</button></a>
                                </div>
                            </div>

                            <div class="col-sm-4 float-left">
                                <div class="reportBoxMainList">
                                    <div class="imgsec"><img src="{{ url('public/images/payment_icon.png') }}" alt="" />
                                    </div>
                                    <h5>Payment history</h5>
                                    <!-- <p>Assign a task to start collaborating</p> -->
                                    <a href="{{route('paymentlist')}}"><button type="button" class="viewMore">View
                                            More</button></a>
                                </div>
                            </div>
                            <!-- <div class="col-sm-3 float-left">
				<div class="reportBoxMainList">
					<div class="imgsec"><img src="{{ url('public/images/report.png') }}" alt=""/></div>
					<h5>Subham Samanta</h5>
					<p>Assign a task to start collaborating</p>
					<button type="button" class="viewMore">View More</button>
				</div>
				</div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection