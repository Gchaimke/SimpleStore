<!-- Modal -->
<div class="modal fade" id="client_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="client_dataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="client_dataLabel"><?= lang($lng,"shipment") ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="client_form">
                    <div class="input-group mt-2">
                        <label class="input-group-text"><?= lang($lng,"name") ?></label>
                        <input type="text" class="form-control" name="name" required />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text"><?= lang($lng,"phone") ?></label>
                        <input type="text" class="form-control" name="phone" required />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text"><?= lang($lng,"email") ?></label>
                        <input type="text" class="form-control" name="email" />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text"><?= lang($lng,"address") ?></label>
                        <input type="text" class="form-control" placeholder="<?= lang($lng,"address_pl") ?>" name="address" />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text" ><?= lang($lng,"city") ?></label>
                        <?php include_once('elements/cities.php'); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal"><?= lang($lng,"close") ?></button>
                        <button type="submit" class="btn btn-primary send"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span> <?= lang($lng,"send") ?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>