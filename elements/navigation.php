<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= SITE_ROOT ?>">
            <img src="<?= $company->logo ?>" alt="" width="30" height="24" class="d-inline-block align-text-top">
            <?= $company->name ?> - <?= $company->phone ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler02" aria-controls="navbarToggler02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler02">
            <div class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($logedin) : ?>
                    <span id="admin_nav">
                        <input type="button" class="btn btn-outline-warning align-middle mx-md-2 col" value="<?=lang("settings")?>" data-bs-toggle="modal" data-bs-target="#editCompany">
                        <input type="button" class="btn btn-outline-success align-middle mx-md-2 category_editor_toggle col" value="<?=lang("new_category")?>" data-bs-toggle="modal" data-bs-target="#categoryEditor">
                    </span>
                    <?php include_once('elements/statistic.php'); ?>
                <?php endif ?>
            </div>
            <span class="nav-item">
                <?php if ($lng == 'ru') : ?>
                    <span class="btn btn-outline-info mx-md-2 lang-he"><b>he</b></span>
                <?php endif ?>
                <?php if ($lng == 'he') : ?>
                    <span class="btn btn-outline-info mx-md-2 lang-ru"><b>ru</b></span>
                <?php endif ?>
            </span>
            <span class="nav-item">
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] != '') { ?>
                    <a class="btn btn-outline-info fas fa-sign-out-alt text-primary float-end" aria-hidden="true" href="?logout"></a>
                <?php } else { ?>
                    <button class="btn btn-outline-info fa fa-key text-primary float-end" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#login_view"></button>
                <?php } ?>
            </span>
            <button type="button" class="btn btn-outline-info fas fa-info-circle text-warning mx-md-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            </button>
        </div>
    </div>
</nav>