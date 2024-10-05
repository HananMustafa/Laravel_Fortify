<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your App</title>

    <!-- Add DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add Sidebar CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!-- Add jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <style>
      /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4; /* Light background color */
}

/* Top Right Section */
.top-right {
    display: flex;
    justify-content: flex-end;
    padding: 20px;
}

/* Center Content */
.center-content {
    max-width: 800px; /* Set a max width for better layout */
    margin: 40px auto; /* Center align */
    padding: 20px;
    background-color: #fff; /* White background for content */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

/* Headings */
h1 {
    color: rgb(0, 177, 68); /* Title color */
    text-align: center;
}

/* Button Styles */
.button {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px 0;
    background-color: rgb(0, 177, 68); /* Default button color */
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 5px; /* Rounded button corners */
    cursor: pointer;
    transition: background-color 0.3s ease; /* Smooth transition for hover */
}

.button:hover {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px 0;
    background-color: rgb(0, 102, 39); /* Button hover color */
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 5px; /* Rounded button corners */
    cursor: pointer;
    transition: background-color 0.3s ease; /* Smooth transition for hover */
    
}

/* Table Styles */
.table {
    width: 100%;
    border-collapse: collapse; /* Remove space between borders */
    margin-top: 20px; /* Space above the table */
}

.table-bordered {
    border: 1px solid #ddd; /* Table border */
}

.table th, .table td {
    border: 1px solid #ddd; /* Cell border */
    padding: 12px; /* Cell padding */
    text-align: left; /* Align text to the left */
}

.table th {
    /* background-color: rgb(75, 235, 136); 
    color: white;  */
}

/* Button Styles for Actions */
.btn {
    padding: 6px 12px; /* Action button padding */
    border-radius: 4px; /* Rounded corners for action buttons */
    color: white;
}

.btn-secondary {
    background-color: rgb(60, 60, 60); /* Gray for Notes button */
}

.btn-secondary:hover {
    background-color: rgb(40, 40, 40); /* Darker gray on hover */
}

.btn-primary {
    background-color: rgb(0, 123, 255); /* Blue for Update button */
}

.btn-primary:hover {
    background-color: rgb(0, 95, 204); /* Darker blue on hover */
}

.btn-danger {
    background-color: rgb(220, 53, 69); /* Red for Delete button */
}

.btn-danger:hover {
    background-color: rgb(185, 43, 58); /* Darker red on hover */
}




    </style>


</head>


<body>
    <div class="d-flex">
        <!-- Include Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="container-fluid" style="margin-left: 250px; transition: margin-left 0.3s;">
            @yield('content')
        </div>
    </div>
</body>

</html>
