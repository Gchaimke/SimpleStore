<div class="card mt-2" style="width: 18rem;">
    <div class="card-image" style="background-image: url('<?= $product->img ?>');"></div>
    <div class="card-body">
        <?php if ($logedin) {
            echo "<i class='far fa-trash-alt delete-product' data-category='$category_num ' data-product='$product_num '></i>";
            echo "<i class='far fa-edit edit-product' data-category='$category_num ' 
            data-product='$product_num ' 
            data-picture='$product->img' 
            data-name='$product->name'
            data-description='$product->description'
            data-price='$product->price'
            data-kind='$product->kind'
            ></i>";
        }
        ?>
        <center>
            <h5 class="card-title"><?= $product->name ?></h5>
            <p class="card-text"><?= $product->description ?></p>
            <div class="d-flex justify-content-center">
                <h5 class="card-text me-3"><?= $product->price ?> ש"ח</h5>
                <div> <?= $product->kind ?></div>
            </div>
        </center>
    </div>
</div>