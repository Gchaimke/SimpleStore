<!-- Modal -->
<div class="modal fade" id="client_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="client_dataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="client_dataLabel"><?= lang("shipment") ?></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="send_cart.php" id="client_form" method="POST">
                    <input type="hidden" name="cart" />
                    <div class="input-group mt-2">
                        <label class="input-group-text">* <?= lang("name") ?></label>
                        <input type="text" class="form-control" name="client[name]" placeholder="<?= lang("name") ?>" required />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text">* <?= lang("phone") ?></label>
                        <input type="text" class="form-control" name="client[phone]" placeholder="054-111-2222" required />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text">* <?= lang("email") ?></label>
                        <input type="text" class="form-control" name="client[email]" placeholder="<?= lang("email") ?>" required />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text">* <?= lang("address") ?></label>
                        <input type="text" class="form-control" placeholder="<?= lang("address_pl") ?>" name="client[address]" required />
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text"><?= lang("note") ?></label>
                        <textarea class="form-control" placeholder="<?= lang("note") ?>" name="client[note]"></textarea>
                    </div>
                    <div class="modal-footer">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal"><?= lang("close") ?></button>
                        <button type="submit" class="btn btn-primary send"> <?= lang("send") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>