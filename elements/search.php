<form id="search" class="col-md-4">
    <div class="input-group mt-2">
        <label class="input-group-text"><?=lang($lng,"search")?></label>
        <input type="text" id="search_text" class="form-control" name="search"/>
        <button type="submit" class="btn btn-dark send"><?=lang($lng,"search_btn")?></button>
    </div>
</form>
<div class="row mb-3" id="search_result"></div>