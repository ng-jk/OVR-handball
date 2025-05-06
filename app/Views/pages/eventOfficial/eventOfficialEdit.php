<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Edit Official Role</h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('event.official.edit.handler', $eventOfficial['id']) ?>" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Official Name</label>
                    <input class="form-control" type="text" value="<?= $official['name'] ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role" required>
                        <option value="">Select role</option>
                        <option value="referee" <?= $eventOfficial['role'] === 'referee' ? 'selected' : '' ?>>Referee</option>
                        <option value="timekeeper" <?= $eventOfficial['role'] === 'timekeeper' ? 'selected' : '' ?>>Timekeeper</option>
                        <option value="scorekeeper" <?= $eventOfficial['role'] === 'scorekeeper' ? 'selected' : '' ?>>Scorekeeper</option>
                        <option value="technical" <?= $eventOfficial['role'] === 'technical' ? 'selected' : '' ?>>Technical Delegate</option>
                        <option value="supervisor" <?= $eventOfficial['role'] === 'supervisor' ? 'selected' : '' ?>>Supervisor</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>License Number</label>
                    <input class="form-control" type="text" value="<?= $official['licenseNumber'] ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Category</label>
                    <input class="form-control" type="text" value="<?= $official['category'] ?>" readonly>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Role</button>
            <a href="<?= route_to('event.view', $eventOfficial['eventID']) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css">
<?= $this->endSection() ?>