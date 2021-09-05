<?php

if (isset($_GET['logout'])) {
    logout();
}

if (isset($_GET['email_order'])) {
    send_email($_GET['email_order']);
}

if (isset($_GET['csv'])) {
    export_csv();
}

if (isset($_GET['order'])) {
    $hidden = '';
    $order = order_to_html($_GET['order']);
    $prev_month = date("my", strtotime(date('my') . " -1 month"));
    if ($logedin) {
        $order .= order_client_to_html($_GET['order']);
        $order_num = explode("-", $_GET['order']);
        if (count($order_num) > 1) {
            $orders['this_month'] = get_orders($order_num[0])['orders'];
            $orders['prev_month'] = get_orders($prev_month)['orders'];

            $next = $order_num[0] . "-" . add_zero(intval($order_num[1]) + 1);

            if (intval($order_num[1]) == 1) {
                $prev = str_replace(".json", '', $orders['prev_month'][0]) . "&last=1";
            } else {
                $prev = $order_num[0] . "-" . add_zero(intval($order_num[1]) - 1);
            }

            if ($_GET['order'] == str_replace(".json", '', $orders['this_month'][0]) && date('my') == $order_num[0]) {
                $hidden = 'hidden';
            }

            if ($_GET['order'] == str_replace(".json", '', $orders['this_month'][0])) {
                $next = date('my') . "-" . add_zero(1);
            }

            $order .= "<div id='order_controls'><a href='?order=$prev'>" . lang('prev') . "</a><a href='?order=$next' class='$hidden'>" . lang('next') . "</a></div>";
        }
    }
    print($order);
    if (isset($_GET['sent'])) {
        $msg = lang("order_send_success");
        $message['kind'] = 1;
        $message['text'] = "$msg <i class=\"far fa-smile-wink\"></i>";
    }
}

if (isset($_GET['orders'])) {
    $orders = get_orders($_GET['orders']);
    if (isset($_GET['max'])) {
        $max = $_GET['max'];
    } else {
        $max = 15;
    }
    if (isset(get_orders($_GET['orders'])['orders'])) {
        $orders = get_orders($_GET['orders'])['orders'];
        echo "<h2 class='text-center'>" . lang('last orders') . "</h2><div class='orders row text-center mx-3'>";
        if (is_countable($orders)) {
            foreach ($orders as $order) {
                if ($max == 0) {
                    break;
                }
                $order_num = explode('.', $order)[0];
                $order_data = json_decode(file_get_contents(DATA_ROOT . 'orders/' . $_GET['orders'] . "/" . $order));
                if ($order_data->client->name != 'test') {
                    echo "
                <a href='?order=$order_num' class='order-card card col-md m-md-3 my-2'>
                    <h4>$order_num</h4>
                    <div>
                        <div>" . $order_data->date . "</div>
                        <div>" . $order_data->client->name . "</div>
                        <div>" . $order_data->client->phone . "</div>
                        <div>" . $order_data->client->address . "</div>
                        <div>$order_data->total $carrency</div>
                    </div>
                </a>";
                }
                $max--;
            }
        }
        echo "</div>";
        if (date("my") == $_GET['orders']) {
            $prev_month = date("my", strtotime(date('my') . " -1 month"));
            echo "<center class='m-4'><a class='btn btn-info' href='?orders=$prev_month'>" . lang("Previos Month") . "</a></center>";
        }
    } else {
        echo "<div class='text-center'>no order for " . $_GET['orders'] . " month!</div>";
    }
}

if (isset($_GET['add_c'])&&$_GET['add_p']) {
    $cart->add_to_cart($products_class->get_product($_GET['add_c'],$_GET['add_p']));
}

if (isset($_GET['clear_cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['update'])) {
    update_products_data();
}


