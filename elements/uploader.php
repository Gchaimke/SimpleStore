<div class="modal fade" id="uploader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploaderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploaderLabel"><?= lang('New Image Name') ?></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="gallery_upload">
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang('New Image Name') ?></label>
                        <input id="upload_image_name" type="text" class="form-control" />
                    </div>
                    <div class="row">
                        <div class="m-md-3 p-4 col-md card">
                            <h6><?= lang('Upload from Device') ?></h6>
                            <input type='file' id="imagefile" name='imagefile' class="form-control">
                            <input type='button' value='<?= lang('Upload') ?>' class='btn btn-outline-dark align-middle m-3 upload_btn'>
                        </div>
                        <div class="m-md-3 p-4 col-md card">
                            <h6><?= lang('Upload from URL') ?></h6>
                            <div class="input-group mb-3">
                                <label class="input-group-text"><?= lang('Image URL') ?></label>
                                <input type="text" class="form-control upload_image_url" />
                            </div>
                            <input type="button" class="btn btn-outline-dark align-middle mb-3 get_from_url" value="<?= lang('Get from URL') ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=lang("close")?></button>
            </div>
        </div>
    </div>
</div>
