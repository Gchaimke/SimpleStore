<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= SITE_ROOT ?>" tabindex="0">
            <img src="<?= $company->logo ?>" alt="" width="30" height="24" class="d-inline-block align-text-top">
            <?= $company->name ?> - <?= $company->phone ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler02" aria-controls="navbarToggler02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler02">
            <div class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($logedin) : ?>
                    <span id="admin_nav">
                        <input type="button" class="btn btn-outline-warning align-middle mx-md-2 col" value="<?= lang("settings") ?>" data-bs-toggle="modal" data-bs-target="#editCompany" tabindex="0">
                        <input type="button" class="btn btn-outline-success align-middle mx-md-2 category_editor_toggle col text-white" value="<?= lang("new_category") ?>" data-bs-toggle="modal" data-bs-target="#categoryEditor" tabindex="0">
                    </span>
                    <?php include_once('elements/statistic.php'); ?>
                <?php endif ?>
            </div>
            <?php if ($lng == 'ru') : ?>
                <input type="button" class="nav-item btn btn-outline-info mx-md-2 lang-he" tabindex="0" value="he">
            <?php endif ?>
            <?php if ($lng == 'he') : ?>
                <input type="button" class="nav-item btn btn-outline-info mx-md-2 lang-ru" tabindex="0" value="ru">
            <?php endif ?>
            <span class="nav-item">
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] != '') { ?>
                    <a class="btn btn-outline-info fas fa-sign-out-alt text-primary float-end" href="?logout" aria-label="logout" tabindex="0"></a>
                <?php } else { ?>
                    <button class="btn btn-outline-info fa fa-key text-primary float-end" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#login_view" aria-label="login" tabindex="0"></button>
                <?php } ?>
            </span>
            <button class="btn btn-outline-info fas fa-info-circle text-warning mx-md-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop" aria-label="info" tabindex="0">
            </button>
        </div>
    </div>
</nav>