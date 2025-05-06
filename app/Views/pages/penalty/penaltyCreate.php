<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<?php
$session = session();
$success = $session->getFlashdata('success');
$error = $session->getFlashdata('error');

if ($success) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $success ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif;

if ($error) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $error ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Add Penalty</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player.view', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <form action="<?= route_to('event.match.team.player.penalty.create.handler', $player['matchPlayerID']) ?>" method="POST">
        <div class="form-group">
            <label>Penalty Type</label>
            <select class="form-control" name="penaltyType" required>
                <option value="yellow_card">Yellow Card</option>
                <option value="red_card">Red Card</option>
                <option value="blue_card">Blue Card</option>
                <option value="penalty_throw">Penalty Throw</option>
                <option value="2min_suspension">2-Minute Suspension</option>
            </select>
        </div>

        <div class="form-group">
            <label>Time</label>
            <input type="time" class="form-control" name="time" required>
        </div>

        <div class="form-group">
            <label>Period</label>
            <select class="form-control" name="period" required>
                <option value="1">First Half</option>
                <option value="2">Second Half</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>