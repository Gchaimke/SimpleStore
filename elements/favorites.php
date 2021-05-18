<?php if (is_iterable($favorites)) { ?>
    <section class="pt-5 pb-5">
        <h2>Избраные товары</h2>
        <div id="favorites_slider">
            <!-- Give wrapper ID to target with jQuery & CSS -->
            <div class="MS-content row">
                <?php
                $favorite_num = 1;
                foreach ($favorites as $product) {
                    include('elements/favorites_card.php');
                    $favorite_num++;
                }
                ?>
            </div>
            <div class="MS-controls">
                <button class="MS-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                <button class="MS-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </section>
<?php
} else {
    echo 'No Favorites';
}
?>