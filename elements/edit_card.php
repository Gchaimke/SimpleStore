<div class="card mt-2 edit-product-card" style="width: 100%; display:none;">
    <div class="card-body">
        <h2>Edit Product</h2>
        <input type="hidden" id="edit-product-id" value="" />
        <input type="hidden" id="edit-category-id" value="" />

        <div class="input-group mb-3">
            <label class="input-group-text">Picture URL</label>
            <input type="text" class="form-control picture-url" />
        </div>
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
        <button type="button" class="btn btn-outline-dark align-middle edit-product-btn">
            Edit
        </button>
    </div>
</div>