<div class="content statistic">
    <?php
    $total = 0;
    foreach ($stats as $item) {
        $total += $item->total;
    }
    ?>
    <ul>
        <b>This month:</b>
        <li class="col-md">'Send' clicks: <b><?= count((array)$stats) ?></b></li>
        <li class="col-md">Total carts amount:<b> <?= $total ?> ש"ח </b></li>
    </ul>
</div>