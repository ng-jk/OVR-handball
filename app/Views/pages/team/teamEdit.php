<?= $this->extend("layout/page-layout") ?>

<?= $this->section("content") ?>
<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">edit Team</h4>
        </div>
    </div>

    <!-- flash data validation-->
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?= implode("", session('error')) ?></div>
    <?php elseif (session()->has('success')): ?>
        <div class="alert alert-success"><?= session('success') ?></div>
    <?php endif; ?>

    <!-- array data validation-->
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

    <div class="pd-20 card-box mb-30 d-flex justify-content-center">
        <div class="col-md-4 image-container">
            <img src="/uploads/teamLogo/<?= esc($team['logo']) ?>" alt="<?= esc($team['name']) ?>" />
            <h4 class="text-blue h4"><?= isset($team) ? $team['name'] : 'unknown'; ?></h4>
        </div>
    </div>

    <!-- Simple File Upload Form -->
    <form action="<?= route_to('team.edit.handler',$team['teamID']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Name</label>
            <div class="col-sm-12 col-md-10">
                <input autofocus name="name" id="name" class="form-control" type="text" value="<?=$team['name']?>" />
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Team Info</label>
            <div class="col-sm-12 col-md-10">
                <textarea name="teamInfo" id="team_info" value="<?=$team['teamInfo']?>" class="form-control"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Gender</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select col-12" name="gender" id="gender">
                    <option selected="male">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Date founded</label>
            <div class="col-sm-12 col-md-10">
                <input
                    name="dateFounded" id="dateFounded"
                    class="form-control date-picker"
                    value="<?=$team['dateFounded']?>"
                    type="text" />
            </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-sm-12 col-md-2 col-form-label">Choose Logo</label>
            <div class="col-sm-12 col-md-10">
                <input type="file" name="image" id="image" class="form-control-file form-control height-auto" />
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Country</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select col-12" name="country" id="country">
                    <option selected="<?=$team['country']?>"><?=$team['country']?></option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="form-group row" style="display:<?php if($team['country']!="Malaysia"): ?>none<?php endif; ?>;" id="state">
            <label class="col-sm-12 col-md-2 col-form-label">State and Region</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select col-12" name="state">
                    <option selected="<?=$team['state']?>"><?=$team['state']?></option>
                    <option value="Johor">Johor</option>
                    <option value="Kedah">Kedah</option>
                    <option value="Kelantan">Kelantan</option>
                    <option value="Melaka">Melaka</option>
                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                    <option value="Pahang">Pahang</option>
                    <option value="Penang">Penang</option>
                    <option value="Perak">Perak</option>
                    <option value="Perlis">Perlis</option>
                    <option value="Sabah">Sabah</option>
                    <option value="Sarawak">Sarawak</option>
                    <option value="Selangor">Selangor</option>
                    <option value="Terengganu">Terengganu</option>
                    <option value="Kuala Lumpur">Kuala Lumpur (Federal Territory)</option>
                    <option value="Labuan">Labuan (Federal Territory)</option>
                    <option value="Putrajaya">Putrajaya (Federal Territory)</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">update</button>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    document.getElementById("country").addEventListener("change", function() {
        let stateSelect = document.getElementById("state");
        if (this.value === "Malaysia") {
            stateSelect.style.display = ""; // Show the state dropdown
        } else {
            stateSelect.style.display = "none"; // Hide the state dropdown
            stateSelect.value = ""; // Reset the state dropdown
        }
    });
</script>
<?= $this->endSection() ?>