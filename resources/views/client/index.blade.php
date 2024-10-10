@extends('layouts.app')

@section('content')
<style>
    .top {
        display:flex;
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
        display:flex;
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
    /* Style for bottom-right to stack the i and p elements */
.bottom-right {
    display: flex;
    flex-direction: column; /* Stack i and p vertically */
    align-items:flex-end;  /* Align to the right */
    gap: 10px;              /* Add space between i and p */
    margin-top: 13px;
}

.dataTables_info {
    text-align: right;  /* Ensure the info text aligns to the right */
    margin-bottom: 5px; /* Add margin to separate from pagination */
}


    /* Ensure DataTable buttons use your styles */
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





    /* Pagination button styles matching your project */
.dataTables_paginate .paginate_button {
    width: auto !important; /* Adjust for auto width */
    padding: 12px 10px !important;
    border: 2px solid rgb(0, 102, 39) !important;
    background: rgb(255, 255, 255) !important;
    border-radius: 3px !important;
    margin-top: 10px !important;
    color: #000000 !important;
    letter-spacing: 1px !important;
    font-family: 'Rubik', sans-serif !important;
    cursor: pointer !important;
    text-align: center;
}

/* Hover effect for pagination buttons */
.dataTables_paginate .paginate_button:hover {
    background-color: rgb(0, 102, 39) !important;
    color: #fff !important;
}


.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background-color: rgb(0, 102, 39) !important;
    color: #fff !important;
}


/* Style the container for pagination alignment */
.bottom-right .dataTables_paginate {
    display: inline-block !important;
    text-align: right !important;
    float: right !important;
}




.d-flex.align-items-center {
    justify-content:center;
    gap: 10px;

}



/* Style for the button */
.btn-secondary {
    background-color: #cdd0d3; /* Bootstrap secondary color */
    border: none; /* Remove default border */
    color: white; /* Text color */
}
.btn-secondary:hover {
    background-color: #a4a8ac; /* Bootstrap secondary color */
    border: none; /* Remove default border */
    color: white; /* Text color */
}

/* Icon styles */
.d-flex.align-items-center img {
    width: 20px; /* Icon width */
    height: 20px; /* Icon height */
    margin-right: 5px; /* Spacing between icon and text */
}

/* Dropdown menu */
.dropdown-menu {
    background-color: #ffffff; /* White background for dropdown */
    border: 1px solid #ced4da; /* Border color for dropdown */
    border-radius: 5px; /* Optional: round corners */
}

/* Dropdown item styles */
.dropdown-item {
    color: #333; /* Darker text color */
}

/* Change hover effect for dropdown items */
.dropdown-item:hover {
    background-color: #e9ecef; /* Light grey on hover */
    color: #212529; /* Darker text on hover */
}

/* Ensure button and dropdown icon align properly */
.dropdown-toggle img {
    margin: 0; /* Reset margin for dropdown icon */
}



</style>
<div class="welcome-home">
    <h1>Welcome to Home</h1>
</div>
<div class="center-content">
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

<!-- Modal for Adding Client -->
@include('client.modal.add') <!-- Include the add modal -->

<script>
    $(document).ready(function() {
        // Initialize DataTable
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
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton${row.id}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('images/menu.svg') }}" alt="Actions" style="width: 20px; height: 20px;">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                                    <li><a class="dropdown-item" href="/client/${row.id}/notes">Notes</a></li>
                                    <li><a class="dropdown-item update-client" data-id="${row.id}" href="#">Update</a></li>
                                    <li><a class="dropdown-item delete-client" data-id="${row.id}" href="#">Delete</a></li>
                                </ul>
                            </div>
                        </div>`;
                    }
                }
            ],
            dom: '<"top"<"left-search"f><"right-button"B>>t<"bottom"<"bottom-left"l><"bottom-right"ip>>',
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            },
            buttons: [
                {
                    text: 'Add Client',
                    className: 'button',
                    action: function() {
                        $('#addClientModal').modal('show'); // Show the modal
                    }
                }
            ],
            pagingType: 'numbers',
        });

        // Show Update Modal with Client Data
        $(document).on('click', '.update-client', function() {
            var clientId = $(this).data('id');

            // Make an AJAX call to fetch client data
            $.ajax({
                url: `/client/edit/${clientId}`,
                method: 'GET',
                success: function(response) {
                    // Populate modal fields with client data
                    $('#updateModal').find('input[name="name"]').val(response.client.name);
                    $('#updateModal').find('input[name="email"]').val(response.client.email);
                    $('#updateModal').find('form').attr('action', `/client/update/${clientId}`);

                    // Show the modal
                    $('#updateModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch client data.');
                }
            });
        });

        // Delete client functionality
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

        // Handle form submission for adding a client
        $('#addClientForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            $.ajax({
                url: '{{ route("client.store") }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addClientModal').modal('hide'); // Hide the modal
                    $('#clients-table').DataTable().ajax.reload(); // Reload the DataTable
                    alert('Client added successfully.');
                },
                error: function(xhr) {
                    alert('Error adding client: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection