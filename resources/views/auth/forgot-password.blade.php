<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    {{-- <div class= "formbg">
    <h1>Forgot Password</h1> --}}



    <form method="POST" action="{{ route('password.email') }}">
        @csrf


        <div class="container">
            <div class="left">
              <div class="header">
                <h2 class="animation a1">Forgot Password</h2>
                <h4 class="animation a2">Reset your account password using email</h4>
              </div>
              <div class="form">
                <input type="email" id="email" name="email" required class="form-field animation a3" placeholder="Email Address">
                @error('email')
                <span class="error"> {{$message}} </span>
                @enderror

                @if (session('status'))
                
                    <h5 style="margin-top: 5px;">{{ session('status') }}</h5>
            @endif
  
                <button class="animation a6">Reset Password</button>
              </div>
            </div>
            <div type="submit" class="right"></div>
          </div>


</body>
</html>
