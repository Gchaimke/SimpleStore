<div class="card product-card  h-100">
    <div class="card-image" style="background-image: url('<?= auto_version($product->img) ?>');height: <?= $company->image_height ?>px;background-size:<?= $company->image_size ?>;"></div>
    <div class="card-body product">
        <?php
        $qtty =  property_exists($product, 'qtty') ? $product->qtty : 1;
        $name = property_exists($product, "name_" . $lng) ? "name_" . $lng : "name";
        $description = property_exists($product, "description_" . $lng) ? "description_" . $lng : "description";
        $kind = property_exists($product, "kind_" . $lng) ? "kind_" . $lng : "kind";
        $options = property_exists($product, "options_" . $lng) ? "options_" . $lng : "options";
        if ($logedin) {
            echo "<i class='btn btn-outline-danger far fa-trash-alt delete-product' data-category='$product->category_id' data-product='$product->id'></i>";
            echo "<i class='btn btn-outline-info far fa-edit edit-product' 
            data-category='$product->category_id ' 
            data-product='$product->id' 
            data-img='$product->img' 
            data-name='" . $product->$name . "'
            data-description='" . $product->$description . "'
            data-price='$product->price'
            data-qtty='$qtty'
            data-kind='" . $product->$kind . "'
            data-options='" . $product->$options . "'
            data-bs-toggle=\"modal\" data-bs-target=\"#edit_product\"
            ></i>";
            if ($product->category_id != "favorites") {
                echo "<i class='btn btn-outline-dark far fa-clone duplicate-product' data-category='$product->category_id ' data-product='$product->id'></i>";
                echo "<i class='btn btn-outline-warning far fa-star favorite-product' data-category='$product->category_id ' data-product='$product->id'></i>";
            }
        }
        ?>
        <div class="card-content text-center">
            <h5 class="card-title"><?= $product->$name ?></h5>
            <p class="card-text"><?= $product->$description ?></p>
            <div class="mx-1"><span class="card-qtty"><?= $qtty . "</span><span class='card-kind'>" . $product->$kind ?></span></div>
        </div>
    </div>

    <div class="card-footer text-nowrap">
        <div class="product-to-cart" data-product_id="<?= $product_cart_id ?>" data-product_options="<?= $product->$options ?>">
            <div class="mx-1"><span class="card-price h5"><?= $product->price . "</span><span>" . $carrency ?></span></div>
            <i class='fas fa-cart-plus'></i>
        </div>
    </div>
</div>