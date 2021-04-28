<div class="container mt-5">
    <?php
    $categories = get_categories();
    $count = 0;
    foreach ($categories as $category) {
        $products = get_products($count);
        echo '<div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
            <h2 class="accordion-header border-bottom" id="flush-heading' . $count . '">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $count . '" aria-expanded="false" aria-controls="flush-collapse' . $count . '">
                ' . $category->name . '
                </button>
            </h2>
            <div id="flush-collapse' . $count . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $count . '" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
            <div class="row">';
        foreach ($products as $product) {
            echo '<div class="col-sm">';
            include('elements/card.php');
            echo '</div>';
        }
        if ($_SESSION['login']) {
            echo '<div class="col-sm">';
            include('elements/new_card.php');
            echo '</div>';
        }
        echo '</div></div></div></div>';
        $count++;
    }

    if (isset($_GET['add_product']) && $_GET['add_product'] != '' && isset($_GET['category']) && $_GET['category'] != '') {
        if ($_SESSION['login']) {
            $new = add_product($products, $product, '');
            save_json($new, 'categories');
        } else {
            echo 'please login';
        }
    }

    if (isset($_GET['add_category']) && $_GET['add_category'] != '') {
        if ($_SESSION['login']) {
            $new = add_category($categories, $_GET['add_category']);
            save_json($new, 'categories');
            echo 'save_category ok';
        } else {
            echo 'please login';
        }
    }

    if (isset($_GET['remove_category']) && $_GET['remove_category'] != '') {
        if ($_SESSION['login']) {
            $new = add_category($categories, $_GET['remove_category'], '1');
            save_json($new, 'categories');
            echo 'save_category ok';
        } else {
            echo 'please login';
        }
    }

    if (isset($_GET['login'])) {
        include_once('elements/login.php');
        login($_GET['login']);
    }

    if (isset($_GET['logout'])) {
        logout();
    }
    ?>
</div>