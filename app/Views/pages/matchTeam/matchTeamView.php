<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<?php if (empty($team)): ?>
    <div class="alert alert-warning">
        <p>No team data available.</p>
    </div>
<?php else: ?>
    <div class="pd-20 card-box mb-30">
        <div class="clearfix mb-20">
            <div class="pull-left">
                <h4 class="text-blue h4">Team Match Details</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card-box text-center">
                    <div class="user-icon mb-20">
                        <?php if (!empty($team['logo'])): ?>
                            <img src="/uploads/teamImage/<?= esc($team['logo']) ?>" class="border-radius-100 shadow" width="100" height="100" alt="">
                        <?php else: ?>
                            <img src="/uploads/teamImage/default.png" class="border-radius-100 shadow" width="100" height="100" alt="Default Team Logo">
                        <?php endif; ?>
                    </div>
                    <h4 class="text-center text-primary"><?= esc($team['name']) ?></h4>
                    <p class="text-center text-muted"><?= esc($team['group']) ?></p>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card-box pd-20">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Half Time Score</label>
                                <p class="h4"><?= esc($team['halftime']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>End of Playing Time</label>
                                <p class="h4"><?= esc($team['endOfPlaying']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>1st Overtime</label>
                                <p class="h4"><?= esc($team['overtime1']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>2nd Overtime</label>
                                <p class="h4"><?= esc($team['overtime2']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>After Penalty Throw</label>
                                <p class="h4"><?= esc($team['afterPenalityThrow']) ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>7m Shots</label>
                                <p class="h4"><?= esc($team['7mShot']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>7m Goals</label>
                                <p class="h4"><?= esc($team['7mGoal']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>Team Timeout (1st Half)</label>
                                <p class="h4"><?= esc($team['teamTimeout1']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>Team Timeout (2nd Half)</label>
                                <p class="h4"><?= esc($team['teamTimeout2']) ?></p>
                            </div>
                            <div class="form-group">
                                <label>Team Timeout (Overtime)</label>
                                <p class="h4"><?= esc($team['teamTimeout3']) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Points in Match</label>
                        <p class="h3 text-primary"><?= esc($team['pointInMatch']) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="text-center">
                    <a href="<?= route_to('event.match.team.player', $team['matchTeamID']) ?>" class="btn btn-primary">View Player in the Match</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>