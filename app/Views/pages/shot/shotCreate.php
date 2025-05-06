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
            <h4 class="text-blue h4">Add Shot</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player.shot', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <form action="<?= route_to('event.match.team.player.shot.create.handler', $player['matchPlayerID']) ?>" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Shot Type</label>
                    <select class="form-control" name="shotType">
                        <option value="">Select Shot Type</option>
                        <option value="9m">9m</option>
                        <option value="6m">6m</option>
                        <option value="Wing">Wing</option>
                        <option value="7m">7m</option>
                        <option value="FB">Fastbreak</option>
                        <option value="Brk">Breakthrough</option>
                        <option value="LD">Long Distance</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Goal Type</label>
                    <select class="form-control" name="goalType" required>
                        <option value="">Select Goal Type</option>
                        <option value="Goal">Goal</option>
                        <option value="Save">Saved</option>
                        <option value="Miss">Missed</option>
                        <option value="Post">Post</option>
                        <option value="Block">Blocked</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Shot dest</label>
                    <select class="form-control" name="destType">
                        <option value="">Select Shot Destination</option>
                        <option value="topLeft">Top Left</option>
                        <option value="topMid">Top Middle</option>
                        <option value="topRight">Top Right</option>
                        <option value="midLeft">Middle Left</option>
                        <option value="midMid">Middle Center</option>
                        <option value="midRight">Middle Right</option>
                        <option value="botLeft">Bottom Left</option>
                        <option value="botMid">Bottom Middle</option>
                        <option value="botRight">Bottom Right</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Defense Type</label>
                    <select class="form-control" name="defenseType">
                        <option value="">Select Defense Type</option>
                        <option value="superiority">Superiority</option>
                        <option value="minority">Minority</option>
                        <option value="goalkeeperOut">Goalkeeper Out</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Defense Tactic</label>
                    <select class="form-control" name="tacticType">
                        <option value="">Select Defense Tactic</option>
                        <option value="6-0">def 6-0</option>
                        <option value="5-1">def 5-1</option>
                        <option value="4-2">def 4-2</option>
                        <option value="3-3">def 3-3</option>
                        <option value="2-4">def 2-4</option>
                        <option value="1-5">def 1-5</option>
                        <option value="0-6">def 0-6</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Speed (m/s)</label>
                    <input type="number" class="form-control" name="speed" step="0.01">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Period</label>
                    <select class="form-control" name="period">
                        <option value="">Select Period</option>
                        <option value="1">First Half</option>
                        <option value="2">Second Half</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Time</label>
                    <input type="time" class="form-control" name="time">
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Shot</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>