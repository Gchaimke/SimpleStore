<div class="gallery-wrapper m-2 col-sm">
    <div class="m-2 gallery_view" style="display: none;">
        <span class='btn btn-close bg-warning close-parent float-end' aria-label="Close"></span>
        <b><?= lang("Click to select the image") ?></b>
        <div class="row overflow-auto">
            <?php
            if (is_iterable($images)) {
                foreach ($images as $path => $image_name) {
                    echo "<div class='col gallery_image m-2'>
                        <span class='w-full d-block image' data-path='$path' style=\"background-image: url('$path');min-width: 150px;\"></span>
                        <div class='flex text-nowrap'>$image_name";
                    if (strpos($path, "/img/") === false) {
                        echo "<i class='btn far fa-trash-alt delete-gallery-image text-danger' data-path='$path'></i>";
                    }
                    echo "</div></div>";
                }
            }
            ?>
        </div>
    </div>
</div>