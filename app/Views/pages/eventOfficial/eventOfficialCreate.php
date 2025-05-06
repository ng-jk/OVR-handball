<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Add Officials to Event</h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('event.official.create.handler') ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter official's name">
                </div>

                <div class="form-group">
                    <label>Function</label>
                    <select class="form-control" name="function">
                        <option value="">Select function</option>
                        <option value="referee">Referee</option>
                        <option value="timekeeper">Timekeeper</option>
                        <option value="scorekeeper">Scorekeeper</option>
                        <option value="technical">Technical Delegate</option>
                        <option value="supervisor">Supervisor</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Date</label>
                    <input class="form-control date-picker" type="text" name="date" >
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control" name="image">
                </div>
            </div>
        </div>

        <input type="hidden" name="eventID" value="<?= $eventID ?>">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Officials</button>
            <a href="<?= route_to('event.view', $eventID) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/src/plugins/select2/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css">
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="/backend/src/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(".custom-select2").select2({
        placeholder: "Select officials to add",
        allowClear: true
    });
</script>
<?= $this->endSection() ?>