<script src="js/vendor/tinymce_5_9_1/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: '#head_textarea',
        width: 1900,
        height: 500,
        plugins: [
            'preview advlist autolink link image lists hr anchor code directionality',
            'searchreplace wordcount visualblocks visualchars fullscreen insertdatetime media',
            'table emoticons paste help charmap'
        ],
        toolbar: 'preview fullscreen code | undo redo | styleselect fontsizeselect | bold italic underline| forecolor backcolor removeformat | ltr rtl | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist | outdent indent | paste pastetext | insertfile image media insertdatetime emoticons charmap'
    }).then(editor => {
        const tinyAuxEl = document.querySelector('.tox-tinymce-aux');
        const modalBodyEl = document.getElementById('editCompany'); // if using something else just grab your modal body element here
        modalBodyEl.appendChild(tinyAuxEl);
    });
</script>
<div class="modal fade" id="editCompany" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCompanyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCompanyLabel"><?= lang("settings") ?></h5>
                <div class="btn btn-outline-success mx-2" onclick="$('.save_company').click()"><?= lang("save") ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit_company">
                    <input type="hidden" name="edit_company" value="true" />
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("company_name") ?></label>
                        <input type="text" class="form-control company_name" name="name" value="<?= $company->name ?>" />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <label class="input-group-text"><?= lang("phone") ?></label>
                                <input type="text" class="form-control phone" name="phone" value="<?= $company->phone ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <label class="input-group-text"><?= lang("email") ?></label>
                                <input type="text" class="form-control email" name="email" value="<?= $company->email ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("logo") ?></label>
                        <input type="text" class="form-control picture-url" name="logo" value="<?= $company->logo ?>" />
                    </div>
                    <input type="button" class="btn btn-outline-dark align-middle mb-3 select_image_toggle" value="<?= lang("Select Image") ?>">
                    <input type="button" class="btn btn-outline-dark align-middle mb-3 upload_image_toggle" data-name="logo" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#uploader" value="<?= lang("Upload Image") ?>">
                    <?php include("elements/gallery.php"); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-3 ">
                                <label class="input-group-text"><?= lang("product image height") ?></label>
                                <input type="number" class="form-control image_height" name="image_height" value="<?= $company->image_height ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <label class="input-group-text"><?= lang("product image size") ?></label>
                                <select type="text" class="form-select" name="image_size">
                                    <?php foreach (array("cover", "contain") as $option) {
                                        $selected = $company->image_size == $option ? "selected" : "";
                                        echo  "<option value='$option' $selected>" . lang($option) . "</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-2 ">
                                <label class="input-group-text"><?= lang("Price format") ?></label>
                                <input type="number" class="form-control price_format" name="price_format" value="<?= $company->price_format ?>" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2 ">
                                <label class="input-group-text"><?= lang("Currency") ?></label>
                                <input type="text" class="form-control currency" name="currency" value="<?= $company->currency ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?= lang("company_message") ?></label>
                        <textarea id="head_textarea" class="form-control" name="header" rows="10"><?= $company->header ?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang("close") ?></button>
                        <input name="submit" type="submit" class="btn btn-outline-dark align-middle save_company" value="<?= lang("save") ?>" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>