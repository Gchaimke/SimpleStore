let is_whatsapp = false;
var carrency = '';
$(document).ready(function () {
    $('.cart-send-whatsapp').hide();
    $('.cart-send-email').hide();

    $('.card-title, .card-text').each(function () {
        var text_length = $(this).text().length;
        var have_text = $(this).parent().find('.card-text')
        if (have_text.text().length > 10) {
            if (text_length > 14) {
                $(this).css({ 'font-size': "1rem" });
            }
            if (text_length > 20) {
                $(this).css({ 'font-size': "0.9rem", "line-height": "12px" });
            }
            if (text_length > 22) {
                $(this).css({ 'font-size': "0.8rem", "line-height": "12px" });
            }
        } else {
            if (text_length > 14) {
                $(this).css({ 'font-size': "1rem" });
                have_text.css({ "min-height": "20px" });
            }
            if (text_length > 30) {
                $(this).css({ 'font-size': "0.9rem", "line-height": "16px" });
            }
        }
    });

    if ($(".statistic").length) {
        get_stasts();
    }
});

function get_stasts() {
    $.post("post.php", { get_stats: true })
        .done(function (e) {
            setTimeout(function () {
                var obj = JSON.parse(e);
                $(".statistic").find("#stats_orders").text(obj.count);
                $(".statistic").find("#stats_total").text(obj.total);
            }, 2000);
        });
}

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
    $('.edit_product_items').find('.picture-url').val($(this).data("img"));
    $('.edit_product_items').find('.product-name').val($(this).data("name"));
    $('.edit_product_items').find('.product-description').val($(this).data("description"));
    $('.edit_product_items').find('.product-price').val($(this).data("price"));
    $('.edit_product_items').find('.product-qtty').val($(this).data("qtty"));
    $('.edit_product_items').find('.product-kind').val($(this).data("kind"));
    $('.edit_product_items').find('.upload_image_toggle').attr("data-name", $(this).data("name"));
});

$('.edit-product-btn').on('click', function () {
    var product_id = $('.edit_product_items').find('#edit-product-id').val();
    var category = $('.edit_product_items').find('#edit-category-id').val();
    var img = $('.edit_product_items').find('.picture-url').val();
    var name = $('.edit_product_items').find('.product-name').val();
    var description = $('.edit_product_items').find('.product-description').val();
    var price = $('.edit_product_items').find('.product-price').val();
    var qtty = $('.edit_product_items').find('.product-qtty').val();
    var kind = $('.edit_product_items').find('.product-kind').val();
    $.post("post.php", { edit_product: true, category: category, product_id: product_id, img: img, name: name, description: description, price: price, kind: kind, qtty: qtty })
        .done(function (e) {
            console.log(e)
            setTimeout(function () {
                location.reload();
            }, 500);
        });
});

$(document).on('click', '.duplicate-product', function () {
    var category = $(this).data("category");
    var product = $(this).data("product");
    $.post("post.php", { duplicate_product: true, category: category, product: product })
        .done(function (e) {
            console.log(e)
            setTimeout(function () {
                location.reload();
            }, 500);
        });
});

$(document).on('click', '.favorite-product', function () {
    var category = $(this).data("category");
    var product = $(this).data("product");
    $.post("post.php", { favorite_product: true, category: category, product: product })
        .done(function (e) {
            console.log(e)
            setTimeout(function () {
                location.reload();
            }, 500);
        });
});

$(document).on('click', '.plus', function () {
    var productId = $(this).parent().data("product_id");
    var product_name = $('.cart_items').find('[data-product_id=' + productId + '] .cart-product').text();
    var price = parseInt($(this).parent().data("price"));
    var qty = $(this).parent().data("qty");
    var kind = $(this).parent().data("kind");
    sum_cart_product(productId, product_name, price, qty, kind);
    update_cart_total(price);
});

