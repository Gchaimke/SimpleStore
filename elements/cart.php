<div class="cart card mt-2">
    <span class='btn-close bg-warning close-cart' style="display: none;" aria-label="Close"></span>
    <div class="card-body">
        <center>
            <h6 class="card-title cart_header d-flex justify-content-center text-nowrap"> 
                <span class="me-2">Cart </span> 
                <div class="hide_not_mobile">
                    <span class="mobile-cart-total">0</span> ש"ח
                </div>
            </h6>
        </center>
        <ol class="cart_items" style="display: none;"></ol>
        <center>
            <b class="cart-total-wraper" style="font-size:1rem;">Total: <span class="cart-total">0</span> ש"ח</b>
            <div><a class="btn btn-outline-success text-info mt-1 cart-send" aria-hidden="true" href="https://api.whatsapp.com/send/?phone=972<?php echo substr($company->phone, 1); ?>&text=">Send</a></div>
        </center>
    </div>
</div>