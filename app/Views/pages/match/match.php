<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="contact-directory-list">
    <ul class="d-flex flex-wrap">
        <?php foreach ($events as $event): ?>
            <li class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="contact-directory-box">
                    <div class="contact-dire-info text-center">
                        <div class="contact-avatar">
                            <span>
                                <img src="/uploads/eventLogo/<?= $event['logo'] ?>" />
                            </span>
                        </div>
                        <div class="contact-name">
                            <a href="<?= route_to('match.view', $event['eventID']) ?>">
                                <h3><?= esc($event['name']) ?></h3>
                            </a>
                            <div class="work text-success">
                                <i class="ion-android-calendar"></i>
                                <?= date('d M Y', strtotime($event['startDate'])) ?> -
                                <?= date('d M Y', strtotime($event['endDate'])) ?>
                            </div>
                        </div>
                        <div class="contact-skill">
                            <span class="badge badge-pill">Series: <?= esc($event['series']) ?></span>
                            <span class="badge badge-pill">Rules: <?= esc($event['rules']) ?></span>
                            <span class="badge badge-pill">Address: <?= esc($event['address']) ?></span>
                            <span class="badge badge-pill">Hall: <?= esc($event['hall']) ?></span>
                            <span class="badge badge-pill">Gender: <?= esc($event['gender']) ?></span>
                            <span class="badge badge-pill">Age: <?= esc($event['age']) ?></span>
                        </div>
                    </div>
                    <div class="view-contact">
                        <a href="<?= route_to('event.match.view', $event['eventID']) ?>">View Match</a>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</div>
</div>

<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="/resource/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/resource/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="/resource/vendors/scripts/datatable-setting.js"></script>
<?= $this->endSection() ?>

<?= $this->section("stylesheet") ?>
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<?= $this->endSection() ?>