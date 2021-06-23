<?php

if (isset($_GET['login'])) {
    if ($_GET['login'] != '') {
        $login = login($_GET['login']);
    }
}

if (isset($_GET['login_error'])) {
    $message['kind'] = 3;
    $message['text'] = lang("password_error");
}

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
    $order = order_to_html($_GET['order']);
    if ($logedin) {
        $order .= order_client_to_html($_GET['order']);
        $order_num = explode("-", $_GET['order']);
        $next = $order_num[0] . "-" . add_zero(intval($order_num[1]) + 1);
        $prev = $order_num[0] . "-" . add_zero(intval($order_num[1]) - 1);
        $order .= "<div id='order_controls'><a href='?order=$prev'>Previos</a><a href='?order=$next'>Next</a></div>";
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
    if(isset($_GET['max'])){
        $max = $_GET['max'];
    }else{
        $max = 15;
    }
    if (isset(get_orders($_GET['orders'])['orders'])) {
        $orders = get_orders($_GET['orders'])['orders'];
        echo "<div class='orders row text-center mx-3'>";
        foreach ($orders as $order) {
            if($max == 0){
                break;
            }
            $order_num = explode('.', $order)[0];
            $order_data = json_decode(file_get_contents(DOC_ROOT . 'data/orders/' . $_GET['orders'] . "/" . $order));
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
        echo "</div>";
    } else {
        echo "<div class='text-center'>no order for " . $_GET['orders'] . " month!</div>";
    }
}
