<button type="button" class="btn btn-outline-dark align-middle add-product_toggle mt-4 float-end mb-4" data-category='<?= $category_num ?> '>
    <i class="far fa-plus-square" style="font-size: 2em;"></i>
</button>
<div class="card mt-2 new-product" style="width: 100%; display:none;">
    <div class="card-body">
        <h2>New Product</h2>
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
        <button type="button" class="btn btn-outline-dark align-middle add-product" data-category='<?= $category_num ?> '>
            Save
        </button>
    </div>
</div>