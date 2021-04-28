<div class="container mt-5">
    <?php
    $categories = get_categories();
    $count = 0;
    foreach ($categories as $category) {
        $products = get_products($category->products);
        echo '<div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading' . $count . '">
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
        echo '</div></div></div></div>';
        $count++;
    }
    //save_json(json_encode($categories),'new_cat');
    ?>
</div>