<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php elseif (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Add Players to Match</h4>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player', $matchTeamID) ?>" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <form action="<?= route_to('event.match.team.player.create.handler', $matchTeamID) ?>" method="POST">
        <div class="form-group">
            <label>Select Players</label>
            <select
                class="selectpicker form-control"
                data-size="5"
                data-style="btn-outline-primary"
                multiple
                data-actions-box="true"
                data-selected-text-format="count"
                name="playerIDs[]">
                <optgroup label="Players">
                    <?php foreach ($players as $player): ?>
                        <option value="<?= $player['eventPlayerID'] ?>">
                            <?= esc($player['name']) ?> - <?= esc($player['position']) ?> (#<?= esc($player['jerseyCode']) ?>)
                        </option>
                    <?php endforeach; ?>
                </optgroup>
            </select>
        </div>
        <input type="hidden" name="matchTeamID" value="<?= $matchTeamID ?>">

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Selected Players</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="/resource/src/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
<script>
    $('.selectpicker').selectpicker();
</script>
<?= $this->endSection() ?>

<?= $this->section("stylesheet") ?>
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/bootstrap-select/css/bootstrap-select.min.css">
<?= $this->endSection() ?>