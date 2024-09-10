<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class= "formbg">
    <h1>Login</h1>

    <!-- Display any validation errors -->
    {{-- @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="field">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="field">
            <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>

        @error('password')
        <span class="error"> {{$message}} </span>
        @enderror

        @error('email')
        <span class="error"> {{$message}} </span>
        @enderror

        {{-- @if ($errors->has('throttle'))
        <span class="error">Too many login attempts. Please try again later.</span>
        @endif --}}

        <div>
            <button type="submit" class="btn-submit">Login</button>
        </div>
    </form>

    </div>
</body>
</html>
