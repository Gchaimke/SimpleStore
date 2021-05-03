$(document).ready(function () {
    $('.cart-send').hide();
});
$('#edit_company').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: 'post.php',
        data: $('#edit_company').serialize(),
        success: function (res) {
            alert(res);
            location.reload();
        }
    });
});

$('.add-category').on('click', function () {
    var category_name = $(this).parent('.new-category').find('.new-category-name').val();
    $.post("post.php", { add_category: true, category_name: category_name })
        .done(function () {
            location.reload();
        });
});

$('.delete-category').on('click', function () {
    var confim = confirm('Delete this category?');
    if (confim) {
        var category = $(this).data("category");
        $.post("post.php", { delete_category: true, category: category })
            .done(function () {
                location.reload();
            });
    }
});

$('.edit-category').on('click', function () {
    $('.new-category').find('.new-category-name').val($(this).data("name"));
    $('.new-category').find('.new-category-id').val($(this).data("category"));
    $('.new-category').find('.add-category').hide();
    $('.edit-category_btn').show();
    $('.new-category').show();
});

$('.edit-category_btn').on('click', function () {
    var category_name = $(this).parent('.new-category').find('.new-category-name').val();
    var category_index = $(this).parent('.new-category').find('.new-category-id').val();
    $.post("post.php", { edit_category: true, category_name: category_name, category_index: category_index })
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

$('.duplicate-product').on('click', function () {
    var category = $(this).data("category");
    var product = $(this).data("product");
    $.post("post.php", { duplicate_product: true, category: category, product: product })
        .done(function () {
            location.reload();
        });
});

$('.product-to-cart').on('click', function () {
    var numItems = $('.cart-product').length
    if (numItems < 10) {
        var product = $(this).data("product");
        var price = parseInt($(this).data("price"));
        $('.cart_items').append("<li><span data-price='" + price + "' class='bg-danger remove-from-cart'>X</span><span class='cart-product'>" + product + "</span> " + price + " ש\"ח</li>");
        var total = parseInt($('.cart-total').text());
        $('.cart-total').text(total + price);
        $('.mobile-cart-total').text(total + price);
    }else{
        alert ("Max cart items is 10!");
    }
});

$('.cart_header, .close-cart').on('click', function () {
        $('.cart_items').toggle();
        $('.close-cart').toggle();
        $('.cart-send').toggle();   
});

$('.cart-send').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr("href");
    var text = "";
    $('.cart-product').each(function () {
        text += $(this).text() + "\n";
    })
    text += "\n TOTAL:" + $('.cart-total').text() + "\n";
    var win = window.open(url + encodeURIComponent(text), '_blank');
    if (win) {
        //Browser has allowed it to be opened
        win.focus();
    } else {
        //Browser has blocked it
        alert('Please allow popups for this website');
    }
});

$(document).on('click', '.remove-from-cart', function () {
    var price = parseInt($(this).data("price"));
    var total = parseInt($('.cart-total').text());
    $('.cart-total').text(total - price);
    $('.mobile-cart-total').text(total - price);
    $(this).parent().remove();
});

$('.edit-product-btn').on('click', function () {
    var product = $(this).parent('.card-body').find('#edit-product-id').val();
    var category = $(this).parent('.card-body').find('#edit-category-id').val();
    var picture = $(this).parent('.card-body').find('.picture-url').val();
    var name = $(this).parent('.card-body').find('.product-name').val();
    var description = $(this).parent('.card-body').find('.product-description').val();
    var price = $(this).parent('.card-body').find('.product-price').val();
    var kind = $(this).parent('.card-body').find('.product-kind').val();
    $.post("post.php", { edit_product: true, category: category, product: product, picture: picture, name: name, description: description, price: price, kind: kind })
        .done(function () {
            location.reload();
        });
});

$('.delete-product').on('click', function () {
    var confim = confirm('Delete this product?');
    if (confim) {
        var category = $(this).data("category");
        var product = $(this).data("product");
        $.post("post.php", { delete_product: true, category: category, product: product })
            .done(function () {
                location.reload();
            });
    }
});


$('.add-product_toggle').on('click', function () {
    $('.new-product').toggle();
});

$('.close-edit-product').on('click', function () {
    $('.edit-product-card').toggle();
});

$('#edit_company_toggle, .edit-company-close').on('click', function () {
    $('#edit_company').toggle();
});

$('.add-category-close, .new-category_toggle').on('click', function () {
    $(this).parent('.new-category').find('.new-category-name').val("");
    $('.new-category').toggle();
});

