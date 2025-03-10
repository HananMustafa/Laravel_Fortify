<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    @csrf

                    <div class="mx-5">

                        <div class="center-70">
                            <input type="text" name="title" required class="form-field animation a3"
                                placeholder="Title">
                            <input type="text" id="description" name="description" required
                                class="form-field animation a3" placeholder="Description">
                        </div>

                        <div class="mt-3">
                            <input type="file" name="video" /> {{--Video can be uploaded --}}
                        </div>
                        <div class= "Section-Form">

                            <button type="submit" class="button">Add Product</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
