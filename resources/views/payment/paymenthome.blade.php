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
                            <div class="col-sm-8 float-left" style="color: #6ed96e;">
                                <div class='col-md-12' style="margin-bottom:10px">
                                <div class='col-md-6'><h3> Advance Payment</h3></div>
                                <div class='col-md-2'> 
                                    <a href="{{route('advpayment')}}">
                                    <button type="button" class="btn btn-primary">Payment</button></a>
                                </div>
                                </div>
                                 </br>
                                <div class='col-md-12'>
                                <div class='col-md-6'><h3> Invoice Payment</h3></div>
                                <div class='col-md-6'> 
                                    <a href="{{route('invpayment')}}">
                                    <button type="button" class="btn btn-primary">Payment</button></a>
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
</div>
@endsection
@section('script')
@endsection