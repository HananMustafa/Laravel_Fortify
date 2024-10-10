@extends('layouts.app')

@section('content')

        <form action="{{ route('client.update', $client->id) }}" method="POST">
            @csrf
            <div class="center-content">
                <div class="header">
                    <h2 class="animation a1">Update Client</h2>
                    <h4 class="animation a2">Provide necessary details</h4>
                  </div>

                  <div class="Section-Form">
                    <input type="text" name="name" required class="form-field animation a3" placeholder="Name" value="{{ $client->name }}">
                    <input type="email" id="email" name="email" required class="form-field animation a3" placeholder="Email Address" value="{{ $client->email }}">
                    <button type="submit" class="button">Update Client</button>
                  </div>
            </div>
        </form>
        
@endsection
