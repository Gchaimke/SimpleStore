<center>
    <form id="search" class="col-md-4 m-3">
        <div class="input-group mt-2">
            <input type="text" id="search_text" class="form-control" name="search" placeholder="<?= lang("search") ?>"/>
            <button type="submit" class="btn btn-dark send"><?= lang("search_btn") ?></button>
        </div>
    </form>
    <div id="total_found" class="m-3"></div>
</center>
<div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4" id="search_result"></div>