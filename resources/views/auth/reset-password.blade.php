<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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

    .button {
        width: 100%;
        padding: 12px 10px;
        border: 0;
        background: rgb(0, 177, 68);
        border-radius: 3px;
        margin-top: 10px;
        color: #fff;
        letter-spacing: 1px;
        font-family: 'Rubik', sans-serif;
        cursor: pointer;
    }


    .button:hover {
        background-color: rgb(0, 102, 39);
    }

    .error {
        color: red;
    }
</style>

<body>

    <div class= "formbg">
        <h1>Reset Password</h1>

        <form method="POST" action="{{ url('/reset-password') }}">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ request()->input('email') }}" required
                    autofocus>
            </div>

            <!-- Password -->
            <div class="field">
                <label for="password">New Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <!-- Confirm Password -->
            <div class="field">
                <label for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror

            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror

            <!-- Submit Button -->
            <div>
                <button type="submit" class="button">
                    Reset Password
                </button>
            </div>
        </form>
    </div>


</body>

</html>
