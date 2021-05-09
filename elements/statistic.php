<?php
$stats = month_statistic();
$total = 0;
?>
<div class="content statistic">
    <?php
    foreach ($stats as $item) {
        $total += $item->total;
    }
    ?>
    <ul>
        <b>This month:</b>
        <li class="col-md">'Send' clicks: <b><?= count($stats) ?></b></li>
        <li class="col-md">Total carts amount:<b> <?= $total ?> ש"ח </b></li>
    </ul>
</div>