<div style="font-family: 'Malgun Gothic'; font-size: 14px; width: 600px;">
    <div style="background:url({{asset('public/assets/images/email/email_header.jpg')}}) no-repeat;background-size:cover !important; height: 60px;">
    </div>
    <img src="{{asset('public/assets/images/logo-dark.png')}}" style="width:100px; float:right; margin-top:10px;">
    <h2 style="margin-bottom: 0px; margin-top:50x;">Hi, {{$full_name}}</h2>
    <h2 style="margin-top: 0px; margin-bottom: 30px;">Welcome to Polymesa</h2>

    <h3 style="color:black; margin-bottom: 0px;">Reset Password.</h3>
    <p style="color:black; margin-bottom: 0px;">You can click link to reset your password.</p>
    <a style="color:red; margin:0px;" href="{{$reset_url}}">{{$reset_url}}</a>

    <p style="color:black; margin-bottom: 0px;">If it is not you who requested reset password, you should ignore this email.</p>

</div>