<?php echo View::make('common/signupheader'); ?>
<div class="innerPageSecSignUp">
    <div class="signUpLeftInner">
        <div class="signUpLeftForm">
            <h2>Sign up</h2>
            @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error')}}
            </div>
            @endif
            <p>By signing up, I agree to the Benfed Privacy Policy and Terms of Service.</p>
            <form method="POST" action="{{ url('validatesocdetail') }}" id='signupForm' class="validatedForm">
                @csrf
                <label class="full_fieldSign">
                    <span>Pan No.</span>
                    <input type="text" placeholder="Pan No." name="pan" required id="pan">
                    <span class="error_p" style="color:red;font-size: 14px;"></span>
                </label>
                <label class="full_fieldSign">
                    <span>Email Id</span>
                    <input type="email" name="email" required>
                </label>

                <label class="full_fieldSign">
                    <span>Password</span>
                    <input type="password" name="password" id="password" required>
                    <span class="error" style="color:red;font-size: 14px;"></span>
                </label>

                <label class="full_fieldSign">
                    <span>Confirm Password</span>
                    <input type="password" name="password_confirm" id="confirm_password" required>
                    <span class="errors" style="color:red;font-size: 14px;"></span>
                </label>

                <input type="submit" value="Continue" class="signUpBtn" id="submit">
        </div>
        </form>
    </div>

    <div class="signUpRightInner">
        <div class="signUpRightInnerSub">
            <div class="signUpRightInnerSubMain">
                <img class="feature-callout__img" src="{{ url('public/images/005100.png') }}" alt="Image of team"
                    width="112">
                <h2>Please Follow The Steps</h2>

                <div class="list">
                    <ul>
                        <li>Supply your PAN No.</li>
                        <li>Email Id</li>
                        <li>Password must contain one uppercase letter</li>
                        <li>One lowercase case letter</li>
                        <li>One special Character and length must be 8 Digit</li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="footerSec">
    <div class="footerSecSub1">
        <div class="wrapperCus">
            <div class="col-sm-6 float-left">
                <h2>Contact Us</h2>
                <p><strong>The West Bengal State Co-operative Marketing Federation Ltd.</strong>
                    Southend Conclave, 3rd Floor,
                    1582 Rajdanga Main Road,
                    Kolkata - 700 107.</p>
                <p>Phone: +91 33 2441 4366/67, Fax: +91 33 2441-4372<br>
                    Email: info@benfed.org</p>

            </div>
            <div class="col-sm-6 float-left">
                <h2>Head Office</h2>
                <p><strong>The West Bengal State Co-operative Marketing Federation Ltd.</strong>
                    Southend Conclave, 3rd Floor,
                    1582 Rajdanga Main Road,
                    Kolkata - 700 107.</p>
                <p>Phone: +91 33 2441 4366/67, Fax: +91 33 2441-4372<br>

                    Email: info@benfed.org</p>
            </div>
        </div>
    </div>

    <div class="footerSecSub2">
        <div class="wrapperCus">
            Copyright © 2022 benfed.org. All Rights Reserved.
        </div>
    </div>

</div>

<script src="{{ url('public/js/bootstrap.min.js') }}"></script>
<script src="{{ url('public/js/main_javascript.js') }}"></script>
<script src="{{ url('public/js/main_jquery.js') }}"></script>
</body>

</html>

<script>
$('#pan').change(function() {
    var pan = $(this).val();
    $.ajax({
        type: 'GET',
        url: 'panvalidate',
        data: {
            pan: pan
        },
        success: function(data) {

            if (data.status == 1) {
                console.log('sdsdfds');
                $(".error_p").html("You already registered.");
                $("#pan").val("");
            } else if (data.status == 2) {
                $(".error_p").html("Pan not available");
                //$("#pan").val("");
            } else {
                $(".error_p").html("");

            }

        }
    });
});
var myInput = document.getElementById("password");
// var letter = document.getElementById("letter");
//   var capital = document.getElementById("capital");
//  var number = document.getElementById("number");
// var length = document.getElementById("length");
//  var character = document.getElementById("char");
var pass_val = false;

$('#password').keyup(function() {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if (myInput.value.match(lowerCaseLetters)) {
        // letter.classList.remove("invalid");
        // letter.classList.add("valid");
        $('.error').html('');
    } else {
        //alert('Password Contain a small letter');
        $('.error').html('Password Contain a small letter');
        //   letter.classList.remove("valid");
        //  letter.classList.add("invalid");
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if (myInput.value.match(upperCaseLetters)) {
        //capital.classList.remove("invalid");
        //capital.classList.add("valid");
        $('.error').html('');
    } else {
        //capital.classList.remove("valid");
        // capital.classList.add("invalid");
        $('.error').html('Password Contain a Uppercase letter');
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if (myInput.value.match(numbers)) {
        // number.classList.remove("invalid");
        //  number.classList.add("valid");
        $('.error').html('');
    } else {
        //  number.classList.remove("valid");
        // number.classList.add("invalid");
        $('.error').html('Password Contain a Number');
    }

    // Special character
    var char = /[#?!@$%^&*-]/g;
    if (myInput.value.match(char)) {
        //character.classList.remove("invalid");
        //character.classList.add("valid");
        $('.error').html('');
    } else {
        //character.classList.remove("valid");
        //character.classList.add("invalid");
        $('.error').html('Password Contain a Special Character');
    }

    // Validate length
    if (myInput.value.length >= 8) {
        //length.classList.remove("invalid");
        //length.classList.add("valid");
        $('.error').html('');
    } else {
        //length.classList.remove("valid");
        //length.classList.add("invalid");
        $('.error').html('Password Length Must be 8');
    }

    if (myInput.value.match(lowerCaseLetters) && myInput.value.match(upperCaseLetters) && myInput.value.match(
            numbers) && myInput.value.match(char) && myInput.value.length >= 8) {
        //     pass_val = true;
        $('.error').html('');
    } else {
        event.preventDefault();
        $('.error').html(
            'Please Enter valid Password(Password Must contain Uppercase,Lowercase,Specail Character and Length Must be 8 Digit)'
            );
    }
})

$('#confirm_password').on('change', function() {
    var re_pass = $(this).val();
    var pass = $('#password').val();
    if (pass == re_pass) {
        pass_chk = true;
        $('.errors').html('');
    } else {
        //pass_chk = false;
        event.preventDefault();
        $('.errors').html('Password not matched');
    }
})
$('#submit').click(function() {
    console.log($('.validatedForm').valid());
});
</script>