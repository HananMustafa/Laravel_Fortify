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

        /* Style for bottom-right to stack the i and p elements */
        .bottom-right {
            display: flex;
            flex-direction: column;
            /* Stack i and p vertically */
            align-items: flex-end;
            /* Align to the right */
            gap: 10px;
            /* Add space between i and p */
            margin-top: 13px;
        }

        .dataTables_info {
            text-align: right;
            /* Ensure the info text aligns to the right */
            margin-bottom: 5px;
            /* Add margin to separate from pagination */
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
            width: auto !important;
            /* Adjust for auto width */
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
            justify-content: center;
            gap: 10px;

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


    {{-- LOADING SPINNER --}}
    <div id="loading-spinner"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">
        <div style=" padding: 20px; border-radius: 10px;">
            <img src="{{ asset('images/loading.gif') }}" alt="Loading..." width="50">
        </div>
    </div>



    <div class="row">
        <div class="welcome-home">
            <h1>Products</h1>
        </div>

        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Link</th>
                            <th>Media</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal for Adding Product -->
    @include('product.modal.add')
    @include('product.modal.update')
    @if (session('success'))
        <script>
            swal({
                title: "Success!",
                text: "{{ session('success') }}", // Use the session message
                icon: "success",
                button: "OK",
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            swal({
                title: "Failed!",
                text: "{{ session('error') }}", // Use the session message
                icon: "error",
                button: "OK",
            });
        </script>
    @endif


    <script>
        $(document).ready(function() {
            $('#loading-spinner').hide(); // Ensure it's hidden on page load
            // Initialize DataTable
            $('#products-table').DataTable({
                serverSide: true,
                ajax: '{{ route('products.data') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },

                    {
                        data: 'link',
                        name: 'link'
                    },


                    //IMAGE RENDERING
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, row) {
                            var imageHtml = '';
                            if (data) { // Check if the image path is available
                                var baseUrl =
                                    '{{ asset('') }}'; // Outputs the base URL with trailing slash
                                var imagePath = baseUrl + data; // Construct the full image path
                                imageHtml =
                                    `<img src="${imagePath}" alt="${row.title}" style="width:50px; height:auto;">`;
                            }
                            return imageHtml; // Return only if image exists, else return empty string
                        },
                        orderable: false, // Disable ordering on the image column if needed
                        searchable: false // Similarly, disabling search if you don't want to search in image paths
                    },

                    //VIDEO RENDERING
                    // {
                    //     data: 'video',
                    //     name: 'video',
                    //     render: function(data, type, row) {
                    //         var videoHtml = '';

                    //         if (data) { // Check if the video path exists
                    //             var baseUrl = '{{ asset('') }}'; // Base URL
                    //             var videoPath = baseUrl + data; // Construct full video path

                    //             // Generate a video thumbnail using the poster attribute
                    //             videoHtml = `
                    //                 <video width="70" height="50" autoplay muted loop poster="${baseUrl}/thumbnails/${row.video_thumbnail}">
                    //                     <source src="${videoPath}" type="video/mp4">
                    //                     Your browser does not support the video tag.
                    //                 </video>
                    //             `;
                    //         }

                    //         return videoHtml;
                    //     },
                    //     orderable: false,
                    //     searchable: false
                    // },


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
                                    <li><a class="dropdown-item update-product" data-id="${row.id}" href="#">Update</a></li>
                                    <li><a class="dropdown-item delete-product" data-id="${row.id}" href="#" onclick="confirmation(event)">Delete</a></li>
                                </ul>
                            </div>
                            <a class="postOnLinkedin" data-id="${row.id}" href="#">
                                        <img src="{{ asset('images/linkedin.png') }}" alt="Post on LinkedIn" style="width: 34px; height: 34px;">
                                    </a>
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
                buttons: [{
                    text: 'Add Product',
                    className: 'button',
                    action: function() {
                        $('#addProductModal').modal('show'); // Show the modal
                    }
                }],
                pagingType: 'numbers',
            });

            // Show Update Modal with Product Data
            $(document).on('click', '.update-product', function() {
                var productId = $(this).data('id');

                // Make an AJAX call to fetch product data
                $.ajax({
                    url: `/product/edit/${productId}`,
                    method: 'GET',
                    success: function(response) {
                        // Populate modal fields with product data
                        $('#updateModal').find('input[name="title"]').val(response.product
                            .title);
                        $('#updateModal').find('input[name="description"]').val(response.product
                            .description);
                        $('#updateModal').find('input[name="link"]').val(response.product
                            .link);
                        $('#updateModal').find('form').attr('action',
                            `/product/update/${productId}`);

                        // Show the modal
                        $('#updateModal').modal('show');
                    },
                    error: function() {
                        alert('Failed to fetch product data.');
                    },

                });
            });

            $(document).on('click', '.postOnLinkedin', function(e) {
                e.preventDefault();

                $('#loading-spinner').show(); // Show loading animation

                var productId = $(this).data('id');

                // Get the row data using the DataTable instance
                var table = $('#products-table').DataTable();
                var rowData = table.row($(this).parents('tr')).data();

                var title = rowData.title;
                var description = rowData.description;
                var imagePath = rowData.image;
                var videoPath = rowData.video;
                var link = rowData.link;

                var baseUrl = "{{ asset('')}}";



                // Get the image path from the row (if exists)
                // var imageElement = $(this).closest('tr').find('td img'); // Find image in the row
                // var imageSrc = imageElement.length > 0 ? imageElement.attr('src') :
                //     null; // Get src if exists

                // if (imageSrc) {
                //     var baseUrl = "{{ asset('') }}"; // Laravel base URL
                //     imageSrc = imageSrc.replace(baseUrl, ''); // Remove base URL to get relative path
                // }

                // Create data object
                var requestData = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: productId,
                    title: title,
                    description: description
                };

                // Add image only if it exists
                // if (imageSrc) {
                //     requestData.image = imageSrc;
                // }


                if(imagePath){
                    requestData.image = baseUrl + imagePath;
                }else if (videoPath){
                    requestData.video = baseUrl + videoPath;
                }

                if(link){
                    requestData.link = link;
                }

                $.ajax({
                    url: '/linkedin/postOnLinkedin',
                    type: 'POST',
                    data: requestData,
                    success: function(response) {
                        $('#loading-spinner').hide(); // Hide loading animation
                        if (response.status == 'success') {
                            swal({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                button: "OK",
                            });

                        } else {
                            swal({
                                title: "Failed!",
                                text: response.message,
                                icon: "error",
                                button: "OK",
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#loading-spinner').hide(); // Hide loading animation
                        swal({
                            title: "Failed!",
                            // text: error,
                            text: 'OOTry connecting with linkedin again',
                            icon: "error",
                            button: "OK",
                        });
                    }
                })
            });

            // Delete product functionality
            // $(document).on('click', '.delete-product', function() {
            //     var id = $(this).data('id');
            //     if (confirm("Are you sure to delete this product?")) {
            //         $.ajax({
            //             url: '{{ url('/product/delete') }}/' + id,
            //             type: 'DELETE',
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //             },
            //             success: function(response) {
            //                 $('#products-table').DataTable().ajax.reload();
            //                 alert(response.success);
            //             }
            //         });
            //     }
            // });

            // Handle form submission for adding a product
            $('#addProductForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                //Use FormData to preserve file inputs
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('product.store') }}',
                    type: 'POST',
                    // data: $(this).serialize(),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#addProductModal').modal('hide'); // Hide the modal
                        $('#products-table').DataTable().ajax.reload(); // Reload the DataTable
                        // alert('Product added successfully.');
                        $('#addProductForm')[0].reset();



                        // Check if there is a success message in the session
                        swal({
                            title: "Success!",
                            text: "Product Added Successfully!", // Display the success message
                            icon: "success",
                            button: "OK",
                        });


                    },
                    error: function(xhr) {
                        alert('Error adding product: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();

            var id = ev.currentTarget.getAttribute('data-id');
            var urlToRedirect = "/product/delete/" + id;
            console.log(urlToRedirect);

            swal({
                    title: "Are you sure to delete this",
                    text: "You won't be able to revert",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })

                .then((willCancel) => {
                    console.log("Proceeding  request"); // Log if we proceed with delete
                    if (willCancel) {
                        console.log("Proceeding with DELETE request"); // Log if we proceed with delete
                        // Send DELETE request via fetch
                        fetch(urlToRedirect, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content'), // CSRF token
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    swal("Deleted!", "The record has been deleted.", "success")
                                        .then(() => {
                                            location.reload(); // Reload the page after successful deletion
                                        });
                                } else {
                                    swal("Error", "Failed to delete the record.", "error");
                                }
                            })
                            .catch(error => {
                                swal("Error", "Something went wrong.", "error");
                                console.error('Error:', error);
                            });
                    }
                });
        }
    </script>
@endsection
