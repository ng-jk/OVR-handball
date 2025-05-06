<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Create Event</h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('event.create.handler') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Event Name</label>
                    <input class="form-control" type="text" name="name" placeholder="Enter event name" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Series</label>
                    <input class="form-control" type="number" name="series" placeholder="Enter series" >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Start Date</label>
                    <input class="form-control date-picker" type="text" name="startDate" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>End Date</label>
                    <input class="form-control date-picker" type="text" name="endDate" >
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
                        <option value="other">(manual)Other</option>
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
                    <input class="form-control" type="text" name="address" placeholder="Enter address" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Hall</label>
                    <input class="form-control" type="text" name="hall" placeholder="Enter hall name" >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control" name="gender" >
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="mixed">Mixed</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Age</label>
                    <input class="form-control" type="number" name="age" placeholder="Enter age" >
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Event Logo</label>
            <input type="file" class="form-control-file" name="image" >
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Event</button>
            <a href="<?= route_to('event') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css">
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