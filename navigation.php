<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="<?=$company->logo?>" alt="" width="30" height="24" class="d-inline-block align-text-top">
            <?=$company->name?> - <?=$company->phone?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <li class="nav-item me-4">
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] != '') { ?>
                    <a class="btn btn-outline-info fas fa-sign-out-alt text-primary mt-1" aria-hidden="true" href="?logout"></a>
                <?php } else { ?>
                    <a class="btn btn-outline-info fa fa-key text-primary mt-1" aria-hidden="true" href="?login=12345"></a>
                <?php } ?>
            </li>
        </div>
    </div>
</nav>