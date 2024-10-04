<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    {{-- <div class= "formbg">
    <h1>Login</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        @error('email')
        <span class="error"> {{$message}} </span>
        @enderror

        <div class="field">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        @error('password')
        <span class="error"> {{$message}} </span>
        @enderror

        <div class="field">
            <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>





        <div>
            <button type="submit" class="btn-submit">Login</button>
        </div>
    </form>
    </div> --}}


    <div class="container">
        <div class="left">
          <div class="header">
            <h2 class="animation a1">Login</h2>
            <h4 class="animation a2">Log in to your account using email and password</h4>
          </div>
          <div class="form">
            <input type="email" class="form-field animation a3" placeholder="Email Address">
            <input type="password" class="form-field animation a4" placeholder="Password">
            <p class="animation a5"><a href="#">Forgot Password</a></p>
            <button class="animation a6">LOGIN</button>
          </div>
        </div>
        {{-- <div class="right"></div> --}}
      </div>
      

</body>
</html>
