@extends('layouts.app')

@section('content')

    <div class="top-right">

        <a href="{{ route('two-factor-setup') }}" class="button">Two Factor Setup</a>

        <div class="margin-top">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="button">Logout</button>
            </form>
        </div>
    </div>

    <div class="center-content">

        <h1>Welcome to Home</h1>

        <div class="dmargin-top">
            <a href="{{ route('client.add') }}" class="button">Add Client</a>
        </div>

        <div class="dmargin-top">
            <table class="table table-bordered" id="clients-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#clients-table').DataTable({
                processing: true,
                serverSide: true, //filtering or pagination on server side
                ajax: '{{ route('clients.data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false, //sorting
                        searchable: false, //searching
                        render: function(data, type, row) {
                            return `
                                <a href="/client/${row.id}/notes" class="btn btn-sm btn-secondary">Notes</a>
                                <a href="/client/edit/${row.id}" class="btn btn-sm btn-primary">Update</a>
                                <button type="button" class="btn btn-sm btn-danger delete-client" data-id="${row.id}">Delete</button>
                            `;
                        }
                    }
                ]
            });

            $(document).on('click', '.delete-client', function() {
                var id = $(this).data('id');
                if (confirm("Are you sure to delete this client?")) {
                    $.ajax({
                        url: '{{ url("/client/delete") }}/' + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            $('#clients-table').DataTable().ajax.reload();
                            alert(response.success);
                        }
                    });
                }
            });
        });
    </script>
@endsection
