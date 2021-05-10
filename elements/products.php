<?php

$categories = get_categories();
echo "<div class='mb-4'>$company->header</div>";
foreach ($categories as $category) {
    $products = get_products($category->id);
    echo '<div class="accordion accordion-flush" id="accordionFlush">
            <div class="accordion-item">';
    if ($logedin) {
        echo '<i class="far fa-edit edit-category" data-category="' . $category->id . '" data-name="' . $category->name . '"  data-bs-toggle="modal" data-bs-target="#categoryEditor"></i>';
    }
    echo   '<h2 class="accordion-header border-bottom" id="flush-heading' . $category->id . '">
                <button class="accordion-button collapsed" type="button" id="btn_' . $category->id . '" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $category->id . '" aria-expanded="false" aria-controls="flush-collapse' . $category->id . '">
                ' . $category->name . '
                </button>
            </h2>
            <div id="flush-collapse' . $category->id . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $category->id . '" data-bs-parent="#accordionFlush">
            ';
    if ($logedin) {
        echo '<button type="button" class="btn btn-outline-dark align-middle add-product_toggle mt-md-4 float-end mb-md-4" data-category="' . $category->id . '" data-bs-toggle="modal" data-bs-target="#edit_product">
        <i class="far fa-plus-square" style="font-size: 2em;"></i></button>';
    }
    echo '<div class="accordion-body"><div class="row">';
    $product_num = 0;
    foreach ($products as $product) {
        echo '<div class="col-sm" >';
        include('elements/card.php');
        echo '</div>';
        $product_num++;
    }

    echo '</div></div></div></div>';
    if ($logedin) {
        echo "<i class='far fa-trash-alt delete-category' data-category='$category->id '></i>";
    }
}
