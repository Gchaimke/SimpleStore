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
        let month = $('#update_stats').data('month');
        get_stats(month);
    }
});

$('#login_form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: 'functions/bg_post.php',
        data: $('#login_form').serialize(),
        success: function (o) {
            if (o == "true") {
                location.reload();
            } else {
                alert(o);
            }
        }
    });
});

function get_stats(month) {
    $.post("functions/bg_post.php", { get_stats: month })
        .done(function (e) {
            console.log(e)
            let obj = JSON.parse(e);
            if (obj !== null) {
                $(".statistic").find("#month_text").text(obj.month);
                $(".statistic").find("#stats_orders").text(obj.count);
                $(".statistic").find("#stats_total").text(obj.total);
            }
        });
}

$(document).on('click', '#logout', function () {
    $.post("functions/bg_post.php", { logout: true })
        .done(function () {
            location.reload();
        });
});

$('#update_stats').on('click', function () {
    let month = $(this).data('month');
    $.post("functions/bg_post.php", { update_stats: month })
        .done(function () {
            get_stats(month);
        });
});

$('#prev_stats').on('click', function () {
    let month = $(this).data('prev-month');
    $.post("functions/bg_post.php", { prev_stats: month })
        .done(function () {
            get_stats(month);
        });
});

$('#edit_company').on('submit', function (e) {
    tiny_editor = $("#head_textarea_ifr").contents().find("#tinymce");
    $('#head_textarea').html(tiny_editor.html());
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: 'index.php',
        data: $('#edit_company').serialize(),
        success: function () {
            alert("Saved");
            location.reload();
        }
    });
});

$('.add-category').on('click', function () {
    var category_name = $('.category_editor').find('.category_editor-name').val();
    $.post("index.php", { add_category: true, category_name: category_name })
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
        $.post("index.php", { delete_category: true, category: category })
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
    $.post("index.php", { edit_category: true, category_name: category_name, category_index: category_index })
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
    $('.edit_product_items').find('.product-options').val($(this).data("options"));
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
    var options = $('.edit_product_items').find('.product-options').val();
    $.post("index.php", {
        edit_product: true, category: category,
        product_id: product_id, img: img, name: name, description: description,
        price: price, kind: kind, qtty: qtty, options: options
    })
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
    $.post("index.php", { duplicate_product: true, category: category, product: product })
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
    $.post("index.php", { favorite_product: true, category: category, product: product })
        .done(function (e) {
            console.log(e)
            setTimeout(function () {
                location.reload();
            }, 500);
        });
});

//CART
$(document).on('click', '.product-to-cart', function () {
    var productId = $(this).data("product_id");
    var options = $(this).data("product_options");
    options = options.split(",");
    $('.add_to_cart').find('.option_name').empty();
    let product_in_cart = $('.cart_items').find('[data-product_id=' + productId + ']').data('product_id');
    if (!product_in_cart) {
        options.forEach(function (item) {
            if (item != "") {
                $('.add_to_cart').find('.option_name').append("<option value='" + item + "'>" + item + "</option>");
            }
        })
    }
    var options_length = $('.add_to_cart').find('.option_name').children('option').length;
    if (options_length != 0) {
        select_product_option(productId);
    } else {
        add_to_cart(productId)
    }
});

function select_product_option(productId) {
    $('.add_to_cart').find('.product_id').val(productId);
    $('#addToCart').modal('toggle');
}

$('.add-to-cart_btn').on('click', function () {
    var productId = $('.add_to_cart').find('.product_id').val();
    var option = $('.add_to_cart').find('.option_name').val();
    add_to_cart(productId, option);
});

function add_to_cart(productId, option = "") {
    var numItems = $('.cart-product').length
    if (!is_whatsapp || numItems < 10) {
        add_to_cart_animation(productId);
        $.post("index.php", { add_to_cart: true, product: productId, option: option })
            .done(function () {
                view_cart();
            });
    } else {
        alert("Max cart items is 10!");
    }
}

