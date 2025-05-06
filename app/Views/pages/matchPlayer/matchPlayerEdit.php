<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Edit Player Match Statistics</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <h4 class="text-blue h4">Edit Player Match Statistics</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
    </div>

    <form action="<?= route_to('event.match.team.player.edit', $player['matchPlayerID']) ?>" method="POST">
        <div class="row">
            <div class="col-md-4">
                <div class="card-box text-center">
                    <div class="user-icon mb-20">
                        <img src="/uploads/playerImage/<?= esc($player['image']) ?>" class="border-radius-100 shadow" width="100" height="100" alt="">
                    </div>
                    <h5 class="text-center"><?= esc($player['name']) ?></h5>
                    <p class="text-center">Jersey #<?= esc($player['jerseyCode']) ?></p>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Position</label>
                            <select class="form-control" name="position">
                                <option value="GK" <?= $player['position'] == 'GK' ? 'selected' : '' ?>>Goalkeeper</option>
                                <option value="LW" <?= $player['position'] == 'LW' ? 'selected' : '' ?>>Left Wing</option>
                                <option value="LB" <?= $player['position'] == 'LB' ? 'selected' : '' ?>>Left Back</option>
                                <option value="CB" <?= $player['position'] == 'CB' ? 'selected' : '' ?>>Center Back</option>
                                <option value="RB" <?= $player['position'] == 'RB' ? 'selected' : '' ?>>Right Back</option>
                                <option value="RW" <?= $player['position'] == 'RW' ? 'selected' : '' ?>>Right Wing</option>
                                <option value="P" <?= $player['position'] == 'P' ? 'selected' : '' ?>>Pivot</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Goals</label>
                            <input type="number" class="form-control" name="matchGoal" value="<?= esc($player['matchGoal']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Shots</label>
                            <input type="number" class="form-control" name="matchShot" value="<?= esc($player['matchShot']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Saves</label>
                            <input type="number" class="form-control" name="matchSave" value="<?= esc($player['matchSave']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Assists</label>
                            <input type="number" class="form-control" name="assist" value="<?= esc($player['assist']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Pass Clear Chances</label>
                            <input type="number" class="form-control" name="passClearChance" value="<?= esc($player['passClearChance']) ?>" min="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Earned 7m Penalties</label>
                            <input type="number" class="form-control" name="earned7mPen" value="<?= esc($player['earned7mPen']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Earned 2m Punishments</label>
                            <input type="number" class="form-control" name="earned2mPun" value="<?= esc($player['earned2mPun']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Technical Faults</label>
                            <input type="number" class="form-control" name="technicalFault" value="<?= esc($player['technicalFault']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Steals</label>
                            <input type="number" class="form-control" name="steal" value="<?= esc($player['steal']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Committed 7m</label>
                            <input type="number" class="form-control" name="commit7m" value="<?= esc($player['commit7m']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Blocks</label>
                            <input type="number" class="form-control" name="block" value="<?= esc($player['block']) ?>" min="0">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Starting Line Up</label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="isStartingLineUp" name="isStartingLineUp" 
                                       value="1" <?= $player['isStartingLineUp'] ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="isStartingLineUp">Yes</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Performance Time (minutes)</label>
                            <input type="number" class="form-control" name="totalPerformanceTime" 
                                   value="<?= esc($player['totalPerformanceTime']) ?>" min="0" max="60">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Statistics</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>