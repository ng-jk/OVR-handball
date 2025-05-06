<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= implode("", session('error')) ?></div>
<?php elseif (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Match Players</h4>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player.create',$matchTeamID) ?>" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Player
            </a>
        </div>
    </div>

    <?php if (empty($players)): ?>
        <div class="alert alert-info">No players found.</div>
    <?php else: ?>
        <table class="data-table table stripe hover nowrap">
            <thead>
                <tr>
                    <th class="table-plus">Player</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player): ?>
                    <tr>
                        <td class="table-plus">
                            <div class="avatar mr-2 flex-shrink-0">
                                <?php $imagePath = !empty($player['image']) ? "/uploads/playerImage/" . esc($player['image']) : "/uploads/playerImage/default.png"; ?>
                                <img src="<?= $imagePath ?>" class="border-radius-100 shadow" width="40" height="40" alt="Player Image">
                            </div>
                        </td>
                        <td>
                            <div class="txt">
                                <div class="weight-600"><?= esc($player['name']) ?></div>
                            </div>
                        </td>
                        <td><?= esc($player['position']) ?></td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" 
                                   href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <a class="dropdown-item" href="<?= route_to('event.match.team.player.view', $matchTeamID) ?>">
                                        <i class="dw dw-eye"></i> View
                                    </a>
                                    <a class="dropdown-item" href="<?= route_to('event.match.team.player.edit', $matchTeamID) ?>">
                                        <i class="dw dw-edit2"></i> Edit
                                    </a>
                                    <a class="dropdown-item" href="<?= route_to('event.match.team.player.delete', $matchTeamID) ?>">
                                        <i class="dw dw-edit2"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheet") ?>
<link rel="stylesheet" type="text/css" href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="/backend/vendors/scripts/sweetalert2.all.min.js"></script>
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

    // Delete player handler
    $('.delete-player').click(function(e) {
        e.preventDefault();
        var playerId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This player will be marked as deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('match/player/delete') ?>/' + playerId,
                    type: 'POST',
                    success: function(response) {
                        if(response.success) {
                            location.reload();
                        }
                    }
                });
            }
        });
    });

    // Restore player handler
    $('.restore-player').click(function(e) {
        e.preventDefault();
        var playerId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This player will be restored!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('match/player/restore') ?>/' + playerId,
                    type: 'POST',
                    success: function(response) {
                        if(response.success) {
                            location.reload();
                        }
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>