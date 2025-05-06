<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= implode("", session('error')) ?></div>
<?php elseif (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<div class="card-box mb-30">
    <div class="pd-20 row">
        <h4 class="text-blue h4 col m-2">Match List</h4>
        <div class="col d-flex justify-content-end">
            <a href="<?= route_to('event.match.create', $event['eventID']) ?>" class="btn btn-primary m-2">
                Create Match
            </a>
            <a href="<?= route_to('event.match.generate', $event['eventID']) ?>" class="btn btn-primary m-2">
                Auto Generate Match
            </a>
        </div>
    </div>
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap" id="dataTable">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">Match No.</th>
                    <th>Date & Time</th>
                    <th>Hall</th>
                    <th>team1</th>
                    <th>team2</th>
                    <th>Status</th>
                    <th>Winner</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($matches as $match): ?>
                    <tr>
                        <td class="table-plus"><?= esc($match['matchID']) ?></td>
                        <td><?= date('d M Y H:i', strtotime($match['dateTime'])) ?></td>
                        <td><?= esc($match['hall']) ?></td>
                        <td><?= !empty($match['teams'][0]['name']) ? esc($match['teams'][0]['name']) : 'N/A' ?></td>
                        <td><?= !empty($match['teams'][1]['name']) ? esc($match['teams'][1]['name']) : 'N/A' ?></td>
                        <td>
                            <?php if ($match['status'] === 'completed'): ?>
                                <span class="badge badge-success">Completed</span>
                            <?php elseif ($match['status'] === 'ready'): ?>
                                <span class="badge badge-primary">ready</span>
                            <?php elseif ($match['status'] === 'pending'): ?>
                                <span class="badge badge-warning">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($match['winner']): ?>
                                <?= esc($match['winnerTeamName']) ?>
                            <?php else: ?>
                                <span class="text-muted">Not decided</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                    href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <a class="dropdown-item" href="<?= route_to('event.match.view.detail', $match['matchID']) ?>">
                                        <i class="dw dw-eye"></i> View
                                    </a>
                                    <a class="dropdown-item" href="<?= route_to('event.match.edit', $match['matchID']) ?>">
                                        <i class="dw dw-edit2"></i> Edit
                                    </a>
                                    <a class="dropdown-item" href="#"
                                        onclick="confirmDelete('<?= route_to('event.match.delete', $match['matchID']) ?>')">
                                        <i class="dw dw-delete-3"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("stylesheet") ?>
<style>
    .noneDisplay {
        display: none;
    }
</style>
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/core.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/resource/vendors/styles/icon-font.min.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/resource/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/resource/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/style.css" />
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function myFunction() {
        document.querySelectorAll('[id="deletedRow"]').forEach(element => {
            element.classList.toggle("noneDisplay", this.checked);
            // Example action: change text color to blue
        });
    }
</script>
<script src="/resource/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/resource/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<!-- buttons for Export datatable -->
<script src="/resource/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script src="/resource/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="/resource/src/plugins/datatables/js/buttons.print.min.js"></script>
<script src="/resource/src/plugins/datatables/js/buttons.html5.min.js"></script>
<script src="/resource/src/plugins/datatables/js/buttons.flash.min.js"></script>
<script src="/resource/src/plugins/datatables/js/pdfmake.min.js"></script>
<script src="/resource/src/plugins/datatables/js/vfs_fonts.js"></script>
<!-- Datatable Setting js -->
<script src="/resource/vendors/scripts/datatable-setting.js"></script>
<?= $this->endSection() ?>