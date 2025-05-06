<?= $this->extend("layout/auth-layout") ?>
<?= $this->section("loginForm") ?>


<?php $validation = service( 'validation') ?>
<form action="<?= route_to("login.handler") ?>" method="POST" >
    <?= csrf_field() ?>

    <?php if(!empty(session()->getFlashdata( "success"))) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata("success") ?>
        <button type="'button" class="close" data-dismiss="alert" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif ?>

    <?php if($validation->getError('username')): ?>
        <div class="d-block text-danger" style="margin-top:-25px;margin-bottom:15px;">
        <?= $validation->getError('username'); ?>
        </div>
    <?php elseif($validation->getError('password')): ?>
        <div class="d-block text-danger" style="margin-top:-25px;margin-bottom:15px;">
            <?= $validation->getError('username'); ?>
        </div>
    <?php endif ?>

    <div class="input-group custom">
        <input
            type="text"
            class="form-control form-control-lg"
            placeholder="Username"
            name="username"/>
        <div class="input-group-append custom">
            <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
        </div>
    </div>
    <div class="input-group custom">
        <input
            type="password"
            class="form-control form-control-lg"
            placeholder="**********"
            name="password" />
        <div class="input-group-append custom">
            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="input-group mb-0">
                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
            </div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>