    <div class="gallery_upload m-2 " style="display: none;">
        <span class='btn btn-close bg-warning close-parent float-end' aria-label="Close"></span>
        <div class="col-md-4 m-auto">
            <h6>Upload file</h6>
            <form method='post' action='' enctype='multipart/form-data' class="gallery_upload_form">
                <div class="input-group mb-3">
                    <label class="input-group-text">Set Iamge Name</label>
                    <input type="text" class="form-control upload_image_name" />
                </div>
                <input type='file' id="imagefile" name='imagefile'>
                <input type='button' value='Upload' class='upload_btn'>
            </form>
            <hr>
            <div>
                <h6>Upload from URL</h6>
                <div class="input-group mb-3">
                    <label class="input-group-text">Set Iamge Name</label>
                    <input type="text" class="form-control upload_image_name" />
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text">Image URL</label>
                    <input type="text" class="form-control upload_image_url" />
                </div>
                <input type="button" class="btn btn-outline-dark align-middle mb-3 get_form_url" value="Get From URL">
            </div>
        </div>
    </div>