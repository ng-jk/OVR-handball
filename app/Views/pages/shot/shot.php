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
            <h4 class="text-blue h4">Player Shots</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player.view', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
            <a href="<?= route_to('event.match.team.player.shot.create', $player['matchPlayerID']) ?>" class="btn btn-primary btn-sm">Add Shot</a>
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Time</th>
                        <th>Shot Type</th>
                        <th>Goal Type</th>
                        <th>Dest Type</th>
                        <th>Defense Type</th>
                        <th>Tactic Type</th>
                        <th>Speed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shots as $shot): ?>
                        <tr>
                            <td><?= esc($shot['period']) ?></td>
                            <td><?= esc($shot['time']) ?></td>
                            <td><?= esc($shot['shotType']) ?></td>
                            <td><?= esc($shot['goalType']) ?></td>
                            <td><?= esc($shot['destType']) ?></td>
                            <td><?= esc($shot['defenseType']) ?></td>
                            <td><?= esc($shot['tacticType']) ?></td>
                            <td><?= esc($shot['speed']) ?> m/s</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" 
                                       href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="<?= route_to('event.match.team.player.shot.edit', $shot['shotID']) ?>">
                                            <i class="dw dw-edit2"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="<?= route_to('event.match.team.player.shot.delete', $shot['shotID']) ?>">
                                            <i class="dw dw-edit2"></i> Edit
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("script") ?>
<?= $this->endSection() ?>

<?= $this->section("stylesheet") ?>
<?= $this->endSection() ?>