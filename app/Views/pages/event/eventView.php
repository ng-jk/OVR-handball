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

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php elseif (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<div class="card-box pd-20 height-100-p mb-30">
    <div class="row align-items-center">
        <div class="col-md-4">
            <img src="/uploads/eventLogo/<?= $event['logo'] ?>" alt="" style="width:100%;" />
        </div>
        <div class="col-md-8">
            <h4 class="font-20 weight-500 mb-10 text-capitalize">
                <?= esc($event['name']) ?>
                <div class="weight-600 font-30 text-blue">
                    <?= esc($event['startDate']) ?> - <?= esc($event['endDate']) ?>
                </div>
            </h4>
            <div class="row align-items-center mb-3">
                <div class="col">
                    <strong>Series:</strong> <?= esc($event['series']) ?>
                </div>
                <div class="col">
                    <strong>Rules:</strong> <?= esc($event['rules']) ?>
                </div>
                <div class="col">
                    <strong>Age:</strong> <?= esc($event['age']) ?>
                </div>
                <div class="col">
                    <strong>Gender:</strong> <?= esc($event['gender']) ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col">
                    <strong>Address:</strong> <?= esc($event['address']) ?>
                </div>
                <div class="col">
                    <strong>Hall:</strong> <?= esc($event['hall']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Partners Datatable start -->
<div class="m-20 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="text-blue h4 m-2">Partners</h4>
    </div>
    <a href="<?= route_to('event.partner.create', $event['eventID']) ?>">
        <button type="button" class="btn btn-outline-primary m-2">add new</button>
    </a>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" onClick="showPartner()" id="showDelete">
    <label class="form-check-label" for="showDelete">
        Show soft deleted record
    </label>
</div>

<div class="card-box mb-30">
    <div class="pb-20 table-responsive">
        <table class="data-table table stripe hover nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="datatable-nosort">Logo</th>
                    <th>Type</th>
                    <th>hyperlink</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($partners)): ?>
                    <?php foreach ($partners as $partner): ?>
                        <tr>
                            <td class="table-plus">
                                <div class="txt">
                                    <div class="weight-600"><?= esc($partner['name']) ?></div>
                                </div>
                            </td>
                            <td class="max-width-10">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img
                                            src="/uploads/partnerLogo/<?= esc($partner['logo']) ?>"
                                            class="border-radius-100 shadow"
                                            width="40"
                                            height="40" />
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($partner['type']) ?></td>
                            <td><?= esc($partner['hyperlink']) ?></td>
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
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/partner/edit/' . esc($partner['eventPartnerID'])) ?>"><i class="dw dw-edit2"></i> Edit</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/partner/delete/' . esc($partner['eventPartnerID'])) ?>"><i class="dw dw-delete-3"></i> Delete</a>
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

<!-- Partners Datatable End -->

<!-- Teams Datatable start -->
<div class="m-20 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="text-blue h4 m-2">Teams</h4>
    </div>
    <a href="<?= route_to('event.team.create', $event['eventID']) ?>">
        <button type="button" class="btn btn-outline-primary m-2">add new</button>
    </a>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" onClick="showTeam()" id="showTeamDelete">
    <label class="form-check-label" for="showTeamDelete">
        Show soft deleted record
    </label>
</div>

<div class="card-box mb-30">
    <div class="pb-20 table-responsive">
        <table class="data-table table stripe hover nowrap" id="teamTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="datatable-nosort">Logo</th>
                    <th>Group</th>
                    <th>Rank</th>
                    <th>Win</th>
                    <th>Tied</th>
                    <th>Lost</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($teams)): ?>
                    <?php foreach ($teams as $team): ?>
                        <?php
                        // Database connection
                        $db = \Config\Database::connect();
                        // Get team data from eventteams table
                        $builder = $db->table('eventteams');
                        $builder->select('*');
                        $builder->where('teamID', $team['teamID']);
                        $builder->where('eventID', $event['eventID']); // Added eventID condition
                        $query = $builder->get();
                        $eventTeam = $query->getRowArray();
                        ?>
                        <tr>
                            <td class="table-plus">
                                <div class="txt">
                                    <div class="weight-600"><?= esc($team['name']) ?></div>
                                </div>
                            </td>
                            <td class="max-width-10">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img
                                            src="/uploads/teamLogo/<?= esc($team['logo']) ?>"
                                            class="border-radius-100 shadow"
                                            width="40"
                                            height="40" />
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($eventTeam['group']) ?></td>
                            <td><?= esc($eventTeam['rank']) ?></td>
                            <td><?= esc($eventTeam['win']) ?></td>
                            <td><?= esc($eventTeam['tied']) ?></td>
                            <td><?= esc($eventTeam['lost']) ?></td>
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
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/team/view/' . esc($eventTeam['eventTeamID'])) ?>"><i class="dw dw-eye"></i> View</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/team/edit/' . esc($eventTeam['eventTeamID'])) ?>"><i class="dw dw-edit2"></i> Edit</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/team/delete/' . esc( $eventTeam['eventTeamID'])) ?>"><i class="dw dw-delete-3"></i> Delete</a>
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
<!-- Teams Datatable End -->

<!-- Officials Datatable start -->
<div class="m-20 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="text-blue h4 m-2">Officials</h4>
    </div>
    <a href="<?= route_to('event.official.create', $event['eventID']) ?>">
        <button type="button" class="btn btn-outline-primary m-2">add new</button>
    </a>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" onClick="showOfficial()" id="showOfficialDelete">
    <label class="form-check-label" for="showOfficialDelete">
        Show soft deleted record
    </label>
</div>

<div class="card-box mb-30">
    <div class="pb-20 table-responsive">
        <table class="data-table table stripe hover nowrap" id="officialTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Date of Birth</th>
                    <th>Image</th>
                    <th class="datatable-nosort">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($officials)): ?>
                    <?php foreach ($officials as $official): ?>
                        <tr>
                            <td class="table-plus">
                                <div class="txt">
                                    <div class="weight-600"><?= esc($official['name']) ?></div>
                                </div>
                            </td>
                            <td><?= esc($official['function']) ?></td>
                            <td><?= esc($official['dateOfBirth']) ?></td>
                            <td class="max-width-10">
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img
                                            src="/uploads/eventOfficialImage/<?= esc($official['image']) ?>"
                                            class="border-radius-100 shadow"
                                            width="40"
                                            height="40" />
                                    </div>
                                </div>
                            </td>
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
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/official/edit/' . esc($official['eventOfficialID'])) ?>"><i class="dw dw-edit2"></i> Edit</a>
                                        <a class="dropdown-item" href="<?= site_url('OVR/handball/event/official/delete/' . esc($official['eventOfficialID'])) ?>"><i class="dw dw-delete-3"></i> Delete</a>
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
<!-- Officials Datatable End -->


<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/core.css" />
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/icon-font.min.css" />
<link rel="stylesheet" type="text/css" href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="/backend/vendors/styles/style.css" />
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function showPartner() {
        document.querySelectorAll('[id="deletedRow"]').forEach(element => {
            element.classList.toggle("noneDisplay", this.checked);
        });
    }
</script>
<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="/backend/vendors/scripts/datatable-setting.js"></script>
<?= $this->endSection() ?>