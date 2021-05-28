<div class="cart">
    <span class='btn btn-close close-cart position-absolute end-0' style="display: none;" aria-label="Close"></span>
    <h6 class="card-title cart_header d-flex justify-content-center text-nowrap bg-info text-white p-2">
        <span class="me-2"><i class="fas fa-shopping-cart"></i> <span class="mobile-cart-total">0</span><?= $carrency ?></span>
    </h6>
    <div class="cart-wraper text-center" style="display: none;">
        <ol class="cart_items text-start"></ol>
        <b style="font-size:1rem;"><?php lang($lng, "sum") ?>: <span class="cart-total">0</span><?= $carrency ?></b>
        <div class="mx-2">
            <a class="btn btn-outline-success my-2 cart-send-whatsapp" aria-hidden="true" href="https://api.whatsapp.com/send/?phone=972<?php echo substr($company->phone, 1); ?>&text="><i class="fab fa-whatsapp"></i> Send</a>
            <a class="btn btn-outline-success my-2 cart-send-email" aria-hidden="true"><i class="far fa-paper-plane"></i> <?php lang($lng, "send") ?></a>
        </div>
    </div>
</div>