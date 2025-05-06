<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-4">
        <div class="pull-left">
            <h4 class="text-blue h4">Official Details</h4>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.official.edit', $eventOfficial['id']) ?>" class="btn btn-primary btn-sm">Edit Role</a>
            <a href="<?= route_to('event.view', $eventOfficial['eventID']) ?>" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <?php if ($official['photo']): ?>
                <img src="/uploads/officialPhoto/<?= $official['photo'] ?>" alt="Official Photo" class="img-fluid rounded-circle" style="max-width: 200px;">
            <?php else: ?>
                <img src="/backend/vendors/images/photo1.jpg" alt="Default Photo" class="img-fluid rounded-circle" style="max-width: 200px;">
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Name</th>
                    <td><?= esc($official['name']) ?></td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td class="text-capitalize"><?= esc($eventOfficial['role']) ?></td>
                </tr>
                <tr>
                    <th>License Number</th>
                    <td><?= esc($official['licenseNumber']) ?></td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td><?= esc($official['category']) ?></td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td><?= esc($official['country']) ?></td>
                </tr>
                <tr>
                    <th>State</th>
                    <td><?= esc($official['state']) ?></td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td><?= esc($official['contact']) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= esc($official['email']) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if ($eventOfficial['deleted_at']): ?>
                            <span class="badge badge-danger">Inactive</span>
                        <?php else: ?>
                            <span class="badge badge-success">Active</span>
                        <?php endif; ?>
                    </td>
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