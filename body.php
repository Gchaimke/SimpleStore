<div class="container mt-5">
    <?php
    if (isset($_SESSION['login']) && $_SESSION['login']) {
        $logedin = true;
    } else {
        $logedin = false;
    }
    $categories = get_categories();
    $category_num = 0;
    foreach ($categories as $category) {
        $products = get_products($category_num);
        echo '<div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
            <h2 class="accordion-header border-bottom" id="flush-heading' . $category_num . '">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $category_num . '" aria-expanded="false" aria-controls="flush-collapse' . $category_num . '">
                ' . $category->name . '
                </button>
            </h2>
            <div id="flush-collapse' . $category_num . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $category_num . '" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
            <div class="row">';
        $product_num = 0;
        foreach ($products as $product) {
            echo '<div class="col-sm" >';
            include('elements/card.php');
            echo '</div>';
            $product_num++;
        }
        if ($logedin) {
            echo '<div class="col-sm">';
            include('elements/new_card.php');
            echo '</div>';
        }
        echo '</div></div></div></div>';
        $category_num++;
    }

    if (isset($_GET['add_product']) && $_GET['add_product'] != '' && isset($_GET['category']) && $_GET['category'] != '') {
        if ($logedin) {
            $new = add_product($products, $product, '');
            save_json($new, 'categories');
        } else {
            echo 'please login';
        }
    }

    if (isset($_GET['add_category']) && $_GET['add_category'] != '') {
        if ($logedin) {
            $new = add_category($categories, $_GET['add_category']);
            save_json($new, 'categories');
            echo 'save_category ok';
        } else {
            echo 'please login';
        }
    }

    if (isset($_GET['remove_category']) && $_GET['remove_category'] != '') {
        if ($logedin) {
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