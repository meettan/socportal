<?php echo View::make('common/header'); ?>
<div class="content-wrapper">
			<div class="samllWrapper">
			<div class="contentHeaderTop">
			<p><?=date("l F j ")?></p>
				<h2>Good afternoon</h2>
			</div>
		<div class="twoColomSec">
		<div class="col-sm-6 float-left">
			<div class="boxSecMain">
				<h2>Outstanding</h2>
				<div class="boxSecMainDescrip">
				<div class="price"><i class="fa fa-inr" aria-hidden="true"></i> <span>50,250.85 <strong class="crCus">Cr</strong></span></div>
				</div>
				<a href="#" class="buttonBoxOut">Pay Now</a>
			</div>
		</div>
		<div class="col-sm-6 float-left">
			<div class="boxSecMain">
				<h2>Download Invoice / Receipts</h2>
				<div class="boxSecMainDescrip">
					<ul class="downList">
					<li>
						<a href="{{'salesfilter'}}"><div class="iconSec boxColor1"><img src="{{ url('public/images/sale.png') }}" alt=""/></div> Sale</a>
					</li>
						
					<li>
						<a href="{{'drcrnote'}}"><div class="iconSec boxColor2"><img src="{{ url('public/images/credit.png') }}" alt=""/></div> Credit Note</a>
					</li>
						
					<li>
						<a href="{{'advancefilter'}}"><div class="iconSec boxColor3"><img src="{{ url('public/images/advance.png') }}" alt=""/></div> Advance</a>
					</li>
					<li>
						<a href="{{'socpayment'}}"><div class="iconSec boxColor4"><img src="{{ url('public/images/moneyRece.png') }}" alt=""/></div> Money Receipt</a>
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
					<div class="imgsec"><img src="{{ url('public/images/report.png') }}" alt=""/></div>
					<h5>Society ledger</h5>
					<p>Assign a task to start collaborating</p>
					
					<button type="button" class="viewMore">View More</button>
					
				</div>
				
				</div>
				
				<div class="col-sm-4 float-left">
				<div class="reportBoxMainList">
					<div class="imgsec"><img src="{{ url('public/images/report.png') }}" alt=""/></div>
					<h5>Purchase history</h5>
					<p>Assign a task to start collaborating</p>
					
					<button type="button" class="viewMore">View More</button>
				</div>
				
				</div>
				
				<div class="col-sm-4 float-left">
				<div class="reportBoxMainList">
					<div class="imgsec"><img src="{{ url('public/images/report.png') }}" alt=""/></div>
					<h5>Purhase history</h5>
					<p>Assign a task to start collaborating</p>
					<button type="button" class="viewMore">View More</button>
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
<?php echo View::make('common/footer'); ?>