<div class="container">
    <div id="messages" class="col-sm-6 mx-auto"></div>
</div>
<div id="reset_password_form_window" class="col-sm-6 mx-auto border border-primary rounded p-3">
    <form id="form_reset_password">
        <div class="form-group">
            <label for="email">E-Mail</label><br>
            <input type="email" class="form-control" name="email" id="reset_password_email" value="<?= $email; ?>" disabled>
            <small id="reset_email_err" class="form-text text-danger error_box"></small>
        </div>
        <div class="form-group">
            <label for="password">Your New Password</label><br>
            <input type="password" class="form-control" name="password" id="reset_password_password">
            <small id="reset_password_err" class="form-text text-danger error_box"></small>
        </div>
        <div class="form-group">
            <label for="confirm">Confirm Your New Password</label><br>
            <input type="password" class="form-control" name="confirm" id="reset_password_confirm">
            <small id="reset_password_confirm_err" class="form-text text-danger error_box"></small>
        </div>
            <input type="hidden" name="code" id="reset_password_code" value="<?= $code; ?>">
            <input type="submit" name="submit" id="reset_password_submit" class="btn btn-success btn-block" value="Reset Password">
    </form>
    <div id="msgs"></div>
    </div>
<?php } ?>

<script src="/js/reglog.js"></script>