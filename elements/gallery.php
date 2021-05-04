<?php
$images = get_images();
?>

<div class="gallery-wrapper m-2 col-sm">
    <input type="button" class="btn btn-outline-dark align-middle mb-3 select_image_toggle" value="Select Image">
    <input type="button" class="btn btn-outline-dark align-middle mb-3 upload_image_toggle" value="Upload Image">
    <div class="m-2 gallery_view" style="display: none;">
        <span class='btn btn-close bg-warning close-parent float-end' aria-label="Close"></span>
        <b>Click to select image</b>
        <div class="row overflow-auto">
            <?php
            foreach ($images as $image) {
                echo "<div class='col gallery_image m-2' data-path='/img/products/$image'>
                        <span style=\"background-image: url('/img/products/$image');;height: 100px;display: block;width: 100%;min-width: 150px;margin: auto;\"></span>
                        <div>$image</div>
                </div>";
            }
            ?>
        </div>
    </div>
</div>