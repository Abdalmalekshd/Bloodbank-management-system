<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

<head>
    <title>Login</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="{{ asset('logincss.css') }}">
</head>

<body>



    <div class="white">
        <form method="POST" action="{{ route('bloodbank/login') }}">
            @csrf
            <img class="r" src=../s/r.png>
            <p id=login><b>Login</b></p>
            <p class="a">Email</p>
            <input type="Email" name="Email" placeholder="Enter your email">
            @error('Email')
                <span>{{ $message }}</span>
            @enderror

            <p class="a">Password</p>
            <input type="password" name="Password" placeholder="Enter your password">
            @error('Password')
                <span class="form-text danger-text">{{ $message }}</span>
            @enderror


            <input type="submit" value="Login">
            <a href="{{ 'signup' }}"><input type="button" value="Sign Up"></a>

            @if (Session::has('error'))
                <div id="invalidCheck3Feedback" class="alert alert-danger msg">
                    {{ Session::get('error') }}
                </div>
            @endif

        </form>

    </div>

    <div class="red">
        <img class="w" src=../s/w.png>
        <P><b> Welcome To<br> The Blood Bank </b></P>
        <img src=../s/bloood.jpg>

    </div>



</body>

</html>
