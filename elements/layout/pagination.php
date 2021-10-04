<?php

$prev_month = (int)$month - 100;
$next_month = (int)$month + 100;

$zero = "";
if ($prev_month < 1000) {
    $zero = "0";
}
$prev_month = $zero . $prev_month;
if ($prev_month < 100) {
    $prev_month = "12" . ($prev_month - 1);
}

$zero = "";
if ($next_month < 1000) {
    $zero = "0";
}
if ($next_month > 1300) {
    $next_month = "0" . ($next_month + 1 - 1200);
}
$next_month = $zero . $next_month;
?>
<ul class="pagination">

    <?php
    foreach ($orders_chunk as $key => $page) {
        $selected = "";
        if ($current == $key) {
            $selected = 'active';
        }
        $page = $key + 1;
        echo "<li class='page-item $selected'><a class='page-link' href='?orders=$month&current=$page'>$page</a></li>";
    }
    ?>

    <li class="page-item">
        <a class="page-link" href="?orders=<?= $prev_month ?>"><?= lang("Previos Month") ?></a>
    </li>
    <li class="page-item">
        <a class="page-link" href="?orders=<?= $next_month ?>" tabindex="-1" aria-disabled="true"><?= lang("Next Month") ?></a>
    </li>
</ul>