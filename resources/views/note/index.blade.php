@extends('layouts.app')

@section('content')
<div class="center-content">
    <h1>Notes for {{ $client->name }}</h1>

    <form action="{{ route('notes.store', $client->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Add Note:</label>
            <textarea class="form-control" name="content" required></textarea>
        </div>
        <button type="submit" class="button">Add Note</button>
    </form>

    <hr>

    <h2>Existing Notes</h2>
    <ul>
        @if($notes && $notes->count() > 0)
            @foreach($notes as $note)
                <li>
                    {{ $note->content }}
                    <a href="{{ route('notes.edit', [$client->id, $note->id]) }}">Edit</a>
                    <form action="{{ route('notes.destroy', [$client->id, $note->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </li>
            @endforeach
        @else
            <li>No notes available for this client.</li>
        @endif
    </ul>






    <!-- Back Button -->
    <div class="mt-3">
        <a href="{{ url('/home') }}" class="btn btn-secondary">Back to Home</a>
    </div>
</div>
@endsection
