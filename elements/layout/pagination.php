<?php
$prev_month = "0" . ((int)$month - 100);
$next_month = "0" . ((int)$month + 100);
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