<?= $this->extend("layout/page-layout") ?>
<?= $this->section("content") ?>

<!-- Match Info Card -->
<div class="card-box pd-20 mb-30">
    <div class="row">
        <div class="col-md-8">
            <h4 class="text-blue h4">Match #<?= esc($match['matchNo']) ?></h4>
            <div class="row mt-3">
                <div class="col-md-6">
                    <p><strong>Date & Time:</strong> <?= date('d M Y H:i', strtotime($match['dateTime'])) ?></p>
                    <p><strong>Hall:</strong> <?= esc($match['hall']) ?></p>
                    <p><strong>Spectators:</strong> <?= esc($match['spectator']) ?></p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Status:</strong>
                        <?php if ($match['status'] === 'completed'): ?>
                            <span class="badge badge-success">Completed</span>
                        <?php elseif ($match['status'] === 'ongoing'): ?>
                            <span class="badge badge-primary">Ongoing</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Pending</span>
                        <?php endif; ?>
                    </p>
                    <?php if ($match['remark']): ?>
                        <p><strong>Remarks:</strong> <?= esc($match['remark']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Teams Score Card -->
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Teams & Scores</h4>
    </div>
    <div class="pb-20">
        <div class="row text-center">
            <?php foreach ($matchTeams as $team): ?>
                <div class="col-md-6">
                    <a href="<?= route_to('event.match.team.view', $team['matchTeamID']) ?>" class="team-link">
                        <div class="pd-20 team-card <?= ($match['winner'] == $team['teamID']) ? 'bg-light' : '' ?>">
                            <img src="/uploads/teamLogo/<?= esc($team['logo']) ?>"
                                alt="<?= esc($team['name']) ?>" class="img-fluid mb-3"
                                style="max-height: 100px;">
                            <h5><?= esc($team['name']) ?></h5>
                            <h3 class="font-24"><?= esc($team['score'] ?? '0') ?></h3>
                            <?php if ($match['winner'] == $team['teamID']): ?>
                                <span class="badge badge-success">Winner</span>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Match Officials -->
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Match Officials</h4>
    </div>
    <div class="pb-20">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matchOfficials as $official): ?>
                        <tr>
                            <td><?= esc($official['function']) ?></td>
                            <td>
                                <div class="name-avatar d-flex align-items-center">
                                    <div class="avatar mr-2 flex-shrink-0">
                                        <img src="/uploads/officialImage/<?= esc($official['image']) ?>"
                                            class="border-radius-100 shadow" width="40" height="40" alt="">
                                    </div>
                                    <div class="txt">
                                        <div class="weight-600"><?= esc($official['name']) ?></div>
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

<?= $this->section("stylesheet") ?>
<style>
    .team-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .team-card {
        transition: background-color 0.3s ease;
    }

    .team-card:hover {
        background-color: #f8f9fa;
    }
</style>
<link rel="stylesheet" type="text/css" href="/resource/vendors/styles/style.css">
<?= $this->endSection() ?>