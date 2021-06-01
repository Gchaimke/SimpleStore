<ul class="content statistic navbar-nav text-center mx-md-4">
    <span class="bg-secondary text-white px-2 position-relative"><?= date("m-Y") ?></span>
    <li class="nav-item px-2"><i class="far fa-user px-1 "></i><b id="stats_orders"></b></li>
    <li class="nav-item px-2"><i class="fas fa-money-bill-wave px-1"></i><b id="stats_total"></b><?= $carrency ?></li>
    <button type="button" class="btn btn-link fas fa-sync float-end text-decoration-none" id="update_stats" tabindex="6"></button>
</ul>