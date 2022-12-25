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
                                                    @if($formError)
                                                    <div class="alert alert-danger">
                                                        Please fill all mandatory fields.
                                                    </div>
                                                    @endif
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="home" class="tab-pane fade in active tabContent">
                                                    <form action="{{$action}}" method="post" name="payuForm" enctype='multipart/form-data'>
                                                        @csrf
                                                        <input type="hidden" value="{{Auth::user()->soc_id}}"
                                                            name="soc_id">
                                                        <input type="hidden" name="key" value="{{$MERCHANT_KEY}}" />
                                                        <input type="hidden" name="hash" value="{{$hash}}" />
                                                        <input type="hidden" name="txnid" value="{{$txnid}}" />


                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                <span>Date:</span>
                                                                <input type="text" name="do_dt"
                                                                    value='<?=date('d/m/Y')?>' disabled>
                                                            </div>
                                                            <div class="full_field_col3">
                                                                <span>Invoice No:</span>{{Session::get('invoice_id')}}
                                                                <input type='hidden'
                                                                    value="{{Session::get('invoice_id')}}"
                                                                    name="invoice_id">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                <span>RO No:</span>{{Session::get('ro_no')}}
                                                                <input type='hidden' value="{{Session::get('ro_no')}}"
                                                                    name="ro_no">
                                                            </div>


                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                <span>Name:</span>
                                                                <input type="text" name="firstname"
                                                                    value="{{Auth::user()->soc_name}}" readonly>
                                                            </div>
                                                            <div class="full_field_col3">
                                                                <span>Email:</span>
                                                                <input type="email" name="email" required
                                                                    value="{{isset($posted['email'])?$posted['email']:Auth::user()->email}}" >
                                                            </div>
                                                            <div class="full_field_col3">
                                                                <span>Phone No:</span>
                                                                <input type="text" name="phone" required
                                                                    value="{{Auth::user()->ph_number}}" >
                                                            </div>
                                                            <div class="full_field_col3">
                                                                <span>Amount: <strong style="padding: 10px;font-size: 18px;margin: 15px 5px 0px 15px;"> {{Session::get('amts')}}</strong></span>  
                                                                <input type="hidden" name="amount"
                                                                    value="{{Session::get('amts')}}">
                                                            </div>

                                                            <input type="hidden" name="productinfo"
                                                                value="invoice payment" readonly>

                                                        </div>
                                                        <input type="hidden" name="ptype" value="I">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Payment
                                                                    Mode:</label>
                                                                <div class="col-sm-8">
                                                                    <!-- <label class="radio-inline"> <input type="radio"
                                                                            name="pay_mode" id="csh" value="C">
                                                                        Cash </label> -->
                                                                    <label class="radio-inline"> <input type="radio"
                                                                            name="pay_mode" id="cq" value="Q"> Cheque
                                                                    </label>
                                                                    <label class="radio-inline"> <input type="radio"
                                                                            name="pay_mode" id="ib" value="I" checked>
                                                                        Internet
                                                                        Banking </label>
                                                                </div>
                                                            </div>
                                                            <br> <br>
                                                        </div>
                                                        <div class="col-sm-12" id='chque_detail'>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="full_field_col3">
                                                                        <span>Cheque No:</span> <input type="text" id="cheque_no"
                                                                            name="cheque_no" value="">
                                                                    </div>
                                                                    <div class="full_field_col3">
                                                                        <span>Cheque Date:</span>
                                                                        <input type="date" name="cheque_dt" id="cheque_dt" value="" min="<?=date('Y-m-d',strtotime(date('Y-m-d').'-6 months'))?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="full_field_col3">
                                                                        <span>Bank name:</span> <input type="text"  id="bank_name"
                                                                            name="bank_name" value="">
                                                                    </div>
                                                                    <div class="full_field_col3">
                                                                        <span>IFS CODE:</span> <input type="text" id="ifs_code"
                                                                            name="ifs_code" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="full_field_col3">
                                                                    <span>Upload Cheque Scan copy </span><span style="color:red">(jpg,jpeg Allowed and Size upto 2MB):</span> <input
                                                                            type="file" name="image" value="" id='image'>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input name="surl" value="{{route('success')}}" hidden />
                                                        <input name="furl" value="{{route('error')}}" hidden />
                                                        <input name="curl" value="{{route('cancel')}}" hidden />
                                                        
                                                        <input name="udf1"
                                                            value="{{auth()->user()->pan.'|'.Session::get('raw_password')}}"
                                                            hidden />
                                                        <input name="udf2" value="{{auth()->user()->soc_id}}" hidden />
                                                        <input name="udf3"
                                                            value="{{Session::get('socuserdtls')->district}}" hidden />
                                                        <input name="udf4" value="{{Session::get('payment_type')}}"
                                                            hidden />
                                                        <input name="udf5" value="{{Session::get('invoice_id')}}"
                                                            hidden />

                                                        @if(!$hash)
                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                <input type="submit" class="btn btn-primary"
                                                                    value="Pay">
                                                            </div>
                                                        </div>
                                                        @endif
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
$(document).ready(function() {
    $('#chque_detail').hide();

    var hash = '{{$hash}}';

    if (hash == '') {
        return false;
    } else {
        var payuForm = document.forms.payuForm;
        payuForm.submit();
    }

});

$('input[type="radio"]').click(function() {
    var check = $(this).val();
    // if ($(this).is(':checked')) {
    //     alert($(this).val());
    // }
    if (check == 'Q') {
        $('#chque_detail').show();
        $("#cheque_no").prop('required',true);
        $("#cheque_dt").prop('required',true);
        $("#bank_name").prop('required',true);
        $("#ifs_code").prop('required',true);
        $("#image").prop('required',true);
    } else {
        $('#chque_detail').hide();
        $("#cheque_no").prop('required',false);
        $("#cheque_dt").prop('required',false);
        $("#bank_name").prop('required',false);
        $("#ifs_code").prop('required',false);
        $("#image").prop('required',false);
    }

});
</script>

@endsection