<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<!-- flash data validation-->
<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php elseif (session()->has('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<div class="card-box pd-20 height-100-p mb-30">
    <div class="row align-items-center">
        <div class="col-md-12">
            <h4 class="font-20 weight-500 mb-10 text-capitalize">
                Welcome
                <div class="weight-600 font-30 text-blue">How can i help you?</div>
            </h4>
            <div class="tab">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            data-toggle="tab"
                            href="#team"
                            role="tab"
                            aria-selected="true">Team</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-toggle="tab"
                            href="#event"
                            role="tab"
                            aria-selected="false">Event</a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-toggle="tab"
                            href="#match"
                            role="tab"
                            aria-selected="false">Match</a>
                    </li>
                </ul>
                <div class="tab-content">

                    <!-- Team Tab-->
                    <div
                        class="tab-pane fade show active"
                        id="team"
                        role="tabpanel">
                        <div class="pd-20">
                            <form action="<?= route_to('home.uploadTeamFile') ?>" method="post" enctype="multipart/form-data" id="teamUploadForm">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="weight-600">Select File Type</label>
                                        <div class="custom-control custom-radio mb-5">
                                            <input type="radio" id="teamRadioUp" name="fileSelection" class="custom-control-input" value="team" checked>
                                            <label class="custom-control-label" for="teamRadioUp">Team</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5">
                                            <input type="radio" id="officialRadioUp" name="fileSelection" class="custom-control-input" value="official">
                                            <label class="custom-control-label" for="officialRadioUp">Team Official</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5">
                                            <input type="radio" id="playerRadioUp" name="fileSelection" class="custom-control-input" value="player">
                                            <label class="custom-control-label" for="playerRadioUp">Team Player</label>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="teamUpload" id="teamUpload" accept=".csv" required aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" id="teamFileNameLabel">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" form="teamUploadForm">Upload</button>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="pd-20">
                            <form action="<?= route_to('home.downloadTeamFile') ?>" method="POST" class="mt-3" id="teamDownLoadForm">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label>Download Team File</label>
                                    <div class="form-group">
                                        <select class="custom-select" name="teamID" required>
                                            <option value="">Select Team</option>
                                            <?php if (!empty($teams)): ?>
                                                <?php foreach ($teams as $team): ?>
                                                    <option value="<?= $team['teamID'] ?>"><?= $team['name'] ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <div class="col-md-12">
                                            <label class="weight-600">Select File Type</label>
                                            <!-- Upload Radio Group -->
                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" id="teamRadioDown" name="fileSelection" class="custom-control-input" value="team" checked>
                                                <label class="custom-control-label" for="teamRadioDown">Team</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" id="officialRadioDown" name="fileSelection" class="custom-control-input" value="official">
                                                <label class="custom-control-label" for="officialRadioDown">Team Official</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" id="playerRadioDown" name="fileSelection" class="custom-control-input" value="player">
                                                <label class="custom-control-label" for="playerRadioDown">Team Player</label>
                                            </div>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success" form="teamDownLoadForm">
                                                <i class="icon-copy fa fa-download" aria-hidden="true"></i>
                                                Download Team CSV file
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Event Tab-->
                    <div
                        class="tab-pane fade"
                        id="event"
                        role="tabpanel">
                        <div class="pd-20">
                            <form action="<?= route_to('home.uploadEventFile') ?>" method="post" enctype="multipart/form-data" id="eventUploadForm">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <select class="custom-select" name="eventID" required>
                                        <option value="">Select Event</option>
                                        <?php foreach ($events as $event): ?>
                                            <option value="<?= $event['eventID'] ?>"><?= $event['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="weight-600">Upload Event Files</label>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="eventUploadRadio" name="fileSelection" class="custom-control-input" value="event" checked>
                                        <label class="custom-control-label" for="eventUploadRadio">Event File</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="eventTeamUploadRadio" name="fileSelection" class="custom-control-input" value="team">
                                        <label class="custom-control-label" for="eventTeamUploadRadio">Event Team File</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="eventPlayerUploadRadio" name="fileSelection" class="custom-control-input" value="player">
                                        <label class="custom-control-label" for="eventPlayerUploadRadio">Event Player File</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="eventOfficialUploadRadio" name="fileSelection" class="custom-control-input" value="official">
                                        <label class="custom-control-label" for="eventOfficialUploadRadio">Event Offical File</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="eventPartnerUploadRadio" name="fileSelection" class="custom-control-input" value="partner">
                                        <label class="custom-control-label" for="eventPartnerUploadRadio">Event Partner File</label>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="eventUpload" id="eventUpload" accept=".csv" required aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" id="eventFileNameLabel">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" form="eventUploadForm">Upload</button>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="pd-20">
                            <form action="<?= route_to('home.downloadEventFile') ?>" method="POST" class="mt-3" id="eventDownloadForm">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label class="weight-600">Download Event Files</label>
                                    <div class="form-group">
                                        <select class="custom-select" name="eventID" required>
                                            <option value="">Select Event</option>
                                            <?php foreach ($events as $event): ?>
                                                <option value="<?= $event['eventID'] ?>"><?= $event['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" id="eventDownloadCheck" name="fileSelection[]" class="custom-control-input" value="event">
                                                <label class="custom-control-label" for="eventDownloadCheck">Event File</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" id="eventTeamDownloadCheck" name="fileSelection[]" class="custom-control-input" value="team">
                                                <label class="custom-control-label" for="eventTeamDownloadCheck">Team File</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" id="eventPlayerDownloadCheck" name="fileSelection[]" class="custom-control-input" value="player">
                                                <label class="custom-control-label" for="eventPlayerDownloadCheck">Player File</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" id="eventOfficialDownloadCheck" name="fileSelection[]" class="custom-control-input" value="official">
                                                <label class="custom-control-label" for="eventOfficialDownloadCheck">Official File</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" id="eventPlayerDownloadCheck" name="fileSelection[]" class="custom-control-input" value="partner">
                                                <label class="custom-control-label" for="eventPlayerDownloadCheck">Partner File</label>
                                            </div>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success" form="eventDownloadForm">
                                                <i class="icon-copy fa fa-download" aria-hidden="true"></i>
                                                Download CSV file
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Match Tab-->
                    <div class="tab-pane fade" id="match" role="tabpanel">
                        <div class="pd-20">
                            <form action="<?= route_to('home.uploadMatchFile') ?>" method="post" enctype="multipart/form-data" id="matchUploadForm">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <select class="custom-select" name="eventID" id="" required>
                                        <option value="">Select Event</option>
                                        <?php foreach ($events as $event): ?>
                                            <option value="<?= $event['eventID'] ?>"><?= $event['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="weight-600">Upload Match Files</label>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="matchUploadRadio" name="fileSelection" class="custom-control-input" value="match" checked>
                                        <label class="custom-control-label" for="matchUploadRadio">Match</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="matchTeamUploadRadio" name="fileSelection" class="custom-control-input" value="team">
                                        <label class="custom-control-label" for="matchTeamUploadRadio">Match Team</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="matchPlayerUploadRadio" name="fileSelection" class="custom-control-input" value="player">
                                        <label class="custom-control-label" for="matchPlayerUploadRadio">Match Player</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="matchOfficialUploadRadio" name="fileSelection" class="custom-control-input" value="official">
                                        <label class="custom-control-label" for="matchOfficialUploadRadio">Match Official</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-5">
                                        <input type="radio" id="timelineUploadRadio" name="fileSelection" class="custom-control-input" value="timeline">
                                        <label class="custom-control-label" for="timelineUploadRadio">Timeline</label>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="matchUpload" id="matchUpload" accept=".csv" required>
                                            <label class="custom-file-label" for="matchUpload" id="matchFileNameLabel">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" form="matchUploadForm">Upload</button>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="pd-20">
                            <form action="<?= route_to('home.downloadMatchFile') ?>" method="POST" class="mt-3" id="matchDownloadForm">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label class="weight-600">Download Match Files</label>
                                    <div class="form-group">
                                    <select class="custom-select" name="eventID" id="eventSelect" required>
                                        <option value="">Select Event</option>
                                        <?php foreach ($events as $event): ?>
                                            <option value="<?= $event['eventID'] ?>"><?= $event['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" name="matchID" id="matchSelect" disabled>
                                        <option value="">Select Match</option>
                                    </select>
                                </div>
                                    <div class="input-group">
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" id="matchDownloadCheck" name="fileSelection[]" class="custom-control-input" value="match">
                                                <label class="custom-control-label" for="matchDownloadCheck">Match Information</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" id="matchTeamDownloadCheck" name="fileSelection[]" class="custom-control-input" value="team">
                                                <label class="custom-control-label" for="matchTeamDownloadCheck">Match Team</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" id="matchPlayerDownloadCheck" name="fileSelection[]" class="custom-control-input" value="player">
                                                <label class="custom-control-label" for="matchPlayerDownloadCheck">Match Player</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" id="matchPlayerDownloadCheck" name="fileSelection[]" class="custom-control-input" value="official">
                                                <label class="custom-control-label" for="matchPlayerDownloadCheck">Match Official</label>
                                            </div>

                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success" form="matchDownloadForm">
                                                <i class="icon-copy fa fa-download" aria-hidden="true"></i>
                                                Download CSV file
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/core.css" />
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/icon-font.min.css" />
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="/resource/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/style.css" />
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/core.css" />
<link
    rel="stylesheet"
    type="text/css"
    href="/resource/vendors/styles/icon-font.min.css" />
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/style.css" />
<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="/resource/vendors/scripts/core.js"></script>
<script src="/resource/vendors/scripts/script.min.js"></script>
<script src="/resource/vendors/scripts/process.js"></script>
<script src="/resource/vendors/scripts/layout-settings.js"></script>
<script src="/resource/src/plugins/apexcharts/apexcharts.min.js"></script>
<script src="/resource/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/resource/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/resource/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="/resource/vendors/scripts/dashboard.js"></script>
<script src="/resource/vendors/scripts/core.js"></script>
<script src="/resource/vendors/scripts/script.min.js"></script>
<script src="/resource/vendors/scripts/process.js"></script>
<script src="/resource/vendors/scripts/layout-settings.js"></script>
<script>
    document.getElementById('teamUpload').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        document.getElementById('teamFileNameLabel').innerText = fileName;
    });
    document.getElementById('eventUpload').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        document.getElementById('eventFileNameLabel').innerText = fileName;
    });
    document.getElementById('matchUpload').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        document.getElementById('matchFileNameLabel').innerText = fileName;
    });
</script>
<script>
    document.getElementById('eventSelect').addEventListener('change', function() {
        const matchSelect = document.getElementById('matchSelect');
        const selectedEventId = this.value;

        // Reset and disable match select initially
        matchSelect.innerHTML = '<option value="">Select Match</option>';
        matchSelect.disabled = true;

        if (selectedEventId) {
            // Enable match select when event is selected
            matchSelect.disabled = false;
            <?php if (!empty($matches)): ?>
                <?php foreach ($matches as $match): ?>
                    if ('<?= $match['eventID'] ?>' === selectedEventId) {
                        matchSelect.innerHTML += `<option value="<?= $match['matchID'] ?>"><?= $match['matchNo'] ?></option>`;
                    }
                <?php endforeach; ?>
            <?php endif; ?>
        }
    });
</script>
<?= $this->endSection() ?>