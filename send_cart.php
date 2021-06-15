<?php include_once('elements/layout/head.php'); ?>

<body class="d-flex flex-column h-100">
    <?php include_once('elements/layout/navigation.php'); ?>
    <main class="flex-shrink-0">
        <div class="container mt-5 mb-5">
            <?php if ($logedin) {
                include_once('elements/edit_company.php');
                include_once('elements/edit_category.php');
                include('elements/edit_product.php');
            }
            include_once('elements/login.php');
            include_once('elements/customer.php');
            include_once('functions/get.php');
            include_once('elements/message.php');
            if (isset($_POST['cart'])) {
                print_r($_POST['cart_products']) . "<br>";
                echo $_POST['cart_total'] . "<br>";
            } else {
                echo "no cart";
            }
            ?>
        </div>
    </main>

</body>

<?php include_once('elements/layout/footer.php'); ?>