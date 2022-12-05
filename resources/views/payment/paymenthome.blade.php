@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Payment</h2>
                <div class="dateCalenderSec">
                    <div class="calenderSec calenderSecCustome">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="twoColomSec">
            <div class="col-sm-12">
                <div class="boxSecMain">

                    <div class="reportBoxMain">
                        <div class="row">
                            <div class="col-sm-2 float-left">

                            </div>
                            <div class="col-sm-4 float-left">
                                <div class="reportBoxMainList">
                                    <div class="imgsec"><img src="{{ url('public/images/advance.png') }}" alt="" />
                                    </div>
                                    <h5>Advance Payment</h5>
                                    <!-- <p>Assign a task to start collaborating</p> -->
                                    <a href="{{'advpayment'}}"><button type="button" class="viewMore">View
                                            More</button></a>
                                </div>
                            </div>

                            <div class="col-sm-4 float-left">
                                <div class="reportBoxMainList">
                                    <div class="imgsec"><img src="{{ url('public/images/perchase_icon.png') }}"
                                            alt="" /></div>
                                    <h5>Invoice Payment</h5>
                                    <!-- <p>Assign a task to start collaborating</p> -->
                                    <a href="{{'invpayment'}}"><button type="button" class="viewMore">View More</button></a>
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
    </div>
</div>
@endsection
@section('script')
@endsection