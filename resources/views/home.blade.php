<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
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

        .container {
            text-align: center;
            margin-top: 100px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .margin-top {
            margin-top: 20px;
        }

        .dmargin-top {
            margin-top: 40px;
        }
    </style>
</head>



<body>
    <div class="container">
        <h1>Welcome to Home</h1>

        <div class="formbg">
            <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                @csrf

                @if (!auth()->user()->two_factor_secret)
                    <div>
                        You have not enabled 2FA
                    </div>

                    <button type="submit" class="button">Enable </button>
                @else
                    <div>
                        <h2>You have 2FA enabled</h2>
                    </div>

                    <div>
                        Scan the following QR code into your phones authenticator application.
                    </div>

                    <div class="margin-top">
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>

                    <div class="dmargin-top">
                        <h3> Recovery codes </h3>
                        <div class="margin-top">
                            <ul>
                                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes, true)) as $code)
                                    <li> {{ $code }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @method('DELETE')
                    <div class="margin-top">
                        <button type="submit" class="button"> Disable </button>
                    </div>
                @endif
            </form>
        </div>



        <div class="dmargin-top">
            <div class="formbg">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="button">Logout</button>
                </form>
            </div>
        </div>
</body>

</html>
