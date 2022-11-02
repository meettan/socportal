<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/apps.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/apps_inner.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/res.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&display=swap" rel="stylesheet">
    </head>
<body>
    <div class="LoginCardLayout">
<div class="loginLeftSec">dfdsfgfdfgfdg</div>

        <div class="LoginCardLayout-card">
       <a href="{{route('login')}}"> <div class="LoginCardLayout-LoginLogoContainer "><img src="{{ url('public/images/logo.png') }}" alt=""
                    class="LoginCardLayout-LogoLogo" /></div></a>
            <div class="LoginDefaultView-content">
                @if(Session::has('msg'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('msg')}}
                </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
                @endif

                <form class="LoginEmailPasswordForm" method="POST" action="{{ route('loginConfrim') }}" id='signupForm'>
				@csrf
                    <div class="LoginEmailPasswordForm-emailAndPassword">

                        
                        <span class="Typography Typography--colorDarkGray1 Typography--s">Pan No.</span>
                        <input type="text"
                            class="TextInputBase SizedTextInput SizedTextInput--medium TextInput LoginEmailPasswordForm-emailInput"
                            placeholder="Pan No." name="pan" value="" autocomplete="username" autofocus="" id ="pan">
                        <span class="Typography Typography--colorDarkGray1 Typography--s">Password</span>
                        <input type="password"
                            class="TextInputBase SizedTextInput SizedTextInput--medium TextInput ValidatedTextInput-input OnBlurValidatedTextInput-input LoginEmailPasswordForm-passwordInput"
                            name="password" value="" autocomplete="username" autofocus="">
                    </div>
                    <span class="Typography Typography--colorDarkGray1 Typography--s"><a href="#">Forgot your
                            password?</a></span>
                    <div class="captureSec">
                        <span class="Typography Typography--colorDarkGray1 Typography--s"><strong>Enter the text as
                                shown in the image</strong> </span>
                        <input type="text"
                            class="TextInputBase SizedTextInput SizedTextInput--medium TextInput ValidatedTextInput-input OnBlurValidatedTextInput-input LoginEmailPasswordForm-passwordInput"
                            name="captcha" value="" autocomplete="username" autofocus="" id="captcha">
                        <span class="captureImg">{!! captcha_img() !!}</span>

                        <button type="button" class="btn btn-danger" class="reload" id="reload">
                            &#x21bb;
                        </button>

                    </div>
                    <input type="submit" value="Log in" class="loginBtn">
                </form>
                <div class="LoginDefaultView-signUp">
                    <span class="Typography Typography--colorDarkGray1 Typography--m">Don't have an account?</span>
                    <a class="LoginDefaultView-signUpButtonLink PrimaryLink BaseLink" href="{{route('register')}}">Sign
                        up</a>
                </div>
            </div>
            <span
                class="LoginCardLayout-captchaNotice Typography Typography--colorDarkGray1 Typography--s Typography--textAlignCenter">This
                site is protected by reCAPTCHA and the Google
                <a target="_blank" rel="noreferrer noopener" class="SecondaryLink BaseLink" href="#">Privacy Policy</a>
                and
                <a target="_blank" rel="noreferrer noopener" class="SecondaryLink BaseLink" href="#">Terms of Service
                </a> apply. </span>
        </div>
    </div>

    <script src="{{ url('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('public/js/main_javascript.js') }}"></script>
    <script src="{{ url('public/js/main_jquery.js') }}"></script>
</body>

</html>
<script>
$('img').click(function() {
    $(this).css({
        "-webkit-transform": "rotate(90deg)",
        "-moz-transform": "rotate(90deg)",
        "transform": "rotate(90deg)" /* For modern browsers(CSS3)  */
    });
});

$('#reload').click(function() {
    $.ajax({
        type: 'GET',
        url: 'reload-captcha',
        success: function(data) {
            $(".captureImg").html(data.captcha);
        }
    });
});

</script>