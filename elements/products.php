<?php
if (is_iterable($categories)) {
    foreach ($categories as $category) {
        $products = $category->products;
        echo '<div class="accordion accordion-flush" id="accordionFlush">
                <div class="accordion-item">';
        if ($logedin) {
            echo '<i class="far fa-edit edit-category" data-category="' . $category->id . '" data-name="' . $category->name . '"  data-bs-toggle="modal" data-bs-target="#categoryEditor"></i>';
            echo "<i class='far fa-trash-alt delete-category' data-category='$category->id '></i>";
            echo '<i class="far fa-plus-square float-end add-product_toggle" data-category="' . $category->id . '" data-bs-toggle="modal" data-bs-target="#edit_product"></i>';
        }
        echo   '<h2 class="accordion-header border-bottom" id="flush-heading' . $category->id . '">
                <button class="accordion-button collapsed" type="button" id="btn_' . $category->id . '" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $category->id . '" aria-expanded="false" aria-controls="flush-collapse' . $category->id . '">
                ' . $category->name . '
                </button>
            </h2>
            <div id="flush-collapse' . $category->id . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $category->id . '" data-bs-parent="#accordionFlush">
            ';
        echo '<div class="accordion-body"><div class="row">';
        $product_num = 0;
        if (is_iterable($products)) {
            foreach ($products as $product) {
                if (!isset($product->id)) {
                    $product->id = $product_num;
                }
                $product_cart_id = $category->id . '_' . $product->id;
                echo "<div class='col' id='$product_cart_id'>";
                include('elements/card.php');
                echo '</div>';
                $product_num++;
            }
        }
        echo '</div></div></div></div>';
    }
} else {
    echo 'No Categories';
}
