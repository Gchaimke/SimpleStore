$(document).ready(function () {
    $('.cart-send').hide();
});

$('.add-category').on('click', function () {
    var category_name = $('.category_editor').find('.category_editor-name').val();
    $.post("post.php", { add_category: true, category_name: category_name })
        .done(function () {
            setTimeout(function () {
                location.reload();
            }, 500);
        });
});

$('.delete-category').on('click', function () {
    var confim = confirm('Delete this category?');
    if (confim) {
        var category = $(this).data("category");
        $.post("post.php", { delete_category: true, category: category })
            .done(function () {
                setTimeout(function () {
                    location.reload();
                }, 500);
            });
    }
});

$('.edit-category').on('click', function () {
    $('.category_editor').find('.category_editor-name').val($(this).data("name"));
    $('.category_editor').find('.category_editor-id').val($(this).data("category"));
    $('.category_editor').find('.add-category').hide();
    $('.edit-category_btn').show();
    $('.category_editor').show();
});

$('.edit-category_btn').on('click', function () {
    var category_name = $('.category_editor').find('.category_editor-name').val();
    var category_index = $('.category_editor').find('.category_editor-id').val();
    $.post("post.php", { edit_category: true, category_name: category_name, category_index: category_index })
        .done(function () {
            setTimeout(function () {
                location.reload();
            }, 500);
        });
});

$('.add-product_toggle').on('click', function () {
    $('.edit_product_items').find('input').not(':button').val("");
    $('.edit_product_items').find('textarea').val("");
    $('.edit_product_items').find('#edit-category-id').val($(this).data("category"));
});

$('.edit-product').on('click', function () {
    $('.edit_product_items').find('#edit-product-id').val($(this).data("product"));
    $('.edit_product_items').find('#edit-category-id').val($(this).data("category"));
    $('.edit_product_items').find('.picture-url').val($(this).data("picture"));
    $('.edit_product_items').find('.product-name').val($(this).data("name"));
    $('.edit_product_items').find('.product-description').val($(this).data("description"));
    $('.edit_product_items').find('.product-price').val($(this).data("price"));
    $('.edit_product_items').find('.product-kind').val($(this).data("kind"));
    $('.edit_product_items').find('.upload_image_toggle').attr("data-name", $(this).data("name"));
});

$('.edit-product-btn').on('click', function () {
    var product = $('.edit_product_items').find('#edit-product-id').val();
    var category = $('.edit_product_items').find('#edit-category-id').val();
    var picture = $('.edit_product_items').find('.picture-url').val();
    var name = $('.edit_product_items').find('.product-name').val();
    var description = $('.edit_product_items').find('.product-description').val();
    var price = $('.edit_product_items').find('.product-price').val();
    var kind = $('.edit_product_items').find('.product-kind').val();
    $.post("post.php", { edit_product: true, category: category, product: product, picture: picture, name: name, description: description, price: price, kind: kind })
        .done(function () {
            setTimeout(function () {
                location.reload();
            }, 500);
        });
});

$('.duplicate-product').on('click', function () {
    var category = $(this).data("category");
    var product = $(this).data("product");
    $.post("post.php", { duplicate_product: true, category: category, product: product })
        .done(function () {
            setTimeout(function () {
                location.reload();
            }, 500);
        });
});

$('.product-to-cart').on('click', function () {
    var productId = $(this).data("product_id");
    var numItems = $('.cart-product').length
    var exists = $('.cart_items').find('[data-product_id=' + productId + ']').data('product_id');
    if (numItems < 10) {
        var product = $(this).data("product");
        var price = parseInt($(this).data("price"));
        var qty = $(this).data("qty");
        if (exists) {
            var current_price = $('.cart_items').find('[data-product_id=' + productId + ']>.cart_price');
            var current_qty = $('.cart_items').find('[data-product_id=' + productId + ']>.cart_qty');
            var current_total_qty = parseInt(current_qty.text().match(/\d+/)[0]) + parseInt(qty.match(/\d+/)[0])
            current_qty.text(current_total_qty + qty.slice(-2) + " ");
            var current_total_price = parseInt(current_price.text()) + price;
            $('.cart_items').find('[data-product_id=' + productId + ']>.remove-from-cart').attr("data-price", current_total_price);
            current_price.text(current_total_price);
        } else {
            $('.cart_items').append("<li data-product_id='" + productId + "'><span data-price='" + price +
                "' class='bg-danger remove-from-cart'>X</span><span class='cart-product'>" + product +
                " </span><span class='cart_qty'>" + qty +
                " </span><span class='cart_price'>" + price + "</span>ש\"ח</li>");
        }
        var total = parseInt($('.cart-total').text());
        $('.cart-total').text(total + price);
        $('.mobile-cart-total').text(total + price);
        splash_cart();
    } else {
        alert("Max cart items is 10!");
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
    var cart = "";
    $('.cart_items>li').each(function () {
        cart += $(this).find(".cart-product").text() + " " + $(this).find(".cart_qty").text() + "\n";
    })
    var total = "\n TOTAL:~" + $('.cart-total').text();
    if (cart != '') {
        var win = window.open(url + encodeURIComponent(cart + total), '_blank');
        if (win) {
            //Browser has allowed it to be opened
            cart_log(cart, $('.cart-total').text());
            win.focus();
        } else {
            //Browser has blocked it
            alert('Please allow popups for this website');
        }
    } else {
        alert('Cart is empty!');
    }

});

$(document).on('click', '.remove-from-cart', function () {
    var price = parseInt($(this).data("price"));
    var total = parseInt($('.cart-total').text());
    $('.cart-total').text(total - price);
    $('.mobile-cart-total').text(total - price);
    $(this).parent().remove();
});

$('.delete-product').on('click', function () {
    var confim = confirm('Delete this product?');
    if (confim) {
        var category = $(this).data("category");
        var product = $(this).data("product");
        $.post("post.php", { delete_product: true, category: category, product: product })
            .done(function () {
                setTimeout(function () {
                    location.reload();
                }, 500);
            });
    }
});

$('.delete-gallery-image').on('click', function () {
    var confim = confirm('Delete this picture?');
    if (confim) {
        var image = $(this).data("path");
        $.post("post.php", { delete_gallery_image: true, image: image })
            .done(function (e) {
                alert(e);
            });
        $(this).parent().parent().toggle();

    }
});


$('.get_form_url').on('click', function () {
    var name = $(this).parent().find('.upload_image_name').val();
    var url = $(this).parent().find('.upload_image_url').val();
    $.post("post.php", { get_form_url: true, url: url, name: name })
        .done(function (e) {
            $(document).find('.picture-url').val('img/products/' + e);
            alert(e + " uploaded!");
            $('.gallery_upload').hide();
        });
});

$('.upload_btn').on('click', function () {
    var fd = new FormData();
    var files = $('#imagefile')[0].files;
    var name = $('.upload_image_name').val();
    if (files.length > 0 && name != "") {
        fd.append('file', files[0]);
        fd.append('name', name);
        $.ajax({
            url: 'post.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != "Error") {
                    alert(response);
                    $(document).find('.picture-url').val('img/products/' + response);
                    $('.gallery_upload').hide();
                } else {
                    alert('file not uploaded');
                }
            },
        });
    } else {
        alert("Please select a file and set name!");
    }
});

function cart_log(cart, total) {
    $.post("post.php", { cart_log: true, cart: cart, total: total })
        .done(function (e) {
            console.log(e);
        });
}

function splash_cart() {
    $('.cart').css('background', '#acf5a7');
    $('.cart').css('transition-duration', '150ms');
    setTimeout(function () {
        $('.cart').css('background', 'white');
    }, 300);
}

$('.gallery_image .image').on('click', function () {
    $image_path = $(this).data('path');
    $('.picture-url').val($image_path);
    $('.gallery_view').toggle();
});

$('.select_image_toggle').on('click', function () {
    $('.gallery_view').toggle();
});

$('.upload_image_toggle').on('click', function () {
    $('.gallery_upload').toggle();
    $('.upload_image_name').val($(this).data('name'));
});

$('.category_editor_toggle').on('click', function () {
    $('.category_editor').find('.category_editor-name').val("");
});

$('.close-parent').on('click', function () {
    $(this).parent().toggle();
});

