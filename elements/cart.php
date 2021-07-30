<?php
$total = $cart->get_total();
?>
<div class="cart">
    <span class='btn btn-close position-absolute end-0 close-cart' style="display: none;" aria-label="Close"></span>
    <span class='btn btn-outline-danger far fa-trash-alt position-absolute start-0' id="clear-cart" style="display: none;"></span>
    <h6 class="card-title cart_header d-flex justify-content-center text-nowrap bg-info text-white p-2">
        <span class="me-2"><i class="fas fa-shopping-cart"></i> <span class="mobile-cart-total"><?= $total ?></span><?= $carrency ?></span>
    </h6>
    <div class="cart-wraper text-center" style="display: none;">
        <ol class="cart_items text-start">
            <?PHP
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $product) {
                    $name = property_exists($product, "name_" . $lng) ? "name_" . $lng : "name";
                    $kind = property_exists($product, "kind_" . $lng) ? "kind_" . $lng : "kind";
                    $id = $product->category_id . "_" . $product->id;
            ?>
                    <li data-product_id="<?= $id ?>">
                        <span data-price="55" class="bg-danger remove-from-cart">X</span>
                        <span class="cart-product mx-2"><?= $product->$name ?></span>
                        <span class="cart_qty"><?= $product->cart_qtty ?></span>
                        <span class="cart_kind me-1"><?= $product->$kind ?></span>
                        <span class="cart_price"><?= $product->price ?></span><?= $carrency ?>
                        <div class="cart-controls text-nowrap mb-2 text-center" data-price="<?= $product->price ?>" data-qty="<?= $product->qtty ?>" data-kind="<?= $product->$kind ?>" data-product_id="<?= $id ?>">
                            <span class="btn btn-warning ml-2 minus">-</span><b class="m-2">1</b><span class="btn btn-success plus">+</span>
                        </div>
                        <hr>
                    </li>
            <?php }
            }
            ?>

        </ol>
        <b style="font-size:1rem;"><?= lang("sum") ?>: <span class="cart-total"><?= $total ?></span><?= $carrency ?></b>
        <div class="mx-2">
            <a class="btn btn-outline-success my-2 cart-send-whatsapp" aria-hidden="true" href="https://api.whatsapp.com/send/?phone=972<?php echo substr($company->phone, 1); ?>&text="><i class="fab fa-whatsapp"></i> Send</a>
            <a class="btn btn-outline-success my-2 cart-send-email" aria-hidden="true"><i class="far fa-paper-plane"></i> <?= lang("send") ?></a>
        </div>
    </div>
</div>