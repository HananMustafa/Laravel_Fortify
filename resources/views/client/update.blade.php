@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Update Client</h1>

        <form action="{{ route('client.update', $client->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Client Name</label>
                <input type="text" class="form-control" name="name" value="{{ $client->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Client Email</label>
                <input type="email" class="form-control" name="email" value="{{ $client->email }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Client</button>
        </form>
    </div>
@endsection
