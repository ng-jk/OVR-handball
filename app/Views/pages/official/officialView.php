<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-4">
        <div class="pull-left">
            <h4 class="text-blue h4">Team Official Details</h4>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('team.official.edit', $official['officialID']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
            <a href="<?= route_to('team.view', $official['teamID']) ?>" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Team</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <?php if ($official['image']): ?>
                <img src="/uploads/officialImage/<?= $official['image'] ?>" alt="Official Photo" class="img-fluid rounded-circle shadow" style="max-width: 200px;">
            <?php else: ?>
                <img src="/backend/vendors/images/photo1.jpg" alt="Default Photo" class="img-fluid rounded-circle shadow" style="max-width: 200px;">
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Name</th>
                    <td><?= esc($official['name']) ?></td>
                </tr>
                <tr>
                    <th>Function</th>
                    <td class="text-capitalize"><?= esc($official['function']) ?></td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td><?= date('d M Y', strtotime($official['dateOfBirth'])) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if ($official['deleted_at']): ?>
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