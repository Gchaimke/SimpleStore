<div class="card mt-2 edit-product-card" style="width: 100%; display:none;">
    <div class="card-body">
        <h2>Edit Product</h2>
        <input type="hidden" id="edit-product-id" value="" />
        <input type="hidden" id="edit-category-id" value="" />
        <?php include('elements/edit_product.php'); ?>
        <button type="button" class="btn btn-outline-dark align-middle edit-product-btn">
            Save
        </button>
        <button type="button" class="btn btn-outline-dark align-middle close-edit-product">
            Close
        </button>
    </div>
</div>