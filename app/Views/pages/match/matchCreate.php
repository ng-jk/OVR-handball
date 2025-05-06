<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Create New Match</h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('match.create.handler', $event['eventID']) ?>" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Team 1</label>
                    <select class="form-control" id="teamSelect" name="teamID1">
                        <option value="">Select Team</option>
                        <?php foreach ($eventTeams as $team): ?>
                            <option value="<?= $team['eventTeamID'] ?>"><?= esc($team['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Team 2</label>
                    <select class="form-control" id="teamSelect" name="teamID2">
                        <option value="">Select Team</option>
                        <?php foreach ($eventTeams as $team): ?>
                            <option value="<?= $team['eventTeamID'] ?>"><?= esc($team['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Date & Time</label>
                    <input type="datetime-local" class="form-control" name="dateTime">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Hall</label>
                    <input type="text" class="form-control" name="hall">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="pending">Pending</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Spectator Count</label>
                    <input type="number" class="form-control" name="spectator" min="0">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Match Number</label>
                    <input type="text" class="form-control" name="matchNo">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Officials</label>
                    <select class="form-control" name="officialID">
                        <option value="">Select Official</option>
                        <?php foreach ($officials as $official): ?>
                            <option value="<?= $official['eventOfficialID'] ?>"><?= esc($official['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" name="remark" rows="4"></textarea>
        </div>
        <input type="hidden" name="eventID" value="<?= $event['eventID'] ?>">

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Match</button>
            <a href="<?= route_to('match') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<style>
    .hide {
        display: none;
    }
</style>
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/select2/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/style.css">
<?= $this->endSection() ?>

<?= $this->section("scripts") ?>
<script src="/resource/src/plugins/select2/js/select2.full.min.js"></script>
<script>
    document.getElementById("event").addEventListener("change", function() {
        let teamOption = document.getElementById("team");
        let teamSelect = document.getElementById("teamSelectGroup");
        teamSelect.value = "";
        if (this.value === teamOption.id) {
            teamOption.style.display = ""; // Show the state dropdown
        } else {
            teamOption.style.display = "none"; // Hide the state dropdown
        }
    });
</script>
<?= $this->endSection() ?>