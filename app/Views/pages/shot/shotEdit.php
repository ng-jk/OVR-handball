<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Edit Shot</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player.shot', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <form action="<?= route_to('shot.update', $shot['shotID']) ?>" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Shot Type</label>
                    <input type="text" class="form-control" name="shotType" value="<?= esc($shot['shotType']) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Goal Type</label>
                    <input type="text" class="form-control" name="goalType" value="<?= esc($shot['goalType']) ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Dest Type</label>
                    <input type="text" class="form-control" name="destType" value="<?= esc($shot['destType']) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Defense Type</label>
                    <input type="text" class="form-control" name="defenseType" value="<?= esc($shot['defenseType']) ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tactic Type</label>
                    <input type="text" class="form-control" name="tacticType" value="<?= esc($shot['tacticType']) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Speed (km/h)</label>
                    <input type="number" class="form-control" name="speed" value="<?= esc($shot['speed']) ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Period</label>
                    <select class="form-control" name="period">
                        <option value="1" <?= $shot['period'] == '1' ? 'selected' : '' ?>>First Half</option>
                        <option value="2" <?= $shot['period'] == '2' ? 'selected' : '' ?>>Second Half</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Time</label>
                    <input type="time" class="form-control time-picker" name="time" value="<?= esc($shot['time']) ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Goalkeeper ID</label>
                    <input type="number" class="form-control" name="goalKeeperID" value="<?= esc($shot['goalKeeperID']) ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Shot</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>