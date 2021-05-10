<!-- Modal -->
<div class="modal fade" id="edit_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit_productLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_productLabel">Add / Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body edit_product_items">
                <input type="hidden" id="edit-product-id" value="" />
                <input type="hidden" id="edit-category-id" value="" />
                <div class="input-group mb-3">
                    <label class="input-group-text">Picture URL</label>
                    <input type="text" class="form-control picture-url" />
                </div>
                <input type="button" class="btn btn-outline-dark align-middle mb-3 select_image_toggle" value="Select Image">
                <input type="button" class="btn btn-outline-dark align-middle mb-3 upload_image_toggle" data-name="" value="Upload Image">
                <?php
                include_once("elements/gallery.php");
                include_once('elements/uploader.php');
                ?>
                <div class="input-group mb-3">
                    <label class="input-group-text">Name</label>
                    <input type="text" class="form-control product-name" />
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text">Description</label>
                    <textarea type="text" class="form-control product-description"></textarea>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text">Price</label>
                    <input type="text" class="form-control product-price" />
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text">Kind</label>
                    <input type="text" class="form-control product-kind" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="button" class="btn btn-outline-dark align-middle edit-product-btn" value="Save">
                </div>
            </div>

        </div>
    </div>
</div>