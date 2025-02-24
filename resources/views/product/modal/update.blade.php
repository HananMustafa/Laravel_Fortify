<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
                <button type="button" class="btn-close" style="width: 20px; height: 20px;" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateProductForm" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="Section-Form">
                        <input type="text" name="title" required class="form-field animation a3"
                            placeholder="Title">
                        <input type="text" id="description" name="description" required
                            class="form-field animation a3" placeholder="Description">
                        <div class="mb-3">
                            <label>Upload File/Image</label>
                            <input type="file" name="image" class="form-control" />
                        </div>
                        <button type="submit" class="button">Update Product</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
