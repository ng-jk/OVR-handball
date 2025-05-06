<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4"><?= esc($eventTeam['name']) ?> - <?= esc($event['name']) ?></h4>
            <p class="font-14">Event Team Details</p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.view', $event['eventID']) ?>" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Back to Event
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="profile-photo">
                <img src="/uploads/teamLogo/<?= esc($eventTeam['logo']) ?>"
                    alt="team logo" class="avatar-photo">
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group row">
                <label class="col-sm-12 col-md-4 col-form-label">Registration Date</label>
                <div class="col-sm-12 col-md-8">
                    <strong><?= date('d M Y', strtotime($eventTeam['dateFounded'])) ?></strong>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4 col-form-label">Group</label>
                <div class="col-sm-12 col-md-8">
                    <strong><?= esc($eventTeam['group']) ?></strong>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4 col-form-label">Current Ranking</label>
                <div class="col-sm-12 col-md-8">
                    <strong><?= $eventTeam['ranking'] ? '#' . esc($eventTeam['ranking']) : 'Not Ranked' ?></strong>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4 col-form-label">Points</label>
                <div class="col-sm-12 col-md-8">
                    <strong><?= $eventTeam['points'] ?? '0' ?> pts</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registered Players -->
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Registered Players</h4>
        <div class="pull-right">
            <a href="<?= route_to('event.team.player.add', $eventTeam['eventTeamID']) ?>" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add Player
            </a>
        </div>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Jersey No.</th>
                    <th>Position</th>
                    <th>Rank</th>
                    <th>Goals</th>
                    <th>Goals Saved</th>
                    <th>Games Played</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventPlayers as $player): ?>
                    <tr>
                        <td>
                            <div class="name-avatar d-flex align-items-center">
                                <div class="avatar mr-2 flex-shrink-0">
                                    <?php $imagePath = !empty($player['image']) ? "/uploads/playerImage/" . esc($player['image']) : "/uploads/playerImage/default.png"; ?>
                                    <img src="<?= $imagePath ?>" class="border-radius-100 shadow" width="40" height="40" alt="Player Image">
                                </div>
                                <div class="txt">
                                    <div class="weight-600"><?= esc($player['name']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?= esc($player['jerseyCode']) ?></td>
                        <td><?= esc($player['position']) ?></td>
                        <td><?= esc($player['rank']) ?? 'N/A' ?></td>
                        <td><?= esc($player['goal']) ?? '0' ?></td>
                        <td><?= esc($player['goalSaved']) ?? '0' ?></td>
                        <td><?= esc($player['game']) ?? '0' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section("scripts") ?>
<script src="/resource/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/resource/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="/resource/vendors/scripts/datatable-setting.js"></script>
<?= $this->endSection() ?>