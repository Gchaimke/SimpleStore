<?php
session_start();
include_once('functions/helper.php');
include_once('elements/about.php');
?>
<!doctype html>
<html class="no-js h-100" lang=<?= $lng ?>>

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="stylesheet" href="<?= auto_version('css/normalize.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= auto_version('css/main.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= auto_version('css/style.css') ?>" type="text/css">
    <?php if ($lng == "he") : ?>
        <link rel="stylesheet" href="<?= auto_version('css/rtl.css') ?>" type="text/css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.rtl.min.css" integrity="sha384-LPvXVVAlyPoBSGkX8UddpctDks+1P4HG8MhT7/YwqHtJ40bstjzCqjj+VVVDhsCo" crossorigin="anonymous">
    <?php endif ?>

    <?php if ($lng != "he") : ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <?php endif ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <meta name="theme-color" content="#fafafa">
</head>

<body class="d-flex flex-column h-100">
    <?php include_once('elements/navigation.php'); ?>
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
            include_once('elements/cart.php');
            include_once('elements/message.php');
            //include_once('elements/test.php');
            echo "<div class='container'>$company->header</div>";
            include_once('elements/favorites.php');
            include_once('elements/search.php');
            include_once('elements/products.php');
            ?>
        </div>
    </main>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted"><?php lang() ?><a href="mailto:gchaimke@mail.com">Chaim Gorbov</a></span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="js/vendor/multislider.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="<?= auto_version('js/main.js') ?>"></script>
    <script src="https://www.google-analytics.com/analytics.js" async></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script>
        $('#login_btn').on('click', function() {
            var pass = $('#login-pass').val();
            window.location.href = '<?= SITE_ROOT ?>?login=' + pass;
        });
        $(document).ready(function() {
            carrency = "<?= $carrency ?>";
            var previos_cart = <?php echo json_encode($previos_cart,JSON_UNESCAPED_UNICODE); ?>;
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
</body>

</html>