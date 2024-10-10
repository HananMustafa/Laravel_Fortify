@extends('layouts.app')

@section('content')
    <style>
     .center-content{
        text-align: center;
     }

     .margin-top-40{
        margin-top: 40px;
     }
     .margin-top-20{
        margin-top: 20px;
     }


     .welcome-home {
    margin-top: 40px; 
}

    </style>
<div class="welcome-home">
    <h1>Two Factor Setup</h1>
</div>
    <div class="center-content">
        


            <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                @csrf

                @if (!auth()->user()->two_factor_secret)
                    <div>
                        <h5>You have not enabled 2FA</h5>
                    </div>

                    <button type="submit" class="button">Enable </button>
                @else
                    <div>
                        <h5>You have 2FA enabled</h5>
                    </div>

                    <div class=margin-top-40>
                        Scan the following QR code into your phones authenticator application.
                    </div>

                    <div class="margin-top-20">
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>

                    <div class="margin-top-40">
                        <h3> Recovery codes </h3>
                        <div class="margin-top-20">
                            <ul style="list-style-type: none;">
                                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes, true)) as $code)
                                    <li> {{ $code }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @method('DELETE')
                    <div class="margin-top-40">
                        <button type="submit" class="button"> Disable </button>
                    </div>
                @endif
            </form>



{{-- 
            <div class="back">
            <a href="{{ route('client') }}" class="button">Back</a>
            </div>
        </div> --}}
        
@endsection