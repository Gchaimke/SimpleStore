<?php
include_once('elements/layout/head.php');
?>

<body class="d-flex flex-column h-100">
    <?php include_once('elements/layout/navigation.php'); ?>
    <main class="flex-shrink-0">
        <div class="container mt-5 mb-5">
            <?php
            include_once('functions/get.php');
            include_once('elements/cart.php');
            include_once('elements/message.php');
            //include_once('elements/test.php');
            if ($logedin) {
                include_once('elements/edit_company.php');
                include_once('elements/edit_category.php');
                include('elements/edit_product.php');
                include_once('elements/search_order.php');
            }
            echo "<div class='container'>$company->header</div>";
            include_once('elements/favorites.php');
            include_once('elements/search.php');
            include_once('elements/products.php');
            include_once('elements/login.php');
            include_once('elements/customer.php');
            include_once('elements/about.php');
            //echo $cart->get_total()."<br>";
            //print_r($_SESSION['cart']);
            ?>
        </div>
    </main>

</body>

<?php include_once('elements/layout/footer.php'); ?>
<script>
    $(document).ready(function() {
        carrency = "<?= $carrency ?>";
        var previos_cart = <?php echo json_encode($previos_cart, JSON_UNESCAPED_UNICODE); ?>;
        var previos_total = <?= $previos_total ?>;
        if (previos_cart != "") {
            console.log(previos_cart);
            $.each(previos_cart, function(index, value) {
                restore_cart(index, value);
            });
            update_cart_total(parseInt(previos_total));
        }
    });
</script>

</html>