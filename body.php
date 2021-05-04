
<?php if ($logedin) {
    include('elements/edit_company.php');
    include('elements/new_category.php');
    include('elements/uploader.php');
}
$categories = get_categories();
$category_num = 0;
echo "<div class='mb-4'>$company->header</div>";
foreach ($categories as $category) {
    $products = get_products($category_num);
    echo '<div class="accordion accordion-flush" id="accordionFlush">
            <div class="accordion-item">';
    if ($logedin) {
        echo '<i class="far fa-edit edit-category" data-category="' . $category_num . '" data-name="' . $category->name . '"></i>';
    }
    echo   '<h2 class="accordion-header border-bottom" id="flush-heading' . $category_num . '">
                <button class="accordion-button collapsed" type="button" id="btn_' . $category_num . '" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $category_num . '" aria-expanded="false" aria-controls="flush-collapse' . $category_num . '">
                ' . $category->name . '
                </button>
            </h2>
            <div id="flush-collapse' . $category_num . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $category_num . '" data-bs-parent="#accordionFlush">
            ';
    if ($logedin) {
        echo '<button type="button" class="btn btn-outline-dark align-middle add-product_toggle mt-md-4 float-end mb-md-4" data-category="' . $category_num . '">
        <i class="far fa-plus-square" style="font-size: 2em;"></i></button>';
        include('elements/new_card.php');
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
        echo "<i class='far fa-trash-alt delete-category' data-category='$category_num '></i>";
    }
    $category_num++;
}
if ($logedin) {
    include('elements/edit_card.php');
}
?>