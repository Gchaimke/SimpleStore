<div class="content statistic">
    <?php
    $total = 0;
    $count = 0;
    if (is_array($orders)) {
        foreach ($orders["orders"] as $order) {
            $total += json_decode(file_get_contents(ORDERS_PATH . $orders["month"] . '/' . $order))->total;
        }
        $count = count($orders["orders"]);
    }
    ?>
    <ul>
        <b>This month:</b>
        <li class="col-md">Заказы: <b><?= $count ?></b></li>
        <li class="col-md">Сумма:<b> <?= $total ?> ש"ח </b></li>
    </ul>
</div>