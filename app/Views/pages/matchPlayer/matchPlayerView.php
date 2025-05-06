<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Player Match Statistics</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player.edit', $matchPlayerID) ?>" class="btn btn-primary btn-sm">Edit</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card-box text-center">
                <div class="user-icon mb-20">
                    <img src="/uploads/playerImage/<?= esc($player['image']) ?>" class="border-radius-100 shadow" width="100" height="100" alt="">
                </div>
                <h5 class="text-center"><?= esc($player['name']) ?></h5>
                <p class="text-center">Jersey #<?= esc($player['jerseyCode']) ?></p>
                <p class="text-center">Position: <?= esc($player['position']) ?></p>
                <p class="text-center"><?= $player['isStartingLineUp'] ? 'Starting Line Up' : 'Substitute' ?></p>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-box pd-20">
                        <h5 class="text-blue h5 mb-20">Offensive Statistics</h5>
                        <div class="profile-info">
                            <h5 class="mb-20 weight-500">Goals <span class="float-right"><?= esc($player['matchGoal']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Shots <span class="float-right"><?= esc($player['matchShot']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Saves <span class="float-right"><?= esc($player['matchSave']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Assists <span class="float-right"><?= esc($player['assist']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Pass Clear Chances <span class="float-right"><?= esc($player['passClearChance']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Performance Time <span class="float-right"><?= esc($player['totalPerformanceTime']) ?> min</span></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-box pd-20">
                        <h5 class="text-blue h5 mb-20">Defensive Statistics</h5>
                        <div class="profile-info">
                            <h5 class="mb-20 weight-500">Earned 7m Penalties <span class="float-right"><?= esc($player['earned7mPen']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Earned 2m Punishments <span class="float-right"><?= esc($player['earned2mPun']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Technical Faults <span class="float-right"><?= esc($player['technicalFault']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Steals <span class="float-right"><?= esc($player['steal']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Committed 7m <span class="float-right"><?= esc($player['commit7m']) ?></span></h5>
                            <h5 class="mb-20 weight-500">Blocks <span class="float-right"><?= esc($player['block']) ?></span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-group mb-3">
        <a href="<?= route_to('event.match.team.player.penalty', $player['matchPlayerID']) ?>" class="btn btn-primary">Add Penalty</a>
        <a href="<?= route_to('event.match.team.player.shot', $player['matchPlayerID']) ?>" class="btn btn-primary">Add Shot</a>
        <a href="<?= route_to('event.match.team.player.save', $player['matchPlayerID']) ?>" class="btn btn-primary">Add Save</a>
    </div>
</div>

<?= $this->endSection() ?>