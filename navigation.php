<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= SITE_ROOT ?>">
            <img src="<?= $company->logo ?>" alt="" width="30" height="24" class="d-inline-block align-text-top">
            <?= $company->name ?> - <?= $company->phone ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler02" aria-controls="navbarToggler02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item me-4">
                    <button type="button" class="btn btn-outline-info fas fa-info-circle text-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    </button>
                </li>
            </ul>
            <div class="nav-item me-4">
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] != '') { ?>
                    <a class="btn btn-outline-info fas fa-sign-out-alt text-primary mt-1" aria-hidden="true" href="?logout"></a>
                <?php } else { ?>
                    <button class="btn btn-outline-info fa fa-key text-primary mt-1" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#login_view"></button>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>