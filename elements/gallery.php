<?php
$images = get_images();
?>

<div class="gallery-wrapper m-2 col-sm">
    <input type="button" class="btn btn-outline-dark align-middle mb-3 select_image_toggle" value="Select Image">
    <input type="button" class="btn btn-outline-dark align-middle mb-3 upload_image_toggle" value="Upload Image">
    <div class="gallery_upload m-2 col-md-4" style="display: none;">
        <span class='btn btn-close bg-warning close-parent float-end' aria-label="Close"></span>
        <h6>Upload file</h6>
        <form method='post' action='' enctype='multipart/form-data' class="gallery_upload_form">
            <input type='file' name='imagefile'>
            <input type='submit' value='Upload' name='upload'>
        </form>
        <hr>
        <div>
            <h6>Upload from URL</h6>
            <div class="input-group mb-3">
                <label class="input-group-text">Image URL</label>
                <input type="text" class="form-control upload_image_url" />
            </div>
            <input type="button" class="btn btn-outline-dark align-middle mb-3 get_form_url" value="Get From URL">
        </div>
    </div>
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