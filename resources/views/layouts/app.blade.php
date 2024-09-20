<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your App</title>
    
    <!-- Add DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    
    <!-- Add jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>





    <style>
        /* General Styles */
        body {
            background-color: #ffffff;
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica Neue, Ubuntu, sans-serif;
            color: #1a1f36;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        /* Top-right buttons */
        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .top-right a, .top-right button {
            margin: 5px;
        }

        /* Centered content */
        .center-content {
            text-align: center;
        }

        .table {
            margin: 20px auto;
        }

        .margin-top {
        margin-top: 20px; /* Adjust the value as needed */
        }

        .margin-left {
            margin-left: 20px;
        }

        .dmargin-top {
            margin-top: 40px;
        }




    </style>


</head>

<body>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
