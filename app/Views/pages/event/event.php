<?= $this->extend("layout/page-layout") ?>

<?= $this->section("content") ?>


<?php if (!empty($success)) : ?>
    <div class="alert alert-success">
        <?= $success ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php elseif (!empty($fail)) : ?>
    <div class="alert alert-success">
        <?= $fail ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<!-- flash data validation-->
<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= implode("", session('error')) ?></div>
<?php elseif (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<!-- Simple Datatable start -->
<div class="m-20 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="text-blue h4 m-2">Event</h4>
    </div>
    <a href="<?= route_to('event.create') ?>">
        <button type="button" class="btn btn-outline-primary m-2">create new</button>
    </a>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" onClick="myFunction()" id="showDelete">
    <label class="form-check-label" for="showDelete">
        Show soft deleted record
    </label>
</div>
<div class="card-box mb-30">
    <div class="pb-20">
        <table class="data-table table stripe hover nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>name</th>
                    <th class="datatable-nosort">logo</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>series</th>
                    <th>rules</th>
                    <th>address</th>
                    <th>hall</th>
                    <th>gender</th>
                    <th>age</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
            </thead>
            </tbody>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td class="table-plus">
                                <div class="txt">
                                    <div class="weight-600"><?= esc($event['name']) ?></div>
                                </div>
                            </td>
                            <td class="max-width-10">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img
                                            src="/uploads/eventLogo/<?= esc($event['logo']) ?>"
                                            class="border-radius-100 shadow"
                                            width="40"
                                            height="40" />
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($event['startDate']) ?></td>
                            <td><?= esc($event['endDate']) ?></td>
                            <td><?= esc($event['series']) ?></td>
                            <td><?= esc($event['rules']) ?></td>
                            <td><?= esc($event['address']) ?></td>
                            <td><?= esc($event['hall']) ?></td>
                            <td><?= esc($event['gender']) ?></td>
                            <td><?= esc($event['age']) ?></td>
                            <td>
                                <div class="dropdown">
                                    <a
                                        class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        href="#"
                                        role="button"
                                        data-toggle="dropdown">
                                        <i class="dw dw-menu-1" style="color:black;"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/view/' . esc($event['eventID'])) ?>"><i class="dw dw-eye"></i> View</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/edit/' . esc($event['eventID'])) ?>"><i class="dw dw-edit2"></i> Edit</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/delete/' . esc($event['eventID'])) ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($deletedEvents)): ?>
                    <?php foreach ($deletedEvents as $event): ?>
                        <tr id='deletedRow' class="noneDisplay">
                            <td class="table-plus">
                                <div class="txt">
                                    <div class="weight-600"><?= esc($event['name']) ?></div>
                                </div>
                            </td>
                            <td class="max-width-10">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img
                                            src="/uploads/eventLogo/<?= esc($event['logo']) ?>"
                                            class="border-radius-100 shadow"
                                            width="40"
                                            height="40" />
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($event['startDate']) ?></td>
                            <td><?= esc($event['endDate']) ?></td>
                            <td><?= esc($event['series']) ?></td>
                            <td><?= esc($event['rules']) ?></td>
                            <td><?= esc($event['address']) ?></td>
                            <td><?= esc($event['hall']) ?></td>
                            <td><?= esc($event['gender']) ?></td>
                            <td><?= esc($event['age']) ?></td>
                            <td>
                                <div class="dropdown">
                                    <a
                                        class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        href="#"
                                        role="button"
                                        data-toggle="dropdown">
                                        <i class="dw dw-menu-1" style="color:black;"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/restore/' . esc($event['eventID'])) ?>"><i class="dw dw-edit2"></i> restore</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/delete/' . esc($event['eventID'])) ?>"><i class="dw dw-delete-3"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Simple Datatable End -->
<?= $this->endSection() ?>



<?= $this->section("stylesheets") ?>
<style>
    .noneDisplay {
        display: none;
    }
</style>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/backend/vendors/styles/icon-font.min.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css" />
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
<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<!-- buttons for Export datatable -->
<script src="/backend/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script src="/backend/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/buttons.print.min.js"></script>
<script src="/backend/src/plugins/datatables/js/buttons.html5.min.js"></script>
<script src="/backend/src/plugins/datatables/js/buttons.flash.min.js"></script>
<script src="/backend/src/plugins/datatables/js/pdfmake.min.js"></script>
<script src="/backend/src/plugins/datatables/js/vfs_fonts.js"></script>
<!-- Datatable Setting js -->
<script src="/backend/vendors/scripts/datatable-setting.js"></script>
<?= $this->endSection() ?>