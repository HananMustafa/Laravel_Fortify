<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class= "formbg">
        <h1>Confirm Password</h1>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="field">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="field">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>

            @error('password')
                <span class="error"> {{ $message }} </span>
            @enderror

            <div>
                <button type="submit" class="btn-submit">Login</button>
            </div>
        </form>
    </div>

</body>

</html>
