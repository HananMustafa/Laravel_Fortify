<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
    <link rel="stylesheet" href="style.css">



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

h2 {
    margin-bottom: 24px;
    color: #1a1f36;
    font-size: 24px;
    text-align: center;
}

h1 {
    margin-bottom: 24px;
    font-size: 34px;
    
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
    margin-bottom: 10px;
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
    </style>

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
                <button type="submit" class="button">Submit</button>
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
                <button type="submit" class="button">Submit</button>
            </div>

        </form>
    </div>
    </div>

</body>

</html>
