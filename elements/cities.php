<?php $name_lang="name_".$lng?>
<select class="form-select" aria-label="Select">
    <option selected>Select</option>
    <?php foreach ($distrikts as $distrikt) : ?>
        <?php foreach ($distrikt as $key => $data) : ?>
            <optgroup label="<?=$data->$name_lang ?>">
            <?php foreach ($data as $key =>  $cities) : ?>
                <?php $min_order = $data->min_order ?>
                <?php if ($key == "cities") : ?>
                    <?php foreach ($cities as $city) : ?>
                        <option value="<?= $min_order ?>"><?= $city->$name_lang ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach ?>
            </optgroup>
        <?php endforeach ?>
    <?php endforeach ?>
</select>