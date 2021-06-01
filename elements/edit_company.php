<div class="modal fade" id="editCompany" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCompanyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCompanyLabel"><?=lang("settings")?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit_company">
                    <input type="hidden" name="edit_company" value="true" />
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?=lang("company_name")?></label>
                        <input type="text" class="form-control" name="name" value="<?= $company->name ?>" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?=lang("phone")?></label>
                        <input type="text" class="form-control" name="phone" value="<?= $company->phone ?>" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?=lang("email")?></label>
                        <input type="text" class="form-control" name="email" value="<?= $company->email ?>" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?=lang("logo")?></label>
                        <input type="text" class="form-control" name="logo" value="<?= $company->logo ?>" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?=lang("company_message")?></label>
                        <textarea type="password" class="form-control" name="header" rows="10"><?= $company->header ?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=lang("close")?></button>
                        <input name="submit" type="submit" class="btn btn-outline-dark align-middle" value="<?=lang("save")?>" />
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>