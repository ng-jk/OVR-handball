<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>

<?php if (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Player Penalties</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player.view', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
            <a href="<?= route_to('event.match.team.player.penalty.create', $player['matchPlayerID']) ?>" class="btn btn-primary btn-sm">Add Penalty</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card-box text-center">
                <div class="user-icon mb-20">
                    <?php $imagePath = !empty($player['image']) ? "/uploads/playerImage/" . esc($player['image']) : "/uploads/playerImage/default.png"; ?>
                    <img src="<?= $imagePath ?>" class="border-radius-100 shadow" width="100" height="100" alt="Player Image">
                </div>
                <h5 class="text-center"><?= esc($player['name']) ?></h5>
            </div>
        </div>

        <div class="col-md-8">
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>Period</th>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penalties as $penalty): ?>
                            <tr>
                                <td><?= esc($penalty['period']) ?></td>
                                <td><?= esc($penalty['time']) ?></td>
                                <td>
                                    <?php
                                        $badge = match($penalty['penaltyType']) {
                                            'Y' => '<span class="badge badge-warning">Yellow Card</span>',
                                            'R' => '<span class="badge badge-danger">Red Card</span>',
                                            'B' => '<span class="badge badge-primary">Blue Card</span>',
                                            '2' => '<span class="badge badge-info">2 Min Suspension</span>',
                                            default => ''
                                        };
                                        echo $badge;
                                    ?>
                                </td>
                                <td>
                                    <?php if ($penalty['deleted_at']): ?>
                                        <span class="badge badge-danger">Deleted</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" 
                                           href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <?php if (!$penalty['deleted_at']): ?>
                                                <a class="dropdown-item" href="<?= route_to('penalty.edit', $penalty['penaltyID']) ?>">
                                                    <i class="dw dw-edit2"></i> Edit
                                                </a>
                                                <a class="dropdown-item text-danger delete-penalty" href="#" 
                                                   data-id="<?= $penalty['penaltyID'] ?>">
                                                    <i class="dw dw-delete-3"></i> Delete
                                                </a>
                                            <?php else: ?>
                                                <a class="dropdown-item text-success restore-penalty" href="#"
                                                   data-id="<?= $penalty['penaltyID'] ?>">
                                                    <i class="dw dw-refresh2"></i> Restore
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheet") ?>
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="/resource/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/resource/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="/resource/vendors/scripts/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    $('.data-table').DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        columnDefs: [{
            targets: "datatable-nosort",
            orderable: false,
        }],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "language": {
            "info": "_START_-_END_ of _TOTAL_ entries",
            searchPlaceholder: "Search",
            paginate: {
                next: '<i class="ion-chevron-right"></i>',
                previous: '<i class="ion-chevron-left"></i>'
            }
        }
    });

    // Delete penalty handler
    $('.delete-penalty').click(function(e) {
        e.preventDefault();
        var penaltyId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This penalty will be marked as deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('penalty/delete') ?>/' + penaltyId;
            }
        });
    });

    // Restore penalty handler
    $('.restore-penalty').click(function(e) {
        e.preventDefault();
        var penaltyId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This penalty will be restored!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('penalty/restore') ?>/' + penaltyId;
            }
        });
    });
});
</script>
<?= $this->endSection() ?>