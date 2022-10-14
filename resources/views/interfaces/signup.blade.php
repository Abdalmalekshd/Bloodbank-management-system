<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

<head>
    <title>Signup</title>
    <link rel="stylesheet" href="{{ asset('sign.css') }}">
</head>

<body>


    <div class="white">
        <form method="POST" action="{{ route('signup') }}">
            @csrf
            <img class="r" src=../s/r.png>
            <p id=login><b>Sign up</b></p>

            <p class="a">Name</p>
            <input type="text" name="name" placeholder="Enter your fullname">
            @error('name')
                <span class="form-text danger-text">
                    {{ $message }}
                </span>
            @enderror

            <p class="a">Email</p>
            <input type="text" name="email" placeholder="Enter your email">


            @error('email')
                <span class="form-text danger-text">{{ $message }}</span>
            @enderror
            <p class="a">Password</p>
            <input type="password" name="password" placeholder="Enter your password">

            @error('password')
                <span class="form-text danger-text">

                    {{ $message }}

                </span>
            @enderror


            <input type="submit" value="Sign Up">

            {{-- <a href="{{ route('login') }}" value="Login Up" class="btn btn-danger"> --}}

        </form>

    </div>

    <div class="red">


        <img class="w" src=../s/w.png>
        <P><b> Welcome To<br> The Blood Bank </b></P>
        <img src=../s/bloood.jpg>

    </div>




</body>

</html>
