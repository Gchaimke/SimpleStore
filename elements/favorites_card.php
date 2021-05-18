<div class="col-md mb-3 item col">
    <div class="card product-card mt-2">
        <div class="card-image" style="background-image: url('<?= SITE_ROOT . $product->img ?>');"></div>
        <div class="card-body">
            <?php
            if ($logedin) {
                echo "<i class='far fa-trash-alt delete-product text-danger' data-category='favorites' data-product='$product->id'></i>";
                echo "<i class='far fa-edit edit-product text-info' data-category='$category->id ' 
                data-product='$product->id' 
                data-img='$product->img' 
                data-name='$product->name'
                data-description='$product->description'
                data-price='$product->price'
                data-kind='$product->kind'
                data-bs-toggle=\"modal\" data-bs-target=\"#edit_product\"
                ></i>";
            }
            $product_cart_id = $category->id . '_' . $product->id
            ?>
            <center class="card-content">
                <h5 class="card-title"><?= $product->name ?></h5>
                <p class="card-text"><?= $product->description ?></p>
                <div class="d-flex justify-content-center text-nowrap">
                    <h5 class="card-price me-3"><?= $product->price ?> ₪</h5>
                    <div> <?= $product->kind ?></div>
                    <?= "<i class='fas fa-cart-plus product-to-cart' data-product_id='$product_cart_id' data-product='$product->name' data-qty='$product->kind' data-price='$product->price'></i>" ?>
                </div>
            </center>
        </div>
    </div>
</div>