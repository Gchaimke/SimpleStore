<?php if (is_iterable($favorites) && count((array)$favorites) > 0) { ?>
    <section class="pt-5 pb-5">
        <h2>Избраные товары</h2>
        <div id="favorites_slider">
            <!-- Give wrapper ID to target with jQuery & CSS -->
            <div class="MS-content row">
                <?php
                $favorite_num = 1;
                $category = new stdClass();
                $category->id = 'favorites';

                foreach ($favorites as $product) {
                    if (!isset($product->id)) {
                        $product->id = $favorite_num;
                    }
                    include('elements/favorites_card.php');
                    $favorite_num++;
                }
                ?>
            </div>
            <div class="MS-controls">
                <button class="btn MS-left"><i class="fas fa-chevron-left"></i></button>
                <button class="btn MS-right"><i class="fas fa-chevron-right"></i></button>
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