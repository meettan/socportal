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
                                                            class="fa fa-user" aria-hidden="true"></i>Check out
                                                        </a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="home" class="tab-pane fade in active tabContent">
                                                <div class="col-sm-12">
                                                <div class="full_field_col3">
                                                                <span>Date:</span>
                                                                <input type="text" name="dates"
                                                                    value="<?=date('d/m/Y')?>" readonly>
                                                            </div>
                                                            <div class="full_field_col3">
                                                                <span>Name:</span>
                                                                <input type="text" name="name"
                                                                    value="{{Auth::user()->soc_name}}" readonly>
                                                            </div>
                                                           
                                                </div>
                                                <div class="col-sm-12">
                                                <?php $amt = Session::get('data.amount'); ?>
                                                            <div class="full_field_col3">
                                                                <span>Amount:</span> <input type="text" name="amt"
                                                                    value="{{$amt/100}}" readonly>
                                                            </div>
                                                            <div class="full_field_col3">
                                                                <span>Order No:</span>
                                                                <input type="text" name="name"
                                                                    value="{{Session::get('data.order_id')}}" readonly>
                                                            </div>
                                                </div>
                                                    <div class="col-sm-12">
                                                        <div class="full_field_col3">
                                                            @if(Session::has('data'))

                                                            <div class="tex-center mx-auto">
                                                                <button id="rzp-button1" class="btn btn-primary">Checkout
                                                                    </button>
                                                            </div>

                                                            <script src="https://checkout.razorpay.com/v1/checkout.js">
                                                            </script>
                                                            <script>
                                                            var options = {
                                                                "key": "rzp_test_OWzJfVy5ZI6cj1", // Enter the Key ID generated from the Dashboard
                                                                "amount": "{{Session::get('data.amount')}}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                                                "currency": "INR",
                                                                "name": "Benfed",
                                                                "description": "Test Transaction",
                                                                "image": "https://img.favpng.com/22/17/14/coffee-cup-breakfast-cafe-png-favpng-wum4UMesrHMdFxfe11NikwYbu.jpg",
                                                                "order_id": "{{Session::get('data.order_id')}}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                                                                "callback_url": "{{route('pay')}}",
                                                                // "prefill": {
                                                                //     "name": "Lokesh kumar",
                                                                //     "email": "lokesh@synergicsoftek.com",
                                                                //     "contact": "9007507220"
                                                                // },
                                                                // "notes": {
                                                                //     "address": "Razorpay Corporate Office"
                                                                // },
                                                                "theme": {
                                                                    "color": "#228ed3"
                                                                }
                                                            };
                                                            var rzp1 = new Razorpay(options);
                                                            rzp1.on('payment.failed', function(response) {
                                                                console.log(response);
                                                                var order_id = response.error.metadata.order_id;
                                                                var payment_id=response.error.metadata.payment_id;
                                                                // alert(response.error.code);
                                                                // alert(response.error.description);
                                                                // alert(response.error.source);
                                                                // alert(response.error.step);
                                                                // alert(response.error.reason);
                                                                // alert(response.error.metadata.order_id);
                                                                // alert(response.error.metadata.payment_id);
                                                                $.ajax({
                                                                    type: 'GET',
                                                                    url: 'failedresponse',
                                                                    data: {
                                                                        order_id: response.error.metadata.order_id,
                                                                        payment_id:response.error.metadata.payment_id,
                                                                        code:response.error.code,
                                                                        description:response.error.description,
                                                                        reason:response.error.reason

                                                                    },
                                                                    success: function(data) {
                                                                        console.log(data);
                                                                        // var order_id = response.error.metadata.order_id;
                                                                        window.location.href = "{{route('error')}}/"+data;

                                                                    }
                                                                });
                                                            })  
                                                            document.getElementById('rzp-button1').onclick =
                                                                function(e) {
                                                                    rzp1.open();
                                                                    e.preventDefault();
                                                                }
                                                            </script>

                                                            @endif
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
    </div>
</div>
@endsection
@section('script')
<script>
$('input[type="radio"]').click(function() {
    if ($(this).is(':checked')) {
        alert($(this).val());
    }
});
</script>
@endsection