<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Shot Details</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('shot.index', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
            <a href="<?= route_to('shot.edit', $shot['shotID']) ?>" class="btn btn-primary btn-sm">Edit</a>
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
                <h5 class="mb-20 h5">Shot Information</h5>
                <ul>
                    <li>
                        <span>Period:</span>
                        <?= $shot['period'] == '1' ? 'First Half' : 'Second Half' ?>
                    </li>
                    <li>
                        <span>Time:</span>
                        <?= esc($shot['time']) ?>
                    </li>
                    <li>
                        <span>Shot Type:</span>
                        <?= esc($shot['shotType']) ?>
                    </li>
                    <li>
                        <span>Goal Type:</span>
                        <?= esc($shot['goalType']) ?>
                    </li>
                    <li>
                        <span>Destination Type:</span>
                        <?= esc($shot['destType']) ?>
                    </li>
                    <li>
                        <span>Defense Type:</span>
                        <?= esc($shot['defenseType']) ?>
                    </li>
                    <li>
                        <span>Tactic Type:</span>
                        <?= esc($shot['tacticType']) ?>
                    </li>
                    <li>
                        <span>Goalkeeper:</span>
                        <?= esc($shot['goalKeeperID']) ?>
                    </li>
                    <li>
                        <span>Speed:</span>
                        <?= esc($shot['speed']) ?> km/h
                    </li>
                    <li>
                        <span>Status:</span>
                        <?= $shot['isDeleted'] ? '<span class="text-danger">Deleted</span>' : '<span class="text-success">Active</span>' ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>