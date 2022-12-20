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

                    <h1>Your payment Failed</h1>
                    <div class="row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                            <p style="font-size: 18px;font-weight: 700;color: red;">Fee Amount: {{$details->amount}}
                            </p>
                            <p style="font-size: 18px;font-weight: 700;color: red;">Status: {{$details->status}}</p>
                            <p style="font-size: 18px;font-weight: 700;color: red;">Transaction id: {{$details->payment_id}}</p>
                        </div>
                    </div>

                    <a class="btn btn-info" href="{{route('paymentlist')}}">OK </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection