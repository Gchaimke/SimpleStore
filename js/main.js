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
            setTimeout(function () {
                location.reload();
            }, 1500);
        }
    });
});

$('.add-category').on('click', function () {
    var category_name = $(this).parent('.new-category').find('.new-category-name').val();
    $.post("post.php", { add_category: true, category_name: category_name })
        .done(function () {
            setTimeout(function () {
                location.reload();
            }, 1500);
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
                }, 1500);
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
            setTimeout(function () {
                location.reload();
            }, 1500);
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
            setTimeout(function () {
                location.reload();
            }, 1500);
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
    $('.edit-product-card').find('.upload_image_toggle').attr("data-name", $(this).data("name"));
    $('.edit-product-card').toggle();
});

$('.duplicate-product').on('click', function () {
    var category = $(this).data("category");
    var product = $(this).data("product");
    $.post("post.php", { duplicate_product: true, category: category, product: product })
        .done(function () {
            setTimeout(function () {
                location.reload();
            }, 1000);
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
                " </span><span class='cart_qty'> " + qty +
                " </span><span class='cart_price'>" + price + "</span>ש\"ח</li>");
        }
        var total = parseInt($('.cart-total').text());
        $('.cart-total').text(total + price);
        $('.mobile-cart-total').text(total + price);
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
    var text = "";
    $('.cart_items>li').each(function () {
        text += $(this).find(".cart-product").text() +" "+ $(this).find(".cart_qty").text()+"\n";
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
            setTimeout(function () {
                location.reload();
            }, 1500);
        });
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
                }, 1500);
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
            //$('.edit-product-btn').trigger("click");
            //location.reload();
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

$('.close-parent').on('click', function () {
    $(this).parent().toggle();
});

