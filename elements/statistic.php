<div class="content statistic navbar-nav text-center mx-md-4">

    <div class="bg-secondary text-white px-2 position-relative stats-month">
        <button type="button" class="btn btn-link fas fa-arrow-left text-decoration-none text-white" id="prev_stats" data-prev-month="<?= date("my", strtotime(date('my') . " -1 month")) ?>" tabindex="0" aria-label="previos statistic"></button>
        <span id='month_text'><?= date("my") ?></span>
    </div>
    <span class="nav-item px-2"><i class="far fa-user px-1 "></i><b id="stats_orders">0</b></span>
    <span class="nav-item px-2"><i class="fas fa-money-bill-wave px-1"></i><b id="stats_total">0</b><?= $carrency ?></span>
    <button type="button" class="btn btn-link fas fa-sync text-decoration-none" id="update_stats" data-month="<?= date('my') ?>" tabindex="0" aria-label="update statistic"></button>
</div>