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
    ?>
</div>