<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-4">
        <div class="pull-left">
            <h4 class="text-blue h4">Partner Details</h4>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.partner.edit', $partner['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
            <a href="<?= route_to('event.view', $partner['eventID']) ?>" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <img src="/uploads/partnerLogo/<?= $partner['logo'] ?>" alt="Partner Logo" class="img-fluid" style="max-width: 300px;">
        </div>
        <div class="col-md-8">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Partner Name</th>
                    <td><?= esc($partner['name']) ?></td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td class="text-capitalize"><?= esc($partner['type']) ?></td>
                </tr>
                <tr>
                    <th>Website</th>
                    <td>
                        <?php if ($partner['website']): ?>
                            <a href="<?= esc($partner['website']) ?>" target="_blank"><?= esc($partner['website']) ?></a>
                        <?php else: ?>
                            <span class="text-muted">Not provided</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td><?= date('d M Y H:i', strtotime($partner['created_at'])) ?></td>
                </tr>
                <tr>
                    <th>Last Updated</th>
                    <td><?= date('d M Y H:i', strtotime($partner['updated_at'])) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css">
<?= $this->endSection() ?>