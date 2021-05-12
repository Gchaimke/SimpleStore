<?php


if ($favorite_num == 1) {
    echo '<div class="carousel-item active">';
} else {
    echo '<div class="carousel-item">';
}

?>
<div class="col-md mb-3">
    <div class="card product-card mt-2">
        <div class="card-image" style="background-image: url('<?= SITE_ROOT . $product->img ?>');"></div>
        <div class="card-body">
            <?php
            if (!isset($product->id)) {
                $product->id = $favorite_num;
            }
            if ($logedin) {
                echo "<i class='far fa-trash-alt delete-favorite text-danger' data-category='favorites' data-product='$product->id'></i>";
            }
            $product_cart_id = 'favorites_' . $product->id
            ?>
            <center>
                <h5 class="card-title"><?= $product->name ?></h5>
                <p class="card-text"><?= $product->description ?></p>
                <div class="d-flex justify-content-center text-nowrap">
                    <h5 class="card-text me-3"><?= $product->price ?> ש"ח</h5>
                    <div> <?= $product->kind ?></div>
                    <?= "<i class='fas fa-cart-plus product-to-cart' data-product_id='$product_cart_id' data-product='$product->name' data-qty='$product->kind' data-price='$product->price'></i>" ?>
                </div>
            </center>
        </div>
    </div>
</div>
<?php

if ($favorite_num == 1) {
    echo '</div>';
}else{
    echo '</div>';

}
?>