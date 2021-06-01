<!-- Modal -->
<div class="modal fade" id="categoryEditor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="categoryEditorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scategoryEditorLabel"><?=lang("new_category")?>/<?=lang("edit_category")?></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="category_editor">
                    <div class="input-group mb-3">
                        <label class="input-group-text"><?=lang("name")?> <?=lang("category")?> </label>
                        <input type="text" class="form-control category_editor-name" />
                        <input type="hidden" class="category_editor-id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=lang("close")?></button>
                        <input type="button" class="btn btn-outline-dark align-middle add-category" value="<?=lang("save")?>" />
                        <input type="button" class="btn btn-outline-dark align-middle edit-category_btn" value="Update" style="display: none;" />
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>