@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Success Page</h2>
                <div class="dateCalenderSec">
                    <div class="calenderSec calenderSecCustome">
                   
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTgyobPWtA8sK4FUdJ7v2mVN1k1XYUwsy1q8A&usqp=CAU" class="img-fluid">

                    <h2>Your payment has been processed</h2>

                    <a class="btn btn-info" href="{{route('paymentlist')}}">OK </a> 

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection