@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Client</h1>

        <form action="{{ route('client.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Client Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Client Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Client</button>
        </form>
    </div>
@endsection
