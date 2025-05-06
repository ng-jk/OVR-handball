<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Edit Penalty</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('penality.index', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <form action="<?= route_to('penality.update', $penalty['penalityID']) ?>" method="POST">
        <div class="form-group">
            <label>Penalty Type</label>
            <input type="text" class="form-control" name="penalityType" value="<?= esc($penalty['penalityType']) ?>" >
        </div>

        <div class="form-group">
            <label>Time</label>
            <input type="time" class="form-control time-picker" name="time" value="<?= esc($penalty['time']) ?>" >
        </div>

        <div class="form-group">
            <label>Period</label>
            <select class="form-control" name="period" >
                <option value="1" <?= $penalty['period'] == '1' ? 'selected' : '' ?>>First Half</option>
                <option value="2" <?= $penalty['period'] == '2' ? 'selected' : '' ?>>Second Half</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Penalty</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>