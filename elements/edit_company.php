<form id="edit_company" style="display: none;">
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
    <input name="submit" type="submit" class="btn btn-outline-dark align-middle mb-3 float-end" value="Update" />
    <input name="close" type="button" class="btn btn-outline-dark align-middle mb-3 edit-company-close" value="Close" />
</form>