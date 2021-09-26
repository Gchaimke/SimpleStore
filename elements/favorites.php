<?php if (is_iterable($favorites) && count((array)$favorites) > 0) { ?>
    <section class="pt-3 pb-3">
        <h2><?= lang("favorites") ?></h2>
        <div id="favorites_slider">
            <!-- Give wrapper ID to target with jQuery & CSS -->
            <div class="MS-content row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php
                $favorite_num = 1;
                $category = new stdClass();
                $category->id = 'favorites';
                foreach ($favorites as $product) {
                    if (!isset($product->id)) {
                        $product->id = $favorite_num;
                    }
                    $product_cart_id = $product->category_id . '_' . $product->id;
                    echo "<div class='item col' id='$product_cart_id'>";
                    include('elements/card.php');
                    $favorite_num++;
                    echo "</div>";
                }
                ?>
            </div>
            <div class="MS-controls">
                <button class="btn MS-left" aria-label="slider left"><i class="fas fa-chevron-left"></i></button>
                <button class="btn MS-right" aria-label="slider right"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>
<?php
} else {
    if ($logedin) {
        echo 'No Favorites';
    }
}
?>