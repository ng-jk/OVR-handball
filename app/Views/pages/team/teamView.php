<?= $this->extend("layout/page-layout") ?>

<?= $this->section("content") ?>


<?php if (!empty($success)) : ?>
    <div class="alert alert-success">
        <?= $success ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php elseif (!empty($fail)) : ?>
    <div class="alert alert-success">
        <?= $fail ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<!-- flash data validation-->
<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= implode("", session('error')) ?></div>
<?php elseif (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<div class="card-box pd-20 height-100-p mb-30">
    <div class="row align-items-center">
        <div class="col-md-4">
            <img src="/uploads/teamLogo/<?= $team['logo'] ?>" alt="" style="width:100%;"/>
        </div>
        <div class="col-md-8">
            <h4 class="font-20 weight-500 mb-10 text-capitalize">
                <?= esc($team['name']) ?>
                <div class="weight-600 font-30 text-blue"><?= esc($team['dateFounded']) ?>
                </div>
            </h4>
            <p class="font-18 max-width-600">
                <?= esc($team['teamInfo']) ?>
            </p>
            <div class="row align-items-center">
                <div class="col">
                    <?= esc($team['country']) ?>
                </div>
                <div class="col">
                    <?= esc($team['state']) ?>
                </div>
                <div class="col">
                    <?= esc($team['ranking']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- player Datatable start -->
<div class="m-20 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="text-blue h4 m-2">player</h4>
    </div>
    <a href="<?= route_to('team.player.create',$team['teamID']) ?>">
        <button type="button" class="btn btn-outline-primary m-2">add new</button>
    </a>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" onClick="showPlayer()" id="showDelete">
    <label class="form-check-label" for="showDelete">
        Show soft deleted record
    </label>
</div>
<div class="card-box mb-30">
    <div class="pb-20 table-responsive">
        <table class="data-table table stripe hover nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>ranking</th>
                    <th class="datatable-nosort">image</th>
                    <th class="datatable-nosort">name</th>
                    <th>date of birth</th>
                    <th>height </th>
                    <th>weight</th>
                    <th>country</th>
                    <th>match played</th>
                    <th>goal</th>
                    <th>yellowCard</th>
                    <th>redCard</th>
                    <th>blueCard</th>
                    <th>2m penality first</th>
                    <th>2m penality second</th>
                    <th>2m penality third</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($players)): ?>
                    <?php foreach ($players as $player): ?>
                        <tr>
                            <td class="table-plus">
                                <div class="txt">
                                    <div class="weight-600"><?= esc($player['ranking']) ?></div>
                                </div>
                            </td>
                            <td class="max-width-10">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img
                                            src="/uploads/playerImage/<?= esc($player['image']) ?>"
                                            class="border-radius-100 shadow"
                                            width="40"
                                            height="40" />
                                    </div>
                                </div>
                            </td>
                            <td><?= esc(word_limiter($player['name'], 10)) ?></td>
                            <td><?= esc(word_limiter($player['dateOfBirth'], 5)) ?></td>
                            <td><?= esc(word_limiter($player['height'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['weight'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['country'], 10)) ?></td>
                            <td><?= esc(word_limiter($player['matchPlayed'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['goal'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['yellowCard'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['redCard'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['blueCard'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['2m1'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['2m2'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['2m3'], 3)) ?></td>
                            <td>
                                <div class="dropdown">
                                    <a
                                        class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        href="#"
                                        role="button"
                                        data-toggle="dropdown">
                                        <i class="dw dw-menu-1" style="color:black;"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/player/view/' . esc($player['playerID'])) ?>"><i class="dw dw-eye"></i> View</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/player/edit/' . esc($player['playerID'])) ?>"><i class="dw dw-edit2"></i> Edit</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/player/delete/' . esc($player['playerID'])) ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($deletedPlayers)): ?>
                    <?php foreach ($deletedPlayers as $player): ?>
                        <tr id='deletedPlayerRow' class="noneDisplayPlayer">
                            <td class="table-plus">
                                <div class="txt">
                                    <div class="weight-600"><?= esc($player['ranking']) ?></div>
                                </div>
                            </td>
                            <td class="max-width-10">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img
                                            src="/uploads/playerImage/<?= esc($player['image']) ?>"
                                            class="border-radius-100 shadow"
                                            width="40"
                                            height="40" />
                                    </div>
                                </div>
                            </td>
                            <td><?= esc(word_limiter($player['name'], 10)) ?></td>
                            <td><?= esc(word_limiter($player['dateOfBirth'], 5)) ?></td>
                            <td><?= esc(word_limiter($player['height'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['weight'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['country'], 10)) ?></td>
                            <td><?= esc(word_limiter($player['matchPlayed'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['goal'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['yellowCard'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['redCard'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['blueCard'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['2m1'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['2m2'], 3)) ?></td>
                            <td><?= esc(word_limiter($player['2m3'], 3)) ?></td>
                            <td>
                                <div class="dropdown">
                                    <a
                                        class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        href="#"
                                        role="button"
                                        data-toggle="dropdown">
                                        <i class="dw dw-menu-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/player/restore/' . esc($player['playerID'])) ?>"><i class="dw dw-edit2"></i> restore</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/player/delete/' . esc($player['playerID'])) ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- player Datatable End -->

<!-- official Datatable start -->
<div class="m-20 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="text-blue h4 m-2">official</h4>
    </div>
    <a href="<?= route_to('team.official.create',$team['teamID']) ?>">
        <button type="button" class="btn btn-outline-primary m-2">add new</button>
    </a>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" onClick="showOfficial()" id="showDelete">
    <label class="form-check-label" for="showDelete">
        Show soft deleted record
    </label>
</div>
<div class="card-box mb-30">
    <div class="pb-20 table-responsive">
        <table class="data-table table stripe hover nowrap" id="dataTable">
            <thead>
                <tr>
                    <th class="datatable-nosort">name</th>
                    <th class="datatable-nosort">image</th>
                    <th class="datatable-nosort">date of birth</th>
                    <th class="datatable-nosort">function</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($officials)): ?>
                    <?php foreach ($officials as $official): ?>
                        <tr>
                            <td class="table-plus">
                                <div class="txt">
                                    <div class="weight-600"><?= esc($official['name']) ?></div>
                                </div>
                            </td>
                            <td class="max-width-10">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img
                                            src="/uploads/officialImage/<?= esc($official['image']) ?>"
                                            class="border-radius-100 shadow"
                                            width="40"
                                            height="40" />
                                    </div>
                                </div>
                            </td>
                            <td><?= esc(word_limiter($official['dateOfBirth'], 5)) ?></td>
                            <td><?= esc(word_limiter($official['function'], 10)) ?></td>
                            <td>
                                <div class="dropdown">
                                    <a
                                        class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        href="#"
                                        role="button"
                                        data-toggle="dropdown">
                                        <i class="dw dw-menu-1" style="color:black;"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/official/view/' . esc($official['officialID'])) ?>"><i class="dw dw-eye"></i> View</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/official/edit/' . esc($official['officialID'])) ?>"><i class="dw dw-edit2"></i> Edit</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/official/delete/' . esc($official['officialID'])) ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($deletedOfficials)): ?>
                    <?php foreach ($deletedOfficials as $official): ?>
                        <tr id='deletedOfficialRow' class="noneDisplayOfficial">
                            <td class="table-plus">
                                <div class="txt">
                                    <div class="weight-600"><?= esc(word_limiter($official['name'], 3)) ?></div>
                                </div>
                            </td>
                            <td class="max-width-10">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img
                                            src="/uploads/officialImage/<?= esc($official['image']) ?>"
                                            class="border-radius-100 shadow"
                                            width="40"
                                            height="40"
                                            alt="<?= esc($team['logo']) ?> " />
                                    </div>
                                </div>
                            </td>
                            <td><?= esc(word_limiter($official['dateOfBirth'], 5)) ?></td>
                            <td><?= esc(word_limiter($official['function'], 10)) ?></td>
                            <td>
                                <div class="dropdown">
                                    <a
                                        class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        href="#"
                                        role="button"
                                        data-toggle="dropdown">
                                        <i class="dw dw-menu-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/official/restore/' . esc($official['officialID'])) ?>"><i class="dw dw-edit2"></i> restore</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/team/official/delete/' . esc($official['officialID'])) ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- official Datatable End -->
<?= $this->endSection() ?>



<?= $this->section("stylesheet") ?>
<style>
    .table-responsive {
        overflow-x: auto;
        max-width: 100%;
    }

    .noneDisplayPlayer {
        display: none;
    }

    .noneDisplayOfficial {
        display: none;
    }
</style>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/backend/vendors/styles/icon-font.min.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css" />
<?= $this->endSection() ?>



<?= $this->section('script') ?>
<script>
    function showOfficial() {
        document.querySelectorAll('[id="deletedOfficialRow"]').forEach(element => {
            element.classList.toggle("noneDisplayOfficial", this.checked);
            // Example action: change text color to blue
        });
    }

    function showPlayer() {
        document.querySelectorAll('[id="deletedPlayerRow"]').forEach(element => {
            element.classList.toggle("noneDisplayPlayer", this.checked);
            // Example action: change text color to blue
        });
    }
</script>
<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<!-- buttons for Export datatable -->
<script src="/backend/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script src="/backend/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/buttons.print.min.js"></script>
<script src="/backend/src/plugins/datatables/js/buttons.html5.min.js"></script>
<script src="/backend/src/plugins/datatables/js/buttons.flash.min.js"></script>
<script src="/backend/src/plugins/datatables/js/pdfmake.min.js"></script>
<script src="/backend/src/plugins/datatables/js/vfs_fonts.js"></script>
<!-- Datatable Setting js -->
<script src="/backend/vendors/scripts/datatable-setting.js"></script>
<?= $this->endSection() ?>