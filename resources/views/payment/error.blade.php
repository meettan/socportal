@extends('common.master')
@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="titleSec">
                <h2>Error Page</h2>
                <div class="dateCalenderSec">
                    <div class="calenderSec calenderSecCustome">
                   
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <img src="" class="img-fluid">

                <h2>Your payment Failed</h2>

<a class="btn btn-info" href="{{route('paymentlist')}}">OK </a> 

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection