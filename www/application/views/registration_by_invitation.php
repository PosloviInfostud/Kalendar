<?php if(isset($error)) { ?>
<div class="jumbotron">
    <div class="alert alert-danger">
    <p class="text-center"><?= $error ?></p>
    </div>
</div>
<?php } else { ?>
<div class="jumbotron">
    <form id="register_by_invite_form" class="border border-info rounded p-3">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="register_name">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" value="<?= $email; ?>" id="register_email" disabled>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="register_password" name="password">
        </div>
        <div class="form-group">
            <label for="confirm">Confirm Password</label>
            <input type="password" class="form-control" id="register_password_confirm" name="confirm">
        </div>
        <input type="hidden" name="token" value="<?= $token; ?>" id="token">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php } ?>
<script src="/js/reglog.js"></script>