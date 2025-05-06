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
            <img src="/uploads/playerImage/<?= $player['image'] ?>" alt="" style="width:100%;" />
        </div>
        <div class="col-md-8">
            <h4 class="font-20 weight-500 mb-10 text-capitalize">
                <?= esc($player['name']) ?>
                <div class="weight-600 font-30 text-blue"><?= esc($player['dateOfBirth']) ?></div>
            </h4>
            <div class="row align-items-center">
                <div class="col">Country: <?= esc($player['country']) ?></div>
                <div class="col">Ranking: <?= esc($player['ranking']) ?></div>
            </div>
            <div class="row align-items-center mt-3">
                <div class="col">Height: <?= esc($player['height']) ?> cm</div>
                <div class="col">Weight: <?= esc($player['weight']) ?> kg</div>
            </div>
            <div class="row align-items-center mt-3">
                <div class="col">Matches Played: <?= esc($player['matchPlayed']) ?></div>
                <div class="col">Goals: <?= esc($player['goal']) ?></div>
            </div>
            <div class="row align-items-center mt-3">
                <div class="col">Yellow Cards: <?= esc($player['yellowCard']) ?></div>
                <div class="col">Red Cards: <?= esc($player['redCard']) ?></div>
                <div class="col">Blue Cards: <?= esc($player['blueCard']) ?></div>
            </div>
            <div class="row align-items-center mt-3">
                <div class="col">2M1: <?= esc($player['2m1']) ?></div>
                <div class="col">2M2: <?= esc($player['2m2']) ?></div>
                <div class="col">2M3: <?= esc($player['2m3']) ?></div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>



<?= $this->section("stylesheets") ?>
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