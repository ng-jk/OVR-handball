<?= $this->extend("layout/page-layout") ?>

<?= $this->section("content") ?>
<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">create player</h4>
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

    <!-- Simple File Upload Form -->
    <form action="<?= route_to('team.player.create.handler') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Name</label>
            <div class="col-sm-12 col-md-10">
                <input autofocus name="name" id="name" class="form-control" type="text" placeholder="Can leave blank" />
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Height(m)</label>
            <div class="col-sm-12 col-md-10">
                <input name="height" id="height" class="form-control" placeholder="Can leave blank" type="number" step="0.01"/>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Weight(kg)</label>
            <div class="col-sm-12 col-md-10">
                <input name="weight" id="weight" class="form-control" placeholder="Can leave blank" type="number" step="0.01"/>
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
            <label class="col-sm-12 col-md-2 col-form-label">Country</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select col-12" name="country" id="country">
                    <option selected="Malaysia">select country</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Date Of Birth</label>
            <div class="col-sm-12 col-md-10">
                <input
                    name="dateOfBirth" id="dateOfBirth"
                    class="form-control date-picker"
                    placeholder="Select Date"
                    type="text" />
            </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-sm-12 col-md-2 col-form-label">Choose Image</label>
            <div class="col-sm-12 col-md-10">
                <input type="file" name="image" id="image" class="form-control-file form-control height-auto" />
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">team</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select col-12" name="teamID" id="teamID">
                    <option selected="<?=$teamID?>"><?=$teamName?></option>
                    <?php if (!empty($teams)): ?>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?= esc($team['teamID']) ?>">
                                <?= esc($team['teamID']) ?> : <?= esc($team['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">create</button>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section("stylesheets") ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= $this->endSection() ?>