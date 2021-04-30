<div class="card mt-2 login-card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">Login</h5>
        <div class="d-flex justify-content-center">
            <div class="input-group mb-3">
                <label class="input-group-text">Password</label>
                <input type="password" id="login-pass" class="form-control" name="password"/>
            </div>

        </div>
        <center>
            <input type="button" id="login_btn" class="btn btn-outline-dark" value="Login"/>
        </center>
    </div>
</div>
<script>
    $('#login_btn').on('click', function() {
        var pass = $('#login-pass').val();
        window.location.href = '<?=URL?>/?login=' + pass;
    });
</script>