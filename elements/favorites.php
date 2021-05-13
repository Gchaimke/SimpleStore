<?php
if (is_iterable($favorites)) { ?>
    <section class="pt-5 pb-5">
        <h2>Избраные товары</h2>
        <div id="carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

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
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
<?php
} else {
    echo 'No Favorites';
}
?>

<div id="exampleSlider">      <!-- Give wrapper ID to target with jQuery & CSS -->
    <div class="MS-content row">
        <div class="item col"> Item 1 </div>
        <div class="item col"> Item 2 </div>
        <div class="item col"> Item 3 </div>
        <div class="item col"> Item 4 </div>
        <div class="item col"> Item 5 </div>
        <div class="item col"> Item 6 </div>
        <div class="item col"> Item 7 </div>
        <div class="item col"> Item 8 </div>
    </div>
    <div class="MS-controls">
        <button class="MS-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
        <button class="MS-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
    </div>
</div>