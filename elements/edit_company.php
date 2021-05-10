<div class="modal fade" id="editCompany" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCompanyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCompanyLabel">Edit Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit_company">
                    <input type="hidden" name="edit_company" value="true" />
                    <div class="input-group mb-3">
                        <label class="input-group-text">Company Name</label>
                        <input type="text" class="form-control" name="name" value="<?= $company->name ?>" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text">Phone</label>
                        <input type="text" class="form-control" name="phone" value="<?= $company->phone ?>" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text">Logo</label>
                        <input type="text" class="form-control" name="logo" value="<?= $company->logo ?>" />
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text">Header</label>
                        <textarea type="password" class="form-control" name="header"><?= $company->header ?></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text">Password</label>
                        <input type="password" class="form-control" name="pass" value="<?= $company->pass ?>" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input name="submit" type="submit" class="btn btn-outline-dark align-middle" value="Update" />
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>