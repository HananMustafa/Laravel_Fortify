<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addClientForm">
                    @csrf

                    <div class="Section-Form">
                        <input type="text" name="name" required class="form-field animation a3" placeholder="Name">
                        <input type="email" id="email" name="email" required class="form-field animation a3" placeholder="Email Address">
                        <button type="submit" class="button">Add Client</button>
                      </div>
                      
                </form>
            </div>
        </div>
    </div>
</div>
