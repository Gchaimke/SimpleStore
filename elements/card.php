<div class="card mt-2" style="width: 18rem;">
    <div class="card-image" style="background-image: url('<?= $product->img ?>');"></div>
    <div class="card-body">
        <h5 class="card-title"><?= $product->name ?></h5>
        <p class="card-text"><?= $product->description ?></p>
        <div class="d-flex justify-content-center">
            <h5 class="card-text me-3"><?= $product->price ?> ש"ח / <?= $product->kind ?></h5>
        </div>
    </div>
</div>