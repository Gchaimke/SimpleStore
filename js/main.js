
$('.edit-product').on('click', function () {
    var category = $(this).data("category");
    var product = $(this).data("product");
    $.post("post.php", { edit_product: true, category: category, product: product })
        .done(function (data) {
        });
});

$('.delete-product').on('click', function () {
    var category = $(this).data("category");
    var product = $(this).data("product");
    $.post("post.php", { delete_product: true, category: category, product: product })
        .done(function (data) {
            location.reload();
        });
});

$('.add-product').on('click', function () {
    var category = $(this).data("category");
    $.post("post.php", { add_product: true, category: category })
        .done(function (data) {
            location.reload();
        });
});
