<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">Player Saves</h4>
            <p class="mb-30">Player: <?= esc($player['name']) ?></p>
        </div>
        <div class="pull-right">
            <a href="<?= route_to('event.match.team.player.view', $player['matchPlayerID']) ?>" class="btn btn-secondary btn-sm">Back</a>
            <a href="<?= route_to('event.match.team.player.save.create', $player['matchPlayerID']) ?>" class="btn btn-primary btn-sm">Add Save</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card-box text-center">
                <div class="user-icon mb-20">
                    <img src="/uploads/playerImage/<?= esc($player['image']) ?>" class="border-radius-100 shadow" width="100" height="100" alt="">
                </div>
                <h5 class="text-center"><?= esc($player['name']) ?></h5>
            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Time</th>
                        <th>Save Type</th>
                        <th>Defense Type</th>
                        <th>Tactic Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($saves as $save): ?>
                        <tr>
                            <td><?= $save['period'] == '1' ? 'First Half' : 'Second Half' ?></td>
                            <td><?= esc($save['time']) ?></td>
                            <td><?= esc($save['saveType']) ?></td>
                            <td><?= esc($save['defenseType']) ?></td>
                            <td><?= esc($save['tacticType']) ?></td>
                            <td><?= $save['isSaved'] ? '<span class="badge badge-success">Saved</span>' : '<span class="badge badge-danger">Failed</span>' ?></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" 
                                       href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="<?= route_to('save.edit', $save['saveID']) ?>">
                                            <i class="dw dw-edit2"></i> Edit
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
</div>

<?= $this->endSection() ?>