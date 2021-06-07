<?php $name_lang="name_".$lng?>
<select class="form-select" aria-label="Select" name="city">
    <option value="<?= lang("pickup")." ".lang("bat-yam") ?>" selected><?= lang("pickup")." ".lang("bat-yam") ?> </option>
    <?php foreach ($distrikts as $distrikt) : ?>
        <?php foreach ($distrikt as $key => $data) : ?>
            <optgroup label="<?=$data->$name_lang ?>">
            <?php foreach ($data as $key =>  $cities) : ?>
                <?php $min_order = $data->min_order ?>
                <?php if ($key == "cities") : ?>
                    <?php foreach ($cities as $city) : ?>
                        <option value="<?= $city->$name_lang ?>" data-minOrder="<?= $min_order ?>"><?= $city->$name_lang ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach ?>
            </optgroup>
        <?php endforeach ?>
    <?php endforeach ?>
</select>