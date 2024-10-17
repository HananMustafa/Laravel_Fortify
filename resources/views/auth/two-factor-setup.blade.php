@extends('layouts.app')

@section('content')
    <style>
        /* Card Styles */
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            /* max-width: 800px; */
            margin: 50px auto;
        }

        /* Section Heading */
        .card h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        /* Section Lines */
        .section-line {
            border-bottom: 1px solid #ddd;
            margin: 20px 0;
        }

        /* Button Styles */
        .button {
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #218838;
        }

        /* Disable Button */
        .button-disable {
            background-color: #dc3545;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }

        .button-disable:hover {
            background-color: #c82333;
        }

        /* Flex for left-right alignment */
        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* QR code and recovery codes */
        .qr-code {
            margin-top: 20px;
            text-align: center;
        }

        .recovery-codes ul {
            list-style-type: none;
            padding: 0;
        }

        .recovery-codes li {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
    </style>

    @if(session('success'))
    <script>
        swal({
            title: "Success!",
            text: "{{ session('success') }}", // Use the session message
            icon: "success",
            button: "OK",
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        swal({
            title: "Failed!",
            text: "{{ session('error') }}", // Use the session message
            icon: "error",
            button: "OK",
        });
    </script>
    @endif

    <div class="row">
        <div class="col-12">
    <!-- Two Factor Setup Page -->
    <div class="card">
        <!-- Section Title -->
        <div class="flex-container">
            <h1>Security</h1>
        </div>

        <div class="section-line"></div>
        <div class="flex-container">
            <div><strong>Connect with Linkedin</strong></div>
            <button type="submit" onclick="window.location='{{ route("linkedin.redirect") }}'" class="button">Connect</button>
        </div>


        <div class="section-line"></div>

        <!-- Enable/Disable 2FA Section -->
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            @csrf

            <!-- If 2FA is not enabled -->
            @if (!auth()->user()->two_factor_secret)
                <div class="flex-container">
                    <div><strong>You have not enabled 2FA</strong></div>
                    <button type="submit" class="button">Enable</button>
                </div>

            @else
                <!-- If 2FA is enabled -->
                <div class="flex-container">
                    <div><strong>You have 2FA enabled</strong></div>
                    <button type="submit" class="button-disable">Disable</button>
                </div>

                <div class="qr-code">
                    <h5>Scan this QR code with your authenticator app</h5>
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                </div>

                <div class="recovery-codes">
                    <h3>Recovery Codes</h3>
                    <ul>
                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes, true)) as $code)
                            <li>{{ $code }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Include DELETE method for disabling 2FA -->
                @method('DELETE')
            @endif
        </form>
    </div>

        </div></div>
@endsection
