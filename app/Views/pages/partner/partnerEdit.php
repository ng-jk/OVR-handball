<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <h4 class="text-blue h4">Edit Partner</h4>
    </div>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("<br>", session('error')) ?></div>
    <?php endif; ?>

    <form action="<?= route_to('event.partner.edit.handler', $partner['eventPartnerID']) ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Partner Name</label>
                    <input class="form-control" type="text" name="name" value="<?= $partner['name'] ?>" placeholder="Enter partner name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="type" required>
                        <option value="">Select partner type</option>
                        <option value="sponsor" <?= $partner['type'] === 'sponsor' ? 'selected' : '' ?>>Sponsor</option>
                        <option value="organizer" <?= $partner['type'] === 'organizer' ? 'selected' : '' ?>>Organizer</option>
                        <option value="media" <?= $partner['type'] === 'media' ? 'selected' : '' ?>>Media Partner</option>
                        <option value="technical" <?= $partner['type'] === 'technical' ? 'selected' : '' ?>>Technical Partner</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>hyperlink</label>
            <input class="form-control" type="url" name="hyperlink" value="<?= $partner['hyperlink'] ?>" placeholder="Enter hyperlink URL">
        </div>

        <div class="form-group">
            <label>Partner Logo</label>
            <input type="file" class="form-control-file" name="logo" accept="image/*">
            <?php if ($partner['logo']): ?>
                <div class="mt-2">
                    <img src="/uploads/partnerLogo/<?= $partner['logo'] ?>" alt="Current Logo" style="max-width: 200px;">
                    <p class="text-muted">Current logo will be kept if no new file is uploaded</p>
                </div>
            <?php endif; ?>
        </div>

        <input type="hidden" name="eventID" value="<?= $partner['eventID'] ?>">

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Partner</button>
            <a href="<?= route_to('event.view', $partner['eventID']) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css">
<?= $this->endSection() ?>