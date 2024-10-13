<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">

    <style>


        body {
            text-align: center !important;
            padding-top: 2rem !important;
        }
    </style>
</head>

<body>



    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="container">
            <div class="left">
                <div class="header">
                    <h2 class="animation a1">Register</h2>
                    <h4 class="animation a2">Create a new account by giving following details</h4>
                </div>

                <div class="form">

                    <input type="text" id="name" name="name" required class="form-field animation a3"
                        placeholder="Name">

                    <input type="email" id="email" name="email" required class="form-field animation a3"
                        placeholder="Email Address">
                    @error('email')
                        <span class="error"> {{ $message }} </span>
                    @enderror

                    <input type="password" id="password" name="password" required class="form-field animation a4"
                        placeholder="Password">
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="form-field animation a4" placeholder="Confirm Password">
                    @error('password')
                        <span class="error"> {{ $message }} </span>
                    @enderror

                    <button class="animation a6">Signup</button>
                    
                    <button type="button" class="login-with-google-btn" onclick="window.location='{{ route("linkedin.redirect") }}'">Sign in with LinkedIn</button>
  
                </div>
            </div>
            <div type="submit" class="right"></div>
        </div>
    </form>

   

</body>

</html>
