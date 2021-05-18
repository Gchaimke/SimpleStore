<div class="cart">
    <span class='btn btn-close close-cart position-absolute end-0' style="display: none;" aria-label="Close"></span>
    <center>
        <h6 class="card-title cart_header d-flex justify-content-center text-nowrap bg-info text-white py-1">
            <span class="me-2">Cart </span>
            <div class="hide_not_mobile">
                <span class="mobile-cart-total">0</span> ₪
            </div>
        </h6>
    </center>
    <ol class="cart_items" style="display: none;"></ol>
    <center>
        <b class="cart-total-wraper" style="font-size:1rem;">Total: <span class="cart-total">0</span> ₪</b>
        <div>
            <a class="btn btn-outline-success text-info my-2 cart-send-whatsapp" aria-hidden="true" href="https://api.whatsapp.com/send/?phone=972<?php echo substr($company->phone, 1); ?>&text="><i class="fab fa-whatsapp"></i> Send</a>
            <a class="btn btn-outline-success text-info my-2 cart-send-email" aria-hidden="true"><i class="far fa-paper-plane"></i> Send</a>
        </div>

    </center>
</div>