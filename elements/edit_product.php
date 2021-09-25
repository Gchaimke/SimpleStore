<!-- Modal -->
<div class="modal fade" id="edit_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit_productLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_productLabel">Add / Edit Product</h3>
                    <div class="btn btn-outline-success mx-2" onclick="$('.edit-product-btn').click()"><?= lang("save") ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body edit_product_items">
                <form id="edit_product_form">
                    <input type="hidden" name="edit_product" value="true"/>
                    <input type="hidden" name="id" id="edit-product-id" value="" />
                    <input type="hidden" name="category_id" id="edit-category-id" value="" />
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("Image URL") ?></label>
                        <input type="text" name="img" class="form-control picture-url" />
                    </div>
                    <input type="button" class="btn btn-outline-dark align-middle mb-3 select_image_toggle" value="<?= lang("Select Image") ?>">
                    <input type="button" class="btn btn-outline-dark align-middle mb-3 upload_image_toggle" data-name="1" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#uploader" value="<?= lang("Upload Image") ?>">
                    <?php include("elements/gallery.php"); ?>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("name") ?></label>
                        <input type="text" name="name" class="form-control product-name" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("Description") ?></label>
                        <textarea type="text" name="description" class="form-control product-description"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("price") ?></label>
                        <input type="number" name="price" class="form-control product-price" step="0.01"/>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("Quantity") ?></label>
                        <input type="number" name="qtty" class="form-control product-qtty" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("Kind") ?></label>
                        <input type="text" name="kind" class="form-control product-kind" placeholder="kg" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("Options") ?></label>
                        <input type="text" name="options" class="form-control product-options" placeholder="slice, do not slice" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang("close") ?></button>
                        <button type="submit" class="btn btn-outline-dark align-middle edit-product-btn" ><?= lang("save") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>