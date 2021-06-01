<form id="search" class="col-md-4">
    <div class="input-group mt-2">
        <label class="input-group-text" for="search_text"><?=lang("search")?></label>
        <input type="text" id="search_text" class="form-control" name="search"/>
        <button type="submit" class="btn btn-dark send"><?=lang("search_btn")?></button>
    </div>
</form>
<div class="row mb-3" id="search_result"></div>