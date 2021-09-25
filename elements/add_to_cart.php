<!-- Modal -->
<div class="modal fade" id="addToCart" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addToCartLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToCartLabel"><?= lang("Select product option") ?></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="add_to_cart">
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("option") ?></label>
                        <select class="form-select option_name" aria-label="select option"></select>
                        <input type="hidden" class="product_id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang("close") ?></button>
                        <input type="button" class="btn btn-outline-dark align-middle add-to-cart_btn" data-bs-dismiss="modal" value="<?= lang("add") ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>