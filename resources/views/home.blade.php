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
    </style>
</head>



<body>
    <div class="container">
    <h1>Welcome to Home</h1>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="button">Logout</button>
    </form>
    </div>
</body>
</html>
