<?= $this->extend("layout/page-layout") ?>

<?= $this->section("content") ?>
<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">edit player</h4>
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
            <img src="/uploads/playerImage/<?= esc($player['image']) ?>" alt="<?= esc($player['image']) ?>" />
        </div>
    </div>

    <!-- Simple File Upload Form -->
    <form action="<?= route_to('team.player.edit.handler', $player['playerID']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Name</label>
            <div class="col-sm-12 col-md-10">
                <input autofocus name="name" id="name" class="form-control" type="text" value="<?= $player['name'] ?>" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Date of birth</label>
            <div class="col-sm-12 col-md-10">
                <input
                    name="dateOfBirth" id="dateOfBirth"
                    class="form-control date-picker"
                    value="<?= $player['dateOfBirth'] ?>"
                    type="text" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">weight(kg)</label>
            <div class="col-sm-12 col-md-10">
                <input name="weight" id="weight" class="form-control" type="number" step="0.01" value="<?= $player['weight'] ?>" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">height(m)</label>
            <div class="col-sm-12 col-md-10">
                <input name="height" id="height" class="form-control" type="number" step="0.01" value="<?= $player['height'] ?>" />
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
            <label for="image" class="col-sm-12 col-md-2 col-form-label">Choose Image</label>
            <div class="col-sm-12 col-md-10">
                <input type="file" name="image" id="image" class="form-control-file form-control height-auto" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Country</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select col-12" name="country" id="country">
                    <option selected="<?= $player['country'] ?>"><?= $player['country'] ?></option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">team</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select col-12" name="teamID" id="teamID">
                    <option selected="<?= esc($player['teamID']) ?>"><?= esc($team['teamID']) ?> : <?= esc($team['name']) ?></option>
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

        <!-- Default Basic Forms Start -->
        <div class="pd-20 card-box mb-30">
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <div class="btn" data-toggle="collapse" data-target="#extraField" aria-expanded="true" aria-controls="collapseOne" style="width: 100%;">
                                Extra field
                            </div>
                        </h5>
                    </div>

                    <div id="extraField" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Match Played</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="number" name="matchPlayed" id="matchPlayed" class="form-control" value="<?= $player['matchPlayed'] ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Goal</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="number" name="goal" id="goal" class="form-control" value="<?= $player['goal'] ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Yellow Card</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="number" name="yellowCard" id="yellowCard" class="form-control" value="<?= $player['yellowCard'] ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Red Card</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="number" name="redCard" id="redCard" class="form-control" value="<?= $player['redCard'] ?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Blue Card</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="number" name="blueCard" id="blueCard" class="form-control" value="<?= $player['blueCard'] ?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">first 2m penality</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="number" name="2m1" id="2m1" class="form-control" value="<?= $player['2m1'] ?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">second 2m penality</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="number" name="2m2" id="2m2" class="form-control" value="<?= $player['2m2'] ?>"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">third 2m penality</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="number" name="2m3" id="2m3" class="form-control" value="<?= $player['2m3'] ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Default Basic Forms End -->

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
        }
    });
</script>
<?= $this->endSection() ?>