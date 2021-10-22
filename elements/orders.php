<?php
$month = $_GET['orders'];
$orders = get_orders($month);
if (isset($_GET['max'])) {
    $max = $_GET['max'];
} else {
    $max = 30;
}
if (isset($_GET['current'])) {
    $current = $_GET['current'];
} else {
    $current = 0;
}
if (isset($orders)) {
    $html_orders = "";
    $orders = $orders['orders'];
    $orders_chunk = array_chunk($orders, $max);
    if ($current > 0 && $current <= count($orders_chunk)) {
        $current -= 1;
    } else {
        $current = 0;
    }
    if (count($orders) > 0) {
        $orders_page = array_chunk($orders, $max)[$current];
    } else {
        $orders_page = array();
    }
?>
    <h2 class='text-center'><?= lang('orders') ?></h2>
    <div class="table-responsive">
        <table class='table table-striped table-hover table-responsive table-sm text-center'>
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><?= lang('Date') ?></th>
                    <th scope="col"><?= lang('Client') ?></th>
                    <th scope="col"><?= lang('Phone') ?></th>
                    <th scope="col"><?= lang('Address') ?></th>
                    <th class="text-nowrap" scope="col"><?= lang('Total') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_countable($orders_page)) {
                    foreach ($orders_page as $order) {
                        if ($max == 0) {
                            break;
                        }
                        $order_num = explode('.', $order)[0];
                        $order_data = json_decode(file_get_contents(DATA_ROOT . 'orders/' . $month . "/" . $order));
                        if ($order_data->client->name != 'test') {
                ?>
                            <tr>
                                <th id="<?= $order_num ?>" class='order-card text-nowrap' scope="row">
                                    <a href='?order=<?= $order_num ?>'><?= $order_num ?></a>
                                </th>
                                <td class="text-nowrap"><?= $order_data->date ?></td>
                                <td><?= $order_data->client->name ?></td>
                                <td class="text-nowrap"><?= $order_data->client->phone ?></td>
                                <td><?= $order_data->client->address ?></td>
                                <td class="text-nowrap"><?= $order_data->total . $carrency ?></td>
                            </tr>
                <?php    }
                        $max--;
                    }
                }
                ?>
        </table>
    </div>

<?php
    paginate(array('orders_chunk' => $orders_chunk, 'month' => $month, 'current' => $current));
} else {
    echo "<h2 class='text-center'>no orders for " . $month . " month!</h2>";
    paginate(array('orders_chunk' => array(), 'month' => $month, 'current' => $current));
}
