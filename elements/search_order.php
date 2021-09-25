<?php
$folders = array_diff(scandir(ORDERS_PATH, 1), array('..', '.'));
?>
<center>
    <form id="search_order" class="col-md-4">
        <label for="search_order"><?= lang("search order") ?></label>
        <div class="input-group mt-2">
            <select id="search_order_month" name="month" class="form-control" id="">
                <?php foreach ($folders as $folder) {
                    echo "<option>$folder</option>";
                } ?>
            </select>
            <input type="number" id="search_order_val" class="form-control" name="search_order" min="1"/>
            <button type="submit" class="btn btn-dark send"><?= lang("search_btn") ?></button>
        </div>
    </form>
</center>