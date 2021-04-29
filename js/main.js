
$('.edit-product').on('click', function () {
    $('.edit-product-card').find('#edit-product-id').val($(this).data("product"));
    $('.edit-product-card').find('#edit-category-id').val($(this).data("category"));
    $('.edit-product-card').find('.picture-url').val($(this).data("picture"));
    $('.edit-product-card').find('.product-name').val($(this).data("name"));
    $('.edit-product-card').find('.product-description').val($(this).data("description"));
    $('.edit-product-card').find('.product-price').val($(this).data("price"));
    $('.edit-product-card').find('.product-kind').val($(this).data("kind"));
    $('.edit-product-card').toggle();
});

$('.edit-product-btn').on('click', function () {
    $('.edit-product-card').toggle();
    $.post("post.php", { edit_product: true, category: category, product: product })
        .done(function () {
            location.reload();
        });
});

$('.delete-product').on('click', function () {
    var category = $(this).data("category");
    var product = $(this).data("product");
    $.post("post.php", { delete_product: true, category: category, product: product })
        .done(function () {
            location.reload();
        });
});

$('.add-product').on('click', function () {
    var category = $(this).data("category");
    var picture = $(this).parent('.card-body').find('.picture-url').val();
    var name = $(this).parent('.card-body').find('.product-name').val();
    var description = $(this).parent('.card-body').find('.product-description').val();
    var price = $(this).parent('.card-body').find('.product-price').val();
    var kind = $(this).parent('.card-body').find('.product-kind').val();
    $.post("post.php", { add_product: true, category: category, picture: picture, name: name, description: description, price: price, kind: kind })
        .done(function () {
            location.reload();
        });

});

$('.add-product_toggle').on('click', function () {
    $('.new-product').toggle();
})



