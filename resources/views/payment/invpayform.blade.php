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
                            <div class="wrapper_fixed">
                                <div class="row">
                                    <div class="signUpCardLayoutMain">
                                        <div class="signUpCardLayout-card memberShipArea" style="padding-bottom: 0;">
                                            <ul class="tabUl nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#home"><i
                                                            class="fa fa-user" aria-hidden="true"></i>Invoice Payment
                                                        </a></li>
                                                @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                                <li>@if(Session::has('error'))
                                                    <div class="alert alert-danger">
                                                        {{ Session::get('error')}}
                                                    </div>
                                                    @endif
                                                    @if(Session::has('amt_error'))
                                                    <div class="alert alert-danger">
                                                        {{ Session::get('amt_error')}}
                                                    </div>
                                                    @endif
                                                    @if(Session::has('success'))
                                                    <div class="alert alert-success">
                                                        {{ Session::get('success')}}
                                                    </div>
                                                    @endif
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="home" class="tab-pane fade in active tabContent">
                                                    <form action="{{'invpaymentrequest'}}" method="post"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" value="{{Auth::user()->soc_id}}"
                                                            name="soc_id">
                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                <span>Date:</span>
                                                                 <input type="text" name="do_dt" value='<?=date('d/m/Y')?>' disabled>
                                                            </div>
                                                            <div class="full_field_col3">
                                                                <span>Invoice No:</span>{{$data['invoice_id']}}
                                                            <input type='hidden' value="{{$data['invoice_id']}}" name="invoice_id">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                <span>RO No:</span>{{$data['ro_no']}}
                                                                <input type='hidden' value="{{$data['ro_no']}}" name="ro_no">
                                                            </div>
                                                            
                                                            <div class="full_field_col3">
                                                                <span>Invoice Amount:</span>{{$data['invoice_amt']}}
                                                                <input type='hidden' value="{{$data['invoice_amt']}}" name="invoice_amt">
                                                            </div>
                                                         </div>
                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                <span>Name:</span>
                                                                <input type="text" name="name"
                                                                    value="{{Auth::user()->soc_name}}" readonly>
                                                            </div>
                                                            <div class="full_field_col3">
                                                                <span>Amount:</span>{{$data['amount']}} <input type="hidden" name="amt"
                                                                    value="{{$data['amount']}}" >
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="ptype" value="I">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Payment
                                                                    Mode:</label>
                                                                <div class="col-sm-8">
                                                                    <label class="radio-inline"> <input type="radio"
                                                                            name="pay_mode" id="csh" value="C" >
                                                                        Cash </label>
                                                                    <label class="radio-inline"> <input type="radio"
                                                                            name="pay_mode" id="cq" value="Q"> Cheque
                                                                    </label>
                                                                    <label class="radio-inline"> <input type="radio"
                                                                            name="pay_mode" id="ib" value="I" checked> Internet
                                                                        Banking </label>
                                                                </div>
                                                            </div>
                                                            <br> <br>
                                                        </div>
                                                        <div class="col-sm-12" id='chque_detail'>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="full_field_col3">
                                                                        <span>Cheque No:</span> <input type="text"
                                                                            name="cheque_no" value="">
                                                                    </div>
                                                                    <div class="full_field_col3">
                                                                        <span>Cheque Date:</span>
                                                                        <input type="date" name="cheque_dt" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="full_field_col3">
                                                                        <span>Bank name:</span> <input type="text"
                                                                            name="bank_name" value="">
                                                                    </div>
                                                                    <div class="full_field_col3">
                                                                        <span>IFS CODE:</span> <input type="text"
                                                                            name="ifs_code" value="">
                                                                    </div>
                                                                 </div>
                                                                <div class="col-sm-12">
                                                                    <div class="full_field_col3">
                                                                        <span>Upload Cheque Scan copy:</span> <input
                                                                            type="file" name="image" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                @if(!Session::has('data'))

                                                                <input type="submit" class="btn btn-primary"
                                                                    value="NEXT">
                                                                @else

                                                                <div class="container tex-center mx-auto">
                                                                    <button id="rzp-button1">Pay with Razorpay</button>
                                                                </div>

                                                                <script
                                                                    src="https://checkout.razorpay.com/v1/checkout.js">
                                                                </script>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </form>
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
<script>
$( document ).ready(function() {
    $('#chque_detail').hide();  
});
  
$('input[type="radio"]').click(function() {
    var check = $(this).val();
    // if ($(this).is(':checked')) {
    //     alert($(this).val());
    // }
    if(check == 'Q'){
        $('#chque_detail').show();
    }else{
        $('#chque_detail').hide();
    }
    
});
</script>
@endsection