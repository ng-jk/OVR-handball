<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Edit Save</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('save.index', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <form action="<?= route_to('save.update', $save['saveID']) ?>" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Save Status</label>
                    <select class="form-control" name="isSaved">
                        <option value="1" <?= $save['isSaved'] == '1' ? 'selected' : '' ?>>Saved</option>
                        <option value="0" <?= $save['isSaved'] == '0' ? 'selected' : '' ?>>Not Saved</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Save Type</label>
                    <input type="text" class="form-control" name="saveType" value="<?= esc($save['saveType']) ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Defense Type</label>
                    <input type="text" class="form-control" name="defenseType" value="<?= esc($save['defenseType']) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tactic Type</label>
                    <input type="text" class="form-control" name="tacticType" value="<?= esc($save['tacticType']) ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Period</label>
                    <select class="form-control" name="period">
                        <option value="1" <?= $save['period'] == '1' ? 'selected' : '' ?>>First Half</option>
                        <option value="2" <?= $save['period'] == '2' ? 'selected' : '' ?>>Second Half</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Time</label>
                    <input type="time" class="form-control time-picker" name="time" value="<?= esc($save['time']) ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Save</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>