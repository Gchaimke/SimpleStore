<div class="item mb-5 col">
    <div class="card product-card mt-2">
        <div class="card-image" style="background-image: url('<?= SITE_ROOT . $product->img ?>');"></div>
        <div class="card-body product">
            <?php
            $qtty =  property_exists($product, 'qtty') ? $product->qtty : 1;
            if ($logedin) {
                echo "<i class='btn btn-outline-danger far fa-trash-alt delete-product' data-category='favorites' data-product='$product->id'></i>";
                echo "<i class='btn btn-outline-info far fa-edit edit-product' data-category='$category->id ' 
                data-product='$product->id' 
                data-img='$product->img' 
                data-name='$product->name'
                data-description='$product->description'
                data-price='$product->price'
                data-qtty='$qtty'
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
                    <div class="mx-1"> <?= $qtty . $product->kind ?></div>
                    <h5 class="card-price mx-1"><?= $product->price ?> ₪</h5>
                    <?= "<i class='fas fa-cart-plus product-to-cart' data-product_id='$product_cart_id' data-product='$product->name' data-qty='$product->kind' data-price='$product->price'></i>" ?>
                </div>
            </center>
        </div>
    </div>
</div>