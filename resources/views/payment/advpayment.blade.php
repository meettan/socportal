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
                                                            class="fa fa-user" aria-hidden="true"></i>Advance
                                                        Payment</a></li>
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
                                                    <form action="{{$action}}" method="post" name="payuForm" id='form'
                                                        enctype="multipart/form-data">
                                                        @csrf

                                                        <input type="hidden" value="{{Auth::user()->soc_id}}"
                                                            name="soc_id">
                                                        <input type="hidden" name="key" value="{{$MERCHANT_KEY}}" />
                                                        <input type="hidden" name="hash" value="{{$hash}}" />
                                                        <input type="hidden" name="txnid" value="{{$txnid}}" />


                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                <span>Date:</span>
                                                                <input type="text" name="tr_date"
                                                                    value='<?=date('d/m/Y',strtotime(date('Y-m-d')))?>'
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-12">
                                                                <div class="full_field_col3">
                                                                    <span>Name:</span>
                                                                    <input type="text" name="firstname"
                                                                        value="{{Auth::user()->soc_name}}" readonly>
                                                                </div>
                                                                <div class="full_field_col3">
                                                                    <span>Email:</span>
                                                                    <input type="email" name="email"
                                                                        value="{{Auth::user()->email}}" required>
                                                                </div>
                                                                <div class="full_field_col3">
                                                                    <span>Phone No:</span>
                                                                    <input type="text" name="phone"
                                                                        value="{{Auth::user()->ph_number}}" required>
                                                                </div>
                                                                <div class="full_field_col3">
                                                                    <span>Amount:</span>
                                                                    <input type="text" name="amount" required
                                                                        value="{{isset($posted['amount'])?$posted['amount']:''}}">
                                                                </div>

                                                                <input type="hidden" name="productinfo"
                                                                    value="Advance payment" readonly>


                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="ptype" value="A">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Payment
                                                                    Mode:</label>
                                                                <div class="col-sm-8">
                                                                    <label class="radio-inline"> <input type="radio"
                                                                            name="pay_mode" id="csh" value="C">
                                                                        Cash </label>
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
                                                                        <span>Cheque No:</span> <input type="text"
                                                                            name="tr_date" value="">
                                                                    </div>
                                                                    <div class="full_field_col3">
                                                                        <span>Cheque Date:</span>
                                                                        <input type="date" name="tr_date" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="full_field_col3">
                                                                        <span>Bank name:</span> <input type="text"
                                                                            name="tr_date" value="">
                                                                    </div>
                                                                    <div class="full_field_col3">
                                                                        <span>IFS CODE:</span> <input type="text"
                                                                            name="tr_date" value="">
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
                                                        <input name="udf5" value="{{Session::get('adv_invoice_id')}}"
                                                            hidden />

                                                        @if(!$hash)
                                                        <div class="col-sm-12">
                                                            <div class="full_field_col3">
                                                                <input type="submit" class="btn btn-primary"
                                                                    value="Pay Now">

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

// $("#form").submit(function(){
//     event.preventDefault();
//   alert("Submitted");
// });

$('input[type="radio"]').click(function() {
    var check = $(this).val();
    // if ($(this).is(':checked')) {
    //     alert($(this).val());
    // }
    if (check == 'Q') {
        $('#chque_detail').show();
    } else {
        $('#chque_detail').hide();
    }

});

$('#amt').keyup(function(e) {
    var value = $("#amt").val();
    if (/\D/g.test(value)) {
        // Filter non-digits from input value.
        val2 = value.replace(/\D/g, '');
        $("#amt").val(val2);
    }
});
</script>
@endsection