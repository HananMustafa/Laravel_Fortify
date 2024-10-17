@extends('layouts.app')

@section('content')

<style>
.full-image{
    width: 100%;
    height: 100%;
    object-fit:cover;
}
</style>

   
    <div class="welcome-home">
        <h1>Welcome to Home</h1>

        <img src="{{ asset('images/dashboardpic.jpg') }}" alt="Nerd Flow" class="full-image">
    </div>

  
@endsection
