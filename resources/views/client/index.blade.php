@extends('layouts.app')

@section('content')

    {{-- <div class="top-right">
        <div class="margin-top">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="btn-submit">
                    <button type="submit" class="button">Logout</button>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="center-content">
        <h1>Welcome to Home</h1>

        <div>
            <a href="{{ route('client.add') }}" class="button">Add Client</a>
        </div>

        <div>
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
                serverSide: true,
                ajax: '{{ route('clients.data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
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