$(document).on('click', '.minus', function () {
    var productId = $(this).parent().data("product_id");
    var product_name = $('.cart_items').find('[data-product_id=' + productId + '] .cart-product').text();
    var price = 0 - parseInt($(this).parent().data("price"));
    var qty = $(this).parent().data("qty");
    var kind = $(this).parent().data("kind");
    var minus_qty = 0 - parseInt(qty)
    var updated = sum_cart_product(productId, product_name, price, minus_qty, kind);
    update_cart_total(price);
    if (updated <= 0) {
        remove_cookie("items[" + productId + "]");
        $('.cart_items').find('li[data-product_id=' + productId + ']').remove();
    };

});

$(document).on('click', '.product-to-cart', function () {
    var productId = $(this).data("product_id");
    var numItems = $('.cart-product').length
    var exists = $('.cart_items').find('[data-product_id=' + productId + ']').data('product_id');
    if (!is_whatsapp || numItems < 10) {
        var product_name = $(this).data("product");
        var price = parseInt($(this).data("price"));
        var qty = $(this).data("qty");
        var kind = $(this).data("kind");
        if (exists) {
            sum_cart_product(productId, product_name, price, qty, kind);
        } else {
            add_cart_product(productId, product_name, price, qty, kind)
        }
        update_cart_total(price);
    } else {
        alert("Max cart items is 10!");
    }
});

function add_cart_product(productId, product_name, price, qty, kind, restore = 0) {
    set_cookie("items[" + productId + "]", [product_name, price, qty, kind].join());
    var cart_item = "<li data-product_id='" + productId + "'><span data-price='" + price +
        "' class='bg-danger remove-from-cart'>X</span><span class='cart-product mx-2'>" + product_name +
        "</span><span class='cart_qty'>" + qty + "</span><span class='cart_kind me-1'>" + kind + "</span><span class='cart_price'>" + price + "</span>" + carrency;
    if (restore == 1) {
        price = price / parseInt(qty);
    }
    $('.cart_items').append(cart_item +
        "<div class='cart-controls text-nowrap mb-2 text-center' data-price='" + price + "' data-qty='" + qty + "' data-kind='" + kind + "' data-product_id='" + productId + "'>" +
        "<span class='btn btn-warning ml-2 minus'>-</span><b class='m-2'>1</b><span class='btn btn-success plus'>+</span></div><hr></li>");
}

function restore_cart(id, data) {
    data = data.replace(/["\\]/g, '');
    item = data.split(",");
    var product_name = item[0];
    var price = item[1];
    var qty = item[2];
    var kind = item[3];
    if (price != 0 && qty != 0) {
        add_cart_product(id, product_name, price, qty, kind, 1);
    } else {
        remove_cookie("items[" + id + "]");
    }
}

function sum_cart_product(productId, product_name, price, qty, kind) {
    if (!Number.isInteger(qty)) {
        qty = parseInt(qty.match(/\d+/)[0]);
    }
    var current_price = $('.cart_items').find('[data-product_id=' + productId + ']>.cart_price');
    var current_qty = $('.cart_items').find('[data-product_id=' + productId + ']>.cart_qty');
    var current_total_qty = parseInt(current_qty.text()) + qty;
    current_qty.text(current_total_qty);
    var current_total_price = parseInt(current_price.text()) + price;
    $('.cart_items').find('[data-product_id=' + productId + ']>.remove-from-cart').attr("data-price", current_total_price);
    set_cookie("items[" + productId + "]", [product_name, current_total_price, current_total_qty, kind].join());
    current_price.text(current_total_price);
    return current_total_price;
}

function update_cart_total(price) {
    var total = parseInt($('.cart-total').text()) + price;
    if (total < 0) {
        total = 0;
    }
    $('.cart-total').text(total);
    $('.mobile-cart-total').text(total);
    set_cookie("total", total);
    splash_cart();
}

$(document).on('click', '.remove-from-cart', function () {
    var price = parseInt($(this).data("price"));
    update_cart_total(0 - price);
    var productId = $(this).parent().data("product_id");
    remove_cookie("items[" + productId + "]");
    $(this).parent().remove();
});

$('#clear-cart').on('click', function () {
    var confim = confirm('Clear cart?');
    if (confim) {
        clear_cart();
    }
});

function clear_cart() {
    $('.cart_items').find('li').each(function () {
        $(this).remove();
    })
    $('.cart-total').text(0);
    $('.mobile-cart-total').text(0);
    $('.close-cart').trigger("click");
    clear_cookies();
}

function set_cookie(name, data) {
    $.post("post.php", { set_cookie: true, name: name, data: data })
        .done(function (e) {
            //console.log(e);
        });
}

function remove_cookie(name) {
    $.post("post.php", { remove_cookie: true, name: name })
        .done(function (e) {
            //console.log(e);
        });
}

function clear_cookies() {
    $.post("post.php", { remove_all_cookie: true })
        .done(function (e) {
            //console.log(e);
        });
}


$('.cart_header, .close-cart').on('click', function () {
    $('.cart-wraper').toggle();
    $('.close-cart').toggle();
    $('#clear-cart').toggle();
    if (is_whatsapp) {
        $('.cart-send-whatsapp').toggle();
    }
    $('.cart-send-email').toggle();
});

$('.cart-send-whatsapp').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr("href");
    var msg = "";
    let cart = {};
    let client = [];
    $('.cart_items>li').each(function () {
        msg += $(this).find(".cart-product").text() + " " + $(this).find(".cart_qty").text() + "\n ";
        cart[$(this).data('product_id')] = $(this).find(".cart-product").text() + "," + $(this).find(".cart_qty").text() + "," + $(this).find(".cart_price").text();
    })
    var total = "\n TOTAL:~" + $('.cart-total').text();
    if (msg != '') {
        var win = window.open(url + encodeURIComponent(msg + total), '_blank');
        if (win) {
            var total = $('.cart-total').text();
            clear_cart();
            //Browser has allowed it to be opened
            $.post("post.php", { save_cart: true, cart: cart, total: total, client: client })
                .done(function (e) {
                    location.replace(location.protocol + '//' + location.host + location.pathname + "?order=" + e + "&sent");
                });
            win.focus();
        } else {
            //Browser has blocked it
            alert('Please allow popups for this website');
        }
    } else {
        alert('Cart is empty!');
    }
});


