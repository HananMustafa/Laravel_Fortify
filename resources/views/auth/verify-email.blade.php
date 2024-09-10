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
        <h1>You must verify your email address, please check your email for a verification link.</h1>

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
