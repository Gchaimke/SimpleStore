<?php
$images = get_images();
?>

<div class="gallery-wrapper m-2 col-sm">
    <input type="button" class="btn btn-outline-dark align-middle mb-3 select_image_toggle" value="Select Image">
    <input type="button" class="btn btn-outline-dark align-middle mb-3 upload_image_toggle" value="Upload Image">
    <div class="m-2 gallery_view" style="display: none;">
        <span class='btn btn-close bg-warning close-parent float-end' aria-label="Close"></span>
        <b>Click to select image</b>
        <div class="d-flex">
            <?php
            foreach ($images as $image) {
                echo "<div class='card'><img class='gallery_image' src='/img/products/$image' data-path='/img/products/$image' width='100px'>
                
                </div>";
            }
            ?>
        </div>
    </div>
</div>