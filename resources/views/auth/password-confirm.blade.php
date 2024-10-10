<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .back-btn {
            margin-top: 20px;
            text-align: center;
        }

        /* Button Styles */
        .button {
            display: flex;
            flex-direction: column;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: rgb(0, 177, 68);
            /* Default button color */
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            /* Rounded button corners */
            cursor: pointer;
            transition: background-color 0.3s ease;
            /* Smooth transition for hover */
        }

        .button:hover {
            display: flex;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: rgb(0, 102, 39);
            /* Button hover color */
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            /* Rounded button corners */
            cursor: pointer;
            transition: background-color 0.3s ease;
            /* Smooth transition for hover */

        }





        * {
            box-sizing: border-box;
        }

        @import url('https://fonts.googleapis.com/css?family=Rubik:400,500&display=swap');


        body {
            font-family: 'Rubik', sans-serif;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .left {
            flex-basis: 40%;
            /* overflow: hidden; */
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            animation-name: left;
            animation-duration: 1s;
            animation-fill-mode: both;
            animation-delay: 1s;
        }

        .right {
            flex-basis: 60%;
            /* flex: 1; */
            background-color: black;
            transition: 1s;
            /* background-image: url(https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2250&q=80); */
            background-image: url("../images/NerdFlow.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }


        .centered {
            flex-direction: column;
        }

        .header {
            text-align: center;
        }

        .header>h2 {
            margin: 0;
            color: #165e00;
        }

        .header>h4 {
            margin-top: 10px;
            font-weight: normal;
            font-size: 15px;
            color: rgba(0, 0, 0, .4);
        }

        .form {
            width: 40%;
            max-width: 50%;
            /*fields/button Can aquire 50% width maximum, but in normal case, they are aquiring width which is 40%*/
            display: flex;
            flex-direction: column;
            /* text-align: center; */
        }

        .Section-Form {
            width: 40%;
            max-width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            /* Centers the entire form horizontally */
        }




        /* USING MEDIA QUERIES FOR RESPONSIVENESS OF FORM IN SMALLER SCREENS */
        @media (max-width: 1200px) {
            .form {
                width: 70%;
                /* Increase width for smaller screens */
                max-width: 80%;
            }
        }

        @media (max-width: 768px) {
            .form {
                width: 90%;
                /* Make it even wider for smaller screens */
            }
        }

        .form>p {
            text-align: right;
        }

        .form>p>a {
            color: #000;
            font-size: 14px;
        }

        .form-field {
            width: 100%;
            height: 46px;
            padding: 0 16px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-family: 'Rubik', sans-serif;
            outline: 0;
            transition: .2s;
            margin-top: 20px;
        }

        .form-field:focus {
            border-color: #30c404;
        }

        .form>button {
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


        .form>button:hover {
            background-color: rgb(0, 102, 39);
        }

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="container">
            <div class="left">
                <div class="header">
                    <h2 class="animation a1">Confirm Password</h2>
                    <h4 class="animation a2">Confirm your authenticity using password</h4>
                </div>
                <div class="form">
                    <input type="password" id="password" name="password" required class="form-field animation a4"
                        placeholder="Password">
                    @error('password')
                        <span class="error"> {{ $message }} </span>
                    @enderror


                    {{-- <div class="field">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div> --}}
                    <button class="animation a6">Confirm</button>

                    <div class="back-btn">
                        <a href="{{ route('two-factor-setup') }}" class="button">Back</a>
                    </div>

                </div>
            </div>

            <div type="submit" class="right"></div>
        </div>

    </form>

</body>

</html>
