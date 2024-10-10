<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        .container {
            text-align: center;
            margin-top: 100px;
        }

        .button {
            padding: 12px 10px;
            border: 0;
            background: rgb(0, 177, 68);
            border-radius: 3px;
            margin-top: 10px;
            color: #fff;
            letter-spacing: 1px;
            font-family: 'Rubik', sans-serif;
            cursor: pointer;
            margin-left: 10px;
            margin-right: 10px;
        }

        .button:hover {
            background-color: rgb(0, 102, 39);
        }
    </style>
</head>



<body>
    <div class="container">

        <h1>Welcome to the Application</h1>

        <a href="{{ route('register') }}">
            <button class="button">Sign Up</button>
        </a>
        <a href="{{ route('login') }}">
            <button class="button">Login</button>
        </a>
        
</body>

</html>
