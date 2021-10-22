<?php

if (isset($_GET['lang'])) {
    echo "<script> document.cookie = 'language = {$_GET['lang']};expires=365;path=/'; window.location.href ='" . SITE_ROOT . "'</script>";
}

if (isset($_GET['email_order'])) {
    send_email($_GET['email_order']);
}

if (isset($_GET['csv'])) {
    export_csv();
}

if (isset($_GET['order'])) {
    $hidden = '';
    $orders['prev_month'] = "";
    $order = order_to_html($_GET['order']);
    $prev_month = date("my", strtotime(date('my') . " -1 month"));
    if ($logedin) {
        $order .= order_client_to_html($_GET['order']);
        $order_num = explode("-", $_GET['order']);
        if (count($order_num) > 1 && get_orders($order_num[0])) {
            $orders['this_month'] = get_orders($order_num[0])['orders'];
            if (get_orders($prev_month)) {
                $orders['prev_month'] = get_orders($prev_month)['orders'];
            }
            $next = $order_num[0] . "-" . add_zero(intval($order_num[1]) + 1);

            if (intval($order_num[1]) == 1 && $orders['prev_month']!="") {
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
    extract($_GET);
    ob_start();
    include(__DIR__ . '/../elements/orders.php');
    $output = ob_get_clean();
    print $output;
}

if (isset($_GET['add_c']) && $_GET['add_p']) {
    $cart->add_to_cart($store->product->get_product($_GET['add_c'], $_GET['add_p']));
}

if (isset($_GET['clear_cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['update'])) {
    update_products_data();
}
