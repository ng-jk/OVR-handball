<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Edit Match #<?= esc($match['matchNo']) ?></h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('match.edit.handler', $match['matchID']) ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Current Teams</label>
                    <div class="border p-3 rounded mb-3">
                        <div class="row">
                            <?php foreach ($matchTeams as $team): ?>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="/uploads/teamLogo/<?= esc($team['logo']) ?>"
                                            class="border-radius-100 shadow" width="40" height="40" alt="">
                                        <span class="ml-2"><?= esc($team['name']) ?></span>
                                        <a href="<?= route_to('match.team.edit', $team['teamID']) ?>" class="btn btn-sm btn-primary ml-2">
                                            <i class="icon-copy dw dw-edit2"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Date & Time</label>
                    <input type="datetime-local" class="form-control" name="dateTime"
                        value="<?= date('Y-m-d\TH:i', strtotime($match['dateTime'])) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Hall</label>
                    <input type="text" class="form-control" name="hall" value="<?= esc($match['hall']) ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status</label>
                    <select class="custom-select col-12" name="status" id="status">
                        <option selected="<?= $match['status'] ?>">select status</option>
                        <option value="pending">Pending</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Spectator Count</label>
                    <input type="number" class="form-control" name="spectator" min="0" value="<?= esc($match['spectator']) ?>">
                </div>
            </div>
        </div>

        <div class="form-group" style="display:<?php if ($match['status'] != "completed"): ?>none<?php endif; ?>;" id="winner">
            <label>Winner</label>
            <select class="form-control" name="winner" id="winnerSelect">
                <option selected="">Select Winner</option>
                <?php foreach ($matchTeams as $team): ?>
                    <option value="<?= $team['teamID'] ?>" <?= ($team['teamID'] == $match['winner']) ? 'selected' : '' ?>>
                        <?= esc($team['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Match Number</label>
            <input type="text" class="form-control" name="matchNo" value="<?= esc($match['matchNo']) ?>">
        </div>

        <div class="form-group">
            <label>Remarks</label>
            <textarea class="form-control" name="remark" rows="4"><?= esc($match['remark']) ?></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Match</button>
            <a href="<?= route_to('match.view', $match['eventID']) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/select2/css/select2.min.css">
<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="/resource/src/plugins/select2/js/select2.full.min.js"></script>

<script>
    document.getElementById("status").addEventListener("change", function() {
        let winner = document.getElementById("winner");
        let winnerSelect = document.getElementById("winnerSelect");
        if (this.value === "completed") {
            winner.style.display = "";
            winnerSelect.required = true; // Make the select required whe
        } else {
            winner.style.display = "none";
            winner.value = "";
        }
    });
</script>

<?= $this->endSection() ?>