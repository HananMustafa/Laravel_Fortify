<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

h2 {
    margin-bottom: 24px;
    color: #1a1f36;
    font-size: 24px;
    text-align: center;
}

.formbg {
    width: 100%;
    max-width: 448px;
    padding: 48px;
    background: #ffffff;
    border-radius: 4px;
    box-shadow: rgba(60, 66, 87, 0.12) 0px 7px 14px 0px, rgba(0, 0, 0, 0.12) 0px 3px 6px 0px;
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
</style>
<body>

    <div class= "formbg">
        <h2>You must verify your email address, please check your email for a verification link.</h2>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf


            <div>
                <button type="submit" class="btn-submit" value="Resend email">Resend email</button>
            </div>
        </form>

    </div>
</body>

</html>
