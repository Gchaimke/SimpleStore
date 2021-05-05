<?php
$images = get_images();
?>

<div class="gallery-wrapper m-2 col-sm">
    <div class="m-2 gallery_view" style="display: none;">
        <span class='btn btn-close bg-warning close-parent float-end' aria-label="Close"></span>
        <b>Click to select image</b>
        <div class="row overflow-auto">
            <?php
            foreach ($images as $image) {
                echo "<div class='col gallery_image m-2'>
                        <span class='w-full d-block image' data-path='/img/products/$image' style=\"background-image: url('/img/products/$image');min-width: 150px;\"></span>
                        <div class='flex text-nowrap'>$image <i class='btn far fa-trash-alt delete-gallery-image text-danger' data-path='/img/products/$image'></i></div>
                </div>";
            }
            ?>
        </div>
    </div>
</div>