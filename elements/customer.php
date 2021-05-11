<!-- Modal -->
<div class="modal fade" id="client_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="client_dataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="client_dataLabel">Shipment Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="client_form">
                    <div class="input-group mt-2">
                        <label class="input-group-text">Name</label>
                        <input type="text" class="form-control" name="name" />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text">Phone</label>
                        <input type="text" class="form-control" name="phone" />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text">Email</label>
                        <input type="text" class="form-control" name="email" />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text">Address</label>
                        <input type="text" class="form-control" name="address" />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text">City</label>
                        <input type="text" class="form-control" name="city" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary send">Send</button>
            </div>
        </div>
    </div>
</div>