<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Add Teams to Event</h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('event.team.create.handler') ?>" method="POST">
        <div class="form-group">
            <label>Select Teams</label>
            <select
                class="selectpicker form-control"
                data-size="5"
                data-style="btn-outline-primary"
                multiple
                data-actions-box="true"
                data-selected-text-format="count"
                name="teamIDs[]">
                <optgroup label="Available Teams">
                    <?php foreach ($availableTeams as $team): ?>
                        <option value="<?= $team['teamID'] ?>"><?= esc($team['name']) ?></option>
                    <?php endforeach; ?>
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="groupToggle">
                <label class="custom-control-label" for="groupToggle">Add to Group</label>
            </div>
        </div>

        <div class="form-group" id="groupNameField" style="display: none;">
            <label>Group Name</label>
            <input type="text" class="form-control" name="group" placeholder="Enter group name">
        </div>

        <input type="hidden" name="eventID" value="<?= $eventID ?>">
        <button type="submit" class="btn btn-primary">Add Teams</button>
        <a href="<?= route_to('event.view', $eventID) ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/src/plugins/select2/css/select2.min.css">
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="/backend/src/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(".custom-select2").select2({
        placeholder: "Select teams to add",
        allowClear: true
    });

    document.getElementById('groupToggle').addEventListener('change', function() {
        document.getElementById('groupNameField').style.display = this.checked ? 'block' : 'none';
    });
</script>
<?= $this->endSection() ?>