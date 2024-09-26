@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Note</h1>

    <form action="{{ route('notes.update', [$note->client_id, $note->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="content">Note</label>
            <textarea class="form-control" name="content" required>{{ $note->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Note</button>
    </form>
</div>
@endsection
