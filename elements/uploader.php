    <div class="gallery_upload m-2 " style="display: none;">
        <span class='btn btn-close bg-warning close-parent float-end' aria-label="Close"></span>
        <div class="input-group mb-3">
            <label class="input-group-text"><?=lang('New Image Name')?></label>
            <input type="text" class="form-control upload_image_name"/>
        </div>
        <div class="row">
            <div class="m-md-3 p-4 col-md card">
                <h6><?=lang('Upload from Device')?></h6>
                <input type='file' id="imagefile" name='imagefile' class="form-control">
                <input type='button' value='<?=lang('Upload')?>' class='btn btn-outline-dark align-middle m-3 upload_btn'>
            </div>
            <div class="m-md-3 p-4 col-md card">
                <h6><?=lang('Upload from URL')?></h6>
                <div class="input-group mb-3">
                <label class="input-group-text"><?=lang('Image URL')?></label>
                <input type="text" class="form-control upload_image_url" />
                </div>
            <input type="button" class="btn btn-outline-dark align-middle mb-3 get_form_url" value="<?=lang('Get from URL')?>">
            </div>
        </div>
    </div>