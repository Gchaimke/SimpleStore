<div class="cart card mt-2">
    <div class="card-body">
        <center>
            <h6 class="card-title cart_header">Your cart</h6>
        </center>
        <ol class="cart_items"></ol>
        <center>
            <b>Total: <span class="cart-total">0</span> ש"ח</b>
            <div><a class="btn btn-outline-success text-info mt-1 cart-send" aria-hidden="true" href="https://api.whatsapp.com/send/?phone=972<?php echo substr($company->phone,1);?>&text=">Send</a></div>
        </center>
    </div>
</div>