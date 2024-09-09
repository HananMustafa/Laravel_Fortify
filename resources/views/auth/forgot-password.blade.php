<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class= "formbg">
    <h1>Forgot Password</h1>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="field">
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" required autofocus>
        </div>
        
        @error('email')
            <span class="text-red-600">{{ $message }}</span>
        @enderror

        <button type="submit" class="btn-submit">Send Password Reset Link</button>
    </form>
    </div>
</body>
</html>
