<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>




    




    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="container">
          <div class="left">
            <div class="header">
              <h2 class="animation a1">Welcome Back</h2>
              <h4 class="animation a2">Log in to your account using email and password</h4>
            </div>
            <div class="form">
              <input type="email" id="email" name="email" required class="form-field animation a3" placeholder="Email Address">
              @error('email')
              <span class="error"> {{$message}} </span>
              @enderror

              <input type="password" id="password" name="password" required class="form-field animation a4" placeholder="Password">
              @error('password')
              <span class="error"> {{$message}} </span>
              @enderror

              <p class="animation a5"><a href="{{ route('password.request') }}">Forgot Password?</a></p>
              <button class="animation a6">LOGIN</button>
            </div>
          </div>
          <div type="submit" class="right"></div>
        </div>
    </form>


</body>
</html>
