@extends('layouts.app')


@section('content')

    <form action="{{ route('notes.update', [$note->client_id, $note->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="center-content">
            <div class="header">
                <h2 class="animation a1">Update Note</h2>
                <h4 class="animation a2">Provide necessary details</h4>
              </div>

              <div class="Section-Form">
                {{-- <input type="text" name="name" required class="" placeholder="Name" > --}}
                <textarea class="form-field animation a3" name="content" required placeholder="Enter Note"
                style="height:200px; width:500px;">
                {{ $note->content }}</textarea>

                <button type="submit" class="button">Update Note</button>
              </div>
        </div>

        {{-- <div class="form-group">
            <label for="content">Note</label>
            <textarea class="form-control" name="content" required>{{ $note->content }}</textarea>
        </div> --}}
    </form>
</div>
@endsection
