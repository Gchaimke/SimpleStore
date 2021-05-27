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
    <?php endif ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <meta name="theme-color" content="#fafafa">
</head>

<body class="d-flex flex-column h-100">
    <?php include_once('navigation.php'); ?>
    <main class="flex-shrink-0">
        <div class="container mt-5 mb-5">
            <?php if ($logedin) {
                include_once('elements/statistic.php');
                include_once('elements/edit_company.php');
                include_once('elements/edit_category.php');
                include('elements/edit_product.php');
            ?>
                <input type="button" class="btn btn-outline-dark align-middle mb-3 mt-3" value="Edit Company" data-bs-toggle="modal" data-bs-target="#editCompany">
                <input type="button" class="btn btn-outline-dark align-middle category_editor_toggle mb-3 mt-3" value="New Category" data-bs-toggle="modal" data-bs-target="#categoryEditor">
            <?php } ?>
            <?php
            include_once('elements/login.php');
            include_once('elements/customer.php');
            include_once('functions/get.php');
            include_once('elements/message.php');
            include_once('elements/cities.php');
            echo "<div class='m-4'>$company->header</div>";
            include_once('elements/favorites.php');
            include_once('elements/search.php');
            include_once('elements/products.php');
            include_once('elements/cart.php');
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
    </script>
</body>

</html>