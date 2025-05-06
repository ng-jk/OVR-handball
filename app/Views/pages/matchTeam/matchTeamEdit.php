<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Edit Team Match Details</h4>
            <p class="mb-30">Team: <?= esc($team['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('match.team.view', $match['matchID'], $team['teamID']) ?>" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <form action="<?= route_to('match.team.update', $match['matchID'], $team['teamID']) ?>" method="POST">
        <div class="row">
            <div class="col-md-4">
                <div class="card-box text-center">
                    <div class="team-icon mb-20">
                        <img src="/uploads/teamImage/<?= esc($team['logo']) ?>" class="border-radius-100 shadow" width="100" height="100" alt="">
                    </div>
                    <h5 class="text-center"><?= esc($team['name']) ?></h5>
                    <p class="text-center"><?= esc($team['group']) ?></p>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Half Time Score</label>
                            <input type="number" class="form-control" name="halftime" value="<?= esc($team['halftime']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>End of Playing Time</label>
                            <input type="number" class="form-control" name="endOfPlaying" value="<?= esc($team['endOfPlaying']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>1st Overtime</label>
                            <input type="number" class="form-control" name="overtime1" value="<?= esc($team['overtime1']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>2nd Overtime</label>
                            <input type="number" class="form-control" name="overtime2" value="<?= esc($team['overtime2']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>After Penalty Throw</label>
                            <input type="number" class="form-control" name="afterPenalityThrow" value="<?= esc($team['afterPenalityThrow']) ?>" min="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>7m Shots</label>
                            <input type="number" class="form-control" name="7mShot" value="<?= esc($team['7mShot']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>7m Goals</label>
                            <input type="number" class="form-control" name="7mGoal" value="<?= esc($team['7mGoal']) ?>" min="0">
                        </div>
                        <div class="form-group">
                            <label>Team Timeout (1st Half)</label>
                            <input type="time" class="form-control" name="teamTimeout1" value="<?= esc($team['teamTimeout1']) ?>">
                        </div>
                        <div class="form-group">
                            <label>Team Timeout (2nd Half)</label>
                            <input type="time" class="form-control" name="teamTimeout2" value="<?= esc($team['teamTimeout2']) ?>">
                        </div>
                        <div class="form-group">
                            <label>Team Timeout (Overtime)</label>
                            <input type="time" class="form-control" name="teamTimeout3" value="<?= esc($team['teamTimeout3']) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Points in Match</label>
                    <input type="number" class="form-control" name="pointInMatch" value="<?= esc($team['pointInMatch']) ?>" min="0" max="2">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Details</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("scripts") ?>
<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $.toast({
                        heading: 'Success',
                        text: 'Team match details updated successfully',
                        showHideTransition: 'slide',
                        icon: 'success',
                        position: 'top-right'
                    });
                    setTimeout(function() {
                        window.location.href = '<?= route_to('match.team.view', $match['matchID'], $team['teamID']) ?>';
                    }, 2000);
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>