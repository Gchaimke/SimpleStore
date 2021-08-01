<div class="card product-card m-4 m-md-1">
    <div class="card-image" style="background-image: url('<?= auto_version($product->img) ?>');height: <?= CARD_IMG_HEIGHT ?>px;background-size:<?= CARD_IMG_BG_SIZE ?>;"></div>
    <div class="card-body product">
        <?php
        $qtty =  property_exists($product, 'qtty') ? $product->qtty : 1;
        $name = property_exists($product, "name_" . $lng) ? "name_" . $lng : "name";
        $description = property_exists($product, "description_" . $lng) ? "description_" . $lng : "description";
        $kind = property_exists($product, "kind_" . $lng) ? "kind_" . $lng : "kind";
        $options = property_exists($product, "options_" . $lng) ? "options_" . $lng : "options";
        if ($logedin) {
            echo "<i class='btn btn-outline-danger far fa-trash-alt delete-product' data-category='$product->category_id' data-product='$product->id'></i>";
            echo "<i class='btn btn-outline-info far fa-edit edit-product'  data-bs-toggle=\"modal\" data-bs-target=\"#edit_product\"></i>";
            if ($product->category_id != "favorites") {
                echo "<i class='btn btn-outline-dark far fa-clone duplicate-product' data-category='$product->category_id ' data-product='$product->id'></i>";
                echo "<i class='btn btn-outline-warning far fa-star favorite-product' data-category='$product->category_id ' data-product='$product->id'></i>";
            }
        }
        ?>
        <div class="card-content text-center">
            <h5 class="card-title"><?= $product->$name ?></h3>
                <p class="card-text"><?= $product->$description ?></p>
                <div class="d-flex justify-content-center text-nowrap">
                    <div class="mx-1"> <?= $qtty . $product->$kind ?></div>
                    <h5 class="card-price mx-1"><?= $product->price . $carrency ?></h3>
                        <?= "<i class='fas fa-cart-plus product-to-cart' data-product_id='$product_cart_id' data-product_options='{$product->$options}'></i>" ?>
                </div>
        </div>
    </div>
</div>