function add_to_cart_animation(productId) {
    var cart = $('.cart');
    var imgtodrag = $("#" + productId).find(".card-image").eq(0);
    if (imgtodrag) {
        var imgclone = imgtodrag.clone()
            .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
            .css({
                'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            })
            .appendTo($('body'))
            .animate({
                'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 75,
                'height': 75
            }, 1000);

        imgclone.animate({
            'width': 0,
            'height': 0
        }, function () {
            $(this).detach()
        });
    }
}


$(document).on('click', '.remove-from-cart', function () {
    var productId = $(this).parent().data("product_id");
    $.post("index.php", { remove_product: productId })
        .done(function () {
            view_cart();
        });
});

$(document).on('click', '.minus', function () {
    var productId = $(this).parent().data("product_id");
    $.post("index.php", { minus_product: productId })
        .done(function () {
            view_cart();
        });
});

$(document).on('click', '.plus', function () {
    var productId = $(this).parent().data("product_id");
    var option = $(this).parent().data("product_option");
    $.post("index.php", { add_to_cart: true, product: productId, option: option })
        .done(function () {
            view_cart();
        });

});

function view_cart() {
    $.post("functions/bg_post.php", { view_cart: true })
        .done(function (e) {
            $(".cart-wraper").find(".cart_items").html(e);
        });
    $.post("functions/bg_post.php", { view_total: true })
        .done(function (e) {
            $(".cart").find(".mobile-cart-total").text(e);
            $(".cart").find(".cart-total").text(e);
        });
};

$('#clear-cart').on('click', function () {
    var confim = confirm('Clear cart?');
    if (confim) {
        $.get("index.php", { clear_cart: true })
            .done(function () {
                location.reload();
            });
    }
});


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
            //Browser has allowed it to be opened
            $.post("index.php", { save_cart: true, cart: cart, total: total, client: client })
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
        $("#client_form1").on("submit", function (out) {
            out.preventDefault();
            $('.close, .btn-close, .send').prop('disabled', true);
            $('.spinner-border').toggle();
            client = $('#client_form').serializeArray();
            var data = {};
            $(client).each(function (index, obj) {
                data[obj.name] = obj.value;
            });
            var total = $('.cart-total').text();
            $.post("index.php", { save_cart: true, cart: cart, total: total, client: data })
                .done(function (e) {
                    //location.replace(location.protocol + '//' + location.host + location.pathname + "?order=" + e + "&sent");
                });
        });
        $("#client_form").on("submit", function (out) {
            $('.close, .btn-close, .send').prop('disabled', true).hide();
            $('.spinner-border').toggle();
        });
    } else {
        alert('Cart is empty!');
    }
});

$('.delete-product').on('click', function () {
    var category = $(this).data("category");
    var product = $(this).data("product");
    var confim = confirm('Delete this product? ' + category + "_" + product);
    if (confim) {
        var category = $(this).data("category");
        var product = $(this).data("product");
        $.post("index.php", { delete_product: true, category: category, product: product })
            .done(function () {
                setTimeout(function () {
                    location.reload();
                }, 500);
            });
    }
});

$('.category_editor_toggle').on('click', function () {
    $('.category_editor').find('.category_editor-name').val("");
});

$('.close-parent').on('click', function () {
    $(this).parent().toggle();
});

$('#search').on('submit', function (e) {
    e.preventDefault();
    var search = $("#search_text").val();
    search = search.toLowerCase();
    search = search.replace(/ /g, '');
    //search = search.substring(1);
    $.post("functions/bg_post.php", { search: search })
        .done(function (res) {
            $("#search_result").empty();
            if (res.startsWith("FOUND:")) {
                res = res.substring(6);
                var products = res.split(",");
                let total = "Found " + (products.length - 1) + " items";
                $("#total_found").empty();
                $("#total_found").append(total);
                products.forEach(function (value) {
                    if (value != "") {
                        $("#" + value).clone().appendTo("#search_result");
                    }
                });
            }
            console.log(res);
        });
});

$('#search_order').on('submit', function (e) {
    e.preventDefault();
    var search = $("#search_order_val").val();
    location.replace(location.protocol + '//' + location.host + location.pathname + "?order=" + search);
});



$('.lang-ru').on('click', function () { change_language("ru") });
$('.lang-he').on('click', function () { change_language("he") });

function change_language(language) {
    setCookie("language", language, 365);
    location.reload();
}

//jQuery Slider
if ($("#favorites_slider").length) {
    $('#favorites_slider').multislider({
        duration: 0,
        interval: 5000
    });
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

//Gallery & Uploader
$('.gallery_image .image').on('click', function () {
    $image_path = $(this).data('path');
    $('.picture-url').val($image_path);
    $('.gallery_view').toggle();
});

$('.select_image_toggle').on('click', function () {
    $('.gallery_view').toggle();
});

$('.delete-gallery-image').on('click', function () {
    var confim = confirm('Delete this picture?');
    if (confim) {
        var image = $(this).data("path");
        $.post("functions/bg_post.php", { delete_gallery_image: true, image: image })
            .done(function (e) {
                alert(e);
            });
        $(this).parent().parent().toggle();

    }
});

$('.get_form_url').on('click', function () {
    var name = $('#upload_image_name').val();
    var url = $(this).parent().find('.upload_image_url').val();
    $.post("functions/bg_post.php", { get_form_url: true, url: url, name: name })
        .done(function (e) {
            $(document).find('.picture-url').val(user_data + 'products/' + e);
            alert(e + " uploaded!");
            $('#uploader').modal('toggle');
        });
});

$('.upload_image_toggle').on("click", function () {
    $("#upload_image_name").val($(this).attr("data-name"));
})

$('.upload_btn').on('click', function () {
    var fd = new FormData();
    var files = $('#imagefile')[0].files;
    console.log(files);
    var name = $('#upload_image_name').val();
    alert(name);
    if (files.length > 0 && name != "") {
        fd.append('file', files[0]);
        fd.append('name', name);
        $.ajax({
            url: 'functions/bg_post.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != "Error") {
                    alert(response);
                    $(document).find('.picture-url').val(user_data + 'products/' + response);
                    $('#uploader').modal('toggle');
                } else {
                    alert('file not uploaded');
                }
            },
        });
    } else {
        alert("Please select a file and set name!");
    }
});