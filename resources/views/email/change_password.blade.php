<!-- <!DOCTYPE html><html><head><title>Password Change Email</title></head><body>
<h2>Welcome to the Benfed</h2><br/>Your registered email-id is  , Please click on the below link to Chnage your Password <br/>
<a href="" target="_blank">Verify Link</a>
</body></html>
<!doctype html> -->
<html>
<head>
<meta charset="utf-8">
<title>Index</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- <link rel="stylesheet" type="text/css" href="css/apps.css"> -->
	
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
<!--font-family: 'Roboto', sans-serif;-->
	
</head>
<style>
    body {
  font-family: 'Roboto', sans-serif;
 font-size: 14px; /* line-height: 18px;*/
  color: #344161;
  background: #f6f8f9;
  margin: 0;
  padding: 0;
  line-height: normal; 
  font-weight: 300;
  min-height: 100%;
  display: flex;
  flex-direction: column;
}

html{height: 100%;}


h1, h2, h3, h4, h5, h6, ul, ol, li, form, input, select, div, textarea {
  padding: 0;
  margin: 0
}
img {
  border: none;
  max-width: 100%;
  height: auto
}
.clear {
  margin: 0;
  padding: 0;
  clear: both
}
.after:after {
  content: "";
  display: block;
  clear: both;
  visibility: hidden
}
a {
  color: #05adff;
  text-decoration: none;
  padding: 0;
  margin: 0;
  outline: none;
  transition: all 0.3s;
  transition: all 500ms ease-in-out
}
a:hover {
  color: #456ad9;
  text-decoration: none
}

button{transition: all 0.3s;
  transition: all 500ms ease-in-out}

img {
  max-width: 100%
}

</style>    

<body>
<div style="max-width: 808px; width: 100%; margin:35px auto 35px auto; border-radius: 50px; box-shadow: 0 0px 12px 2px #c6c5c5;">
<div style="border-radius: 50px 50px 0 0; background: #1a3b89; padding: 18px 15px; text-align: center;">
	<img src="{{ url('public/images/logo.png') }}" alt=""/> </div>
	
<div style="border-radius:0; background: #fff; padding:48px 15px; text-align: left; min-height: 450px; border-radius:0 0 50px 50px;">
	<h2 style="font-weight: 300; color: #344161; font-size: 22px; margin-bottom: 35px;">Hello User,</h2>
	<p style="font-size: 19px; margin-bottom: 35px; font-weight: 700;"><strong>A request has been received to change the password for your Customer Portal account.</strong></p>
	
	
	<p style="font-size: 19px; margin-bottom: 35px; text-align: center;"><a href="{{$link}}" style="background: #1a3b89; border-radius: 7px; color: #fff; padding: 15px 35px; display: inline-block;">Reset Password</a></p>
	
	<p style="font-size: 19px; margin-bottom: 35px;">If you did not initiate this request, please contact your nearest Benfed branch.
		.</p>
	
	<p style="font-size: 19px; margin-bottom: 35px;">Thank you,<br>
     Benfed Team</p>
</div>
</div>
	
	

</body>
</html>