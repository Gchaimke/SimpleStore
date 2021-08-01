<?php if (is_iterable($favorites) && count((array)$favorites) > 0) { ?>
    <section class="pt-3 pb-3">
        <h2><?=lang("favorites")?></h2>
        <div id="favorites_slider">
            <!-- Give wrapper ID to target with jQuery & CSS -->
            <div class="MS-content row" style="height: <?=(CARD_IMG_HEIGHT+20)*2?>px;">
                <?php
                $favorite_num = 1;
                $category = new stdClass();
                $category->id = 'favorites';

                foreach ($favorites as $product) {
                    echo "<div class='item col'>";
                    if (!isset($product->id)) {
                        $product->id = $favorite_num;
                    }
                    $product_cart_id = $product->category_id . '_' . $product->id;
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