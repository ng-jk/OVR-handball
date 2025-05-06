<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Save Details</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player.save', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
            <a href="<?= route_to('event.match.team.player.save.edit', $save['saveID']) ?>" class="btn btn-primary btn-sm">Edit</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card-box text-center">
                <div class="user-icon mb-20">
                    <img src="/uploads/playerImage/<?= esc($player['image']) ?>" class="border-radius-100 shadow" width="100" height="100" alt="">
                </div>
                <h5 class="text-center"><?= esc($player['name']) ?></h5>
            </div>
        </div>

        <div class="col-md-8">
            <div class="profile-info">
                <h5 class="mb-20 h5">Save Information</h5>
                <ul>
                    <li>
                        <span>Period:</span>
                        <?= $save['period'] == '1' ? 'First Half' : 'Second Half' ?>
                    </li>
                    <li>
                        <span>Time:</span>
                        <?= esc($save['time']) ?>
                    </li>
                    <li>
                        <span>Save Type:</span>
                        <?= esc($save['saveType']) ?>
                    </li>
                    <li>
                        <span>Defense Type:</span>
                        <?= esc($save['defenseType']) ?>
                    </li>
                    <li>
                        <span>Tactic Type:</span>
                        <?= esc($save['tacticType']) ?>
                    </li>
                    <li>
                        <span>Status:</span>
                        <?= $save['isSaved'] ? '<span class="badge badge-success">Saved</span>' : '<span class="badge badge-danger">Failed</span>' ?>
                    </li>
                    <li>
                        <span>Record Status:</span>
                        <?= $save['isDeleted'] ? '<span class="text-danger">Deleted</span>' : '<span class="text-success">Active</span>' ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>