$('.cart-send-email').on('click', function () {
    let cart = {};
    let client = [];
    $('.cart_items>li').each(function () {
        cart[$(this).data('product_id')] = $(this).find(".cart-product").text() + "," + $(this).find(".cart_qty").text() + "," + $(this).find(".cart_price").text();
    });
    if (!$.isEmptyObject(cart)) {
        $('#client_data').modal('show');
        $("#client_form").on("submit", function (out) {
            out.preventDefault();
            $('.close, .btn-close, .send').prop('disabled', true);
            $('.spinner-border').toggle();
            client = $('#client_form').serializeArray();
            var data = {};
            $(client).each(function (index, obj) {
                data[obj.name] = obj.value;
            });
            var total = $('.cart-total').text();
            clear_cart();
            $.post("post.php", { save_cart: true, cart: cart, total: total, client: data })
                .done(function (e) {
                    location.replace(location.protocol + '//' + location.host + location.pathname + "?order=" + e + "&sent");
                });
        });
    } else {
        alert('Cart is empty!');
    }
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

$('#update_stats').on('click', function () {
    $('.spinner_status').toggle();
    $(this).prop('disabled', true);
    $.post("post.php", { update_stats: true })
        .done(function (e) {
            get_stasts();
            alert(e);
        });
    $('.spinner_status').toggle();
    $(this).prop('disabled', false);
});

$('#search').on('submit', function (e) {
    e.preventDefault();
    var search = $("#search_text").val();
    search = search.toLowerCase();
    search = search.replace(/ /g, '');
    search = search.substring(1);
    $.post("post.php", { search: search })
        .done(function (res) {
            $("#search_result").empty();
            var products = res.split(",");
            products.forEach(function (value) {
                if (value != "") {
                    $("#" + value).clone().appendTo("#search_result");
                }
            })
        });
});

$('.lang-ru').on('click', function () { change_language("ru") });
$('.lang-he').on('click', function () { change_language("he") });

function change_language(language) {
    $.post("post.php", { set_lang: true, language: language })
        .done(function (e) {
            //alert(e);
            location.reload();
        });
}

//jQuery Slider
if ($("#favorites_slider").length) {
    $('#favorites_slider').multislider({
        duration: 0,
        interval: 5000
    });
}

//Cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}