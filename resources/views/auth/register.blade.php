<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


    <div class= "formbg">
    <h1>Register</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="field">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="field">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        @error('password')
            {{$message}}
        @enderror

        <div class="field">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div>
            <button type="submit" class="btn-submit">Register</button>
        </div>
    </form>

    </div>
</body>
</html>
