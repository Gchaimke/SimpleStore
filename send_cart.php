<?php
include_once('elements/layout/head.php');
include_once('elements/about.php');
?>

<body class="d-flex flex-column h-100">
    <?php include_once('elements/layout/navigation.php'); ?>
    <main class="flex-shrink-0">
        <div class="container mt-5 mb-5">
            <?php if ($logedin) {
                include_once('elements/edit_company.php');
                include_once('elements/edit_category.php');
            }
            include_once('elements/login.php');
            include_once('functions/get.php');
            if (isset($_POST['cart'])) {
                if (isset($_SESSION['cart'])) {
                    $total = $cart->get_total();
                    $order = save_order($_SESSION['cart'], $total, $_POST['client']);
                    $msg = lang("order_send_success");
                    $message['kind'] = 1;
                    $message['text'] = "$msg <a href='" . SP_SITE_ROOT . "?order=$order' id='order_sent'>$order</a> <i class=\"far fa-smile-wink\"></i>";
                    unset($_SESSION['cart']);
                } else {
                    echo "cart is empty";
                }
            } else {
                echo "no cart";
            }

            include_once('elements/message.php');
            ?>
        </div>
    </main>

</body>
<?php include_once('elements/layout/footer.php'); ?>