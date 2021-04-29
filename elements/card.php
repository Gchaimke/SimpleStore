<div class="card mt-2" style="width: 18rem;">
    <div class="card-image" style="background-image: url('<?= $product->img ?>');"></div>
    <div class="card-body">
        <?php if ($logedin) {
            echo "<i class='far fa-trash-alt delete-product' data-category='$category_num ' data-product='$product_num '></i>";
            echo "<i class='far fa-edit edit-product' data-category='$category_num ' data-product='$product_num '></i>";
        }
        ?>
        <h5 class="card-title"><?= $product->name ?></h5>
        <p class="card-text"><?= $product->description ?></p>
        <div class="d-flex justify-content-center">
            <h5 class="card-text me-3"><?= $product->price ?></span> ש"ח / <?= $product->kind ?></h5>
        </div>
    </div>
</div>