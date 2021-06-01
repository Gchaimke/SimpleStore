<!-- Modal -->
<div class="modal fade" id="login_view" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="login_viewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="login_viewLabel"><?= lang("login") ?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="input-group mb-3">
                            <label class="input-group-text"><?= lang("password") ?></label>
                            <input type="password" id="login-pass" class="form-control" name="password" autocomplete="on"/>
                        </div>
                    </div>
                    <center>
                        <input type="button" id="login_btn" class="btn btn-outline-dark" value="<?= lang("login") ?>" />
                    </center>
                </div>
            </form>
        </div>
    </div>
</div>