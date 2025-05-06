<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Edit Team Details</h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('event.team.edit.handler', $eventTeam['eventTeamID']) ?>" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Team Name</label>
                    <input class="form-control" type="text" value="<?= $team['name'] ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Group</label>
                    <input class="form-control" type="text" name="group" value="<?= $eventTeam['group'] ?>" placeholder="Enter group name">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Rank</label>
                    <input class="form-control" type="number" name="rank" value="<?= $eventTeam['rank'] ?>" placeholder="Enter rank">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Matches Won</label>
                    <input class="form-control" type="number" name="win" value="<?= $eventTeam['win'] ?>" placeholder="Enter wins">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Matches Tied</label>
                    <input class="form-control" type="number" name="tied" value="<?= $eventTeam['tied'] ?>" placeholder="Enter ties">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Matches Lost</label>
                    <input class="form-control" type="number" name="lost" value="<?= $eventTeam['lost'] ?>" placeholder="Enter losses">
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Team</button>
            <a href="<?= route_to('event.view', $eventTeam['eventID']) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css">
<?= $this->endSection() ?>