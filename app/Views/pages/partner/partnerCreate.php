<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Create New Partner</h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('event.partner.create.handler') ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Partner Name</label>
                    <input class="form-control" type="text" name="name" placeholder="Enter partner name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="type">
                        <option value="">Select partner type</option>
                        <option value="sponsor">Sponsor</option>
                        <option value="organizer">Organizer</option>
                        <option value="media">Media Partner</option>
                        <option value="technical">Technical Partner</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Website</label>
            <input class="form-control" type="url" name="hyperlink" placeholder="Enter website URL">
        </div>

        <div class="form-group">
            <label>Partner Logo</label>
            <input type="file" class="form-control-file" name="logo" accept="image/*">
            <small class="form-text text-muted">Recommended size: 200x200 pixels</small>
        </div>
        <input type="hidden" name="eventID" value="<?= $eventID ?>">

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Partner</button>
            <a href="<?= route_to('event.view', $eventID) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css">
<?= $this->endSection() ?>