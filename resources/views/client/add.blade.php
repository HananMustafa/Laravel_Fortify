@extends('layouts.app')

@section('content')
    
    <form action="{{ route('client.store') }}" method="POST">
        @csrf
        <div class="center-content">

              <div class="header">
                <h2 class="animation a1">Add Client</h2>
                <h4 class="animation a2">Provide necessary details</h4>
              </div>

              <div class="Section-Form">
                <input type="text" name="name" required class="form-field animation a3" placeholder="Name">
                <input type="email" id="email" name="email" required class="form-field animation a3" placeholder="Email Address">
                <button type="submit" class="button">Add Client</button>
              </div>
        </div>
    </form>
        
@endsection
