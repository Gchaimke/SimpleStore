<?php
include_once('elements/layout/head.php');
include_once('functions/post.php');
?>

<body class="d-flex flex-column h-100">
    <?php include_once('elements/layout/navigation.php'); ?>
    <main class="flex-shrink-0">
        <div class="container mt-5 mb-5">
            <?php
            include_once('functions/get.php');
            include_once('elements/cart.php');
            include_once('elements/message.php');
            //include_once('elements/html_test.php');
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
            //debug($_SESSION['cart']);
            $cart->view_cart();
            ?>
        </div>
    </main>

</body>
<script>
    var cart_opened = <?= isset($_GET['cart']) ? "1" : "0"; ?>;
</script>
<?php include_once('elements/layout/footer.php'); ?>

</html>