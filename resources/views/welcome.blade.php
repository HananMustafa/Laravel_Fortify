<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Rubik', sans-serif;
        }

        body {
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .cards {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .card {
            padding: 15px;
            border-radius: 8px;
            background: linear-gradient(135deg, #00b144, #00852d);
            color: white;
            text-align: center;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 177, 68, 0.2);
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to the Application</h1>
        <div class="cards">
            <a href="{{ route('register') }}">
                <div class="card">Sign Up</div>
            </a>
            <a href="{{ route('login') }}">
                <div class="card">Login</div>
            </a>
        </div>
    </div>
</body>
</html>
