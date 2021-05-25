<select class="form-select" aria-label="Default select example">
    <option selected>Select</option>
    <?php foreach ($distrikts as $distrikt) : ?>
        <?php foreach ($distrikt as $key => $data) : ?>
            <optgroup label="<?=$key ?>">
            <?php foreach ($data as $key =>  $cities) : ?>
                <?php $min_order = $data->min_order ?>
                <?php if ($key == "cities") : ?>
                    <?php foreach ($cities as $city) : ?>
                        <option value="<?= $min_order ?>"><?= $city->name ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach ?>
            </optgroup>
        <?php endforeach ?>
    <?php endforeach ?>
</select>