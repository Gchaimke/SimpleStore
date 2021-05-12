<?php
if (is_iterable($favorites)) { ?>
    <section class="pt-5 pb-5">
        <h2>Избраные товары</h2>
        <div id="carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="row">
                    <?php
                    $favorite_num = 1;
                    foreach ($favorites as $product) {
                        include('elements/favorites_card.php');
                        $favorite_num++;
                    }
                    ?>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
<?php
} else {
    echo 'No Favorites';
}
?>