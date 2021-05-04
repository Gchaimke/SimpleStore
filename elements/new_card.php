<button type="button" class="btn btn-outline-dark align-middle add-product_toggle mt-md-4 float-end mb-md-4" data-category='<?= $category_num ?> '>
    <i class="far fa-plus-square" style="font-size: 2em;"></i>
</button>
<div class="card mt-2 new-product" style="width: 100%; display:none;">
    <div class="card-body">
        <h2>New Product</h2>
        <?php include('elements/edit_product.php'); ?>
        <input type="button" class="btn btn-outline-dark align-middle add-product" data-category='<?= $category_num ?> ' value="Save"/>
    </div>
</div>