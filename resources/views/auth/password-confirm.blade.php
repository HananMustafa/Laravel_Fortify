<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Ubuntu, sans-serif;
        color: #1a1f36;
    }

    body {
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .formbg {
        width: 100%;
        max-width: 448px;
        padding: 48px;
        background: #ffffff;
        border-radius: 4px;
        box-shadow: rgba(60, 66, 87, 0.12) 0px 7px 14px 0px, rgba(0, 0, 0, 0.12) 0px 3px 6px 0px;
    }

    .field {
        margin-bottom: 24px;
    }

    .field label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 16px;
    }

    .field input {
        width: 100%;
        padding: 8px 16px;
        font-size: 16px;
        line-height: 28px;
        border: 1px solid rgba(60, 66, 87, 0.16);
        border-radius: 4px;
        outline: none;
        background-color: #ffffff;
        box-shadow: rgba(60, 66, 87, 0.16) 0px 0px 0px 1px;
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
        background-color: #5469d4;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
    }

    .btn-submit:hover {
        background-color: #4357ad;
    }

    .error {
        color: red;
    }
</style>
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
