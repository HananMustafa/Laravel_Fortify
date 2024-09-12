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
        <h1>Enter 2FA Code</h1>

        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div class="field">
                <label for="code">Code:</label>
                <input type="code" id="code" name="code" required>
            </div>

            @error('code')
            <span class="error"> {{ $message }} </span>
            @enderror

            <div>
                <button type="submit" class="btn-submit">Submit</button>
            </div>

        </form>
    </div>


    <div class="margin-left">
    <div class= "formbg">
        <h1>Enter 2FA Recovvery code</h1>

        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div class="field">
                <label for="recovery_code">Recovery Code:</label>
                <input type="recovery_code" id="recovery_code" name="recovery_code" required>
            </div>

            @error('recovery_code')
            <span class="error"> {{ $message }} </span>
            @enderror

            <div>
                <button type="submit" class="btn-submit">Submit</button>
            </div>

        </form>
    </div>
    </div>

</body>

</html>
