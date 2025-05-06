<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Edit Event</h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('event.edit.handler', $event['eventID']) ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Event Name</label>
                    <input class="form-control" type="text" name="name" value="<?= $event['name'] ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Series</label>
                    <input class="form-control" type="number" name="series" value="<?= $event['series'] ?>" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Start Date</label>
                    <input class="form-control date-picker" type="text" name="startDate" value="<?= $event['startDate'] ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>End Date</label>
                    <input class="form-control date-picker" type="text" name="endDate" value="<?= $event['endDate'] ?>" required>
                </div>
            </div>
        </div>

        <div class="row">
        <div class="col-md-6">
                <div class="form-group">
                    <label>Rules</label>
                    <select class="form-control" name="rules" >
                        <option value="">Select rules</option>
                        <option value="league">League</option>
                        <option value="knockout">Knockout</option>
                        <option value="combine">Combine</option>
                        <option value="other">(Manual)Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" id="candidateGroup" style="display: none;">
                    <label>Candidate Number</label>
                    <input class="form-control" type="number" name="candidateNum" placeholder="Enter candidate number">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Address</label>
                    <input class="form-control" type="text" name="address" value="<?= $event['address'] ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Hall</label>
                    <input class="form-control" type="text" name="hall" value="<?= $event['hall'] ?>" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control" name="gender" required>
                        <option value="male" <?= $event['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $event['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="mixed" <?= $event['gender'] === 'mixed' ? 'selected' : '' ?>>Mixed</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Age</label>
                    <input class="form-control" type="number" name="age" value="<?= $event['age'] ?>" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Event Logo</label>
            <input type="file" class="form-control-file" name="logo" accept="image/*">
            <?php if ($event['logo']): ?>
                <div class="mt-2">
                    <img src="/uploads/eventLogo/<?= $event['logo'] ?>" alt="Current Logo" style="max-width: 200px;">
                    <p class="text-muted">Current logo will be kept if no new file is uploaded</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Event</button>
            <a href="<?= route_to('event') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    document.querySelector('select[name="rules"]').addEventListener('change', function() {
        const candidateGroup = document.getElementById('candidateGroup');
        candidateGroup.style.display = this.value === 'combine' ? 'block' : 'none';
        if (this.value !== 'combine') {
            document.querySelector('input[name="candidateNum"]').value = '';
        }
    });
</script>
<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css">
<?= $this->endSection() ?>