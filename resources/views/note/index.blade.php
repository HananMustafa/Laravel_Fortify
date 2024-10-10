{{-- @extends('layouts.app')

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
        @if ($notes && $notes->count() > 0)
            @foreach ($notes as $note)
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
@endsection --}}




@extends('layouts.app')

@section('content')
    <style>
        .top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .left-search {
            text-align: left;
            margin-top: 15px;
        }

        .right-button {
            text-align: right;
        }

        .bottom {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .bottom-left {
            flex: 1;
            text-align: left;
            margin-top: 23px;
        }

        .bottom-center {
            flex: 1;
            text-align: center;
            margin: 12px;
        }

        .bottom-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
            margin-top: 13px;
        }

        .dataTables_info {
            text-align: right;
            margin-bottom: 5px;
        }

        .dt-buttons .button {
            width: 100% !important;
            padding: 12px 10px !important;
            border: 0 !important;
            background: rgb(0, 177, 68) !important;
            border-radius: 3px !important;
            margin-top: 10px !important;
            color: #fff !important;
            letter-spacing: 1px !important;
            font-family: 'Rubik', sans-serif !important;
            cursor: pointer !important;
        }

        .dt-buttons .button:hover {
            background-color: rgb(0, 102, 39) !important;
        }

        .dataTables_paginate .paginate_button {
            padding: 12px 10px !important;
            border: 2px solid rgb(0, 102, 39) !important;
            background: rgb(255, 255, 255) !important;
            border-radius: 3px !important;
            margin-top: 10px !important;
            color: #000000 !important;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: rgb(0, 102, 39) !important;
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background-color: rgb(0, 102, 39) !important;
            color: #fff !important;
        }

        .bottom-right .dataTables_paginate {
            display: inline-block !important;
            text-align: right !important;
            float: right !important;
        }


        /* Style for the button */
        .btn-secondary {
            background-color: #cdd0d3;
            /* Bootstrap secondary color */
            border: none;
            /* Remove default border */
            color: white;
            /* Text color */
        }

        .btn-secondary:hover {
            background-color: #a4a8ac;
            /* Bootstrap secondary color */
            border: none;
            /* Remove default border */
            color: white;
            /* Text color */
        }

        /* Icon styles */
        .d-flex.align-items-center img {
            width: 20px;
            /* Icon width */
            height: 20px;
            /* Icon height */
            margin-right: 5px;
            /* Spacing between icon and text */
        }

        /* Dropdown menu */
        .dropdown-menu {
            background-color: #ffffff;
            /* White background for dropdown */
            border: 1px solid #ced4da;
            /* Border color for dropdown */
            border-radius: 5px;
            /* Optional: round corners */
        }

        /* Dropdown item styles */
        .dropdown-item {
            color: #333;
            /* Darker text color */
        }

        /* Change hover effect for dropdown items */
        .dropdown-item:hover {
            background-color: #e9ecef;
            /* Light grey on hover */
            color: #212529;
            /* Darker text on hover */
        }

        /* Ensure button and dropdown icon align properly */
        .dropdown-toggle img {
            margin: 0;
            /* Reset margin for dropdown icon */
        }
    </style>

    <div class="welcome-home">
        <h1>Notes for {{ $client->name }}</h1>
    </div>

    <div class="center-content">
        <div>
            <form action="{{ route('notes.store', $client->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="content">Add Note:</label>
                    <textarea class="form-control" name="content" required></textarea>
                </div>
                <button type="submit" class="button">Add Note</button>
            </form>
        </div>

        <div class="mt-4">
            <table class="table table-bordered" id="notes-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Content</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#notes-table').DataTable({
                serverSide: true,
                ajax: '{{ route('notes.data', $client->id) }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'content',
                        name: 'content'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                    @foreach ($notes as $note)
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $note->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{ asset('images/menu.svg') }}" alt="Actions" style="width: 20px; height: 20px;">
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $note->id }}">
                                                    <!-- Edit Link -->
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('notes.edit', [$client->id, $note->id]) }}">Edit</a>
                                                    </li>
                                                    <!-- Delete Form -->
                                                    <li>
                                                        <form action="{{ route('notes.destroy', [$client->id, $note->id]) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item delete-note" data-id="{{ $note->id }}">Delete</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        @endforeach
                            `;
                        }
                    }
                ],
                dom: '<"top"<"left-search"f><"right-button"B>>t<"bottom"<"bottom-left"l><"bottom-right"ip>>',
                language: {
                    search: "Search: ",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    }
                },
                buttons: [{
                    text: 'Add Note',
                    className: 'button',
                    action: function(e, dt, node, config) {
                        $('html, body').animate({
                            scrollTop: 0
                        }, 'slow');
                    }
                }],
                pagingType: 'numbers',
            });

            // Delete note functionality
            $(document).on('click', '.delete-note', function() {
                var id = $(this).data('id');
                if (confirm("Are you sure to delete this note?")) {
                    $.ajax({
                        url: '{{ url('/notes/delete') }}/' + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            $('#notes-table').DataTable().ajax.reload();
                            alert(response.success);
                        }
                    });
                }
            });
        });
    </script>
@endsection
