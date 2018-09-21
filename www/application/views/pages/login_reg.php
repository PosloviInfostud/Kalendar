<?php if(isset($this->session->userdata['user_name'])) { ?>
    <h4>Hello! You are logged in as <?= $this->session->userdata['user_name'] ?></h4>
<?php } else { ?>

<div class="row border">
    <div id="login_btn" class="col-sm-6 bg-secondary p-3 text-center logreg-btn">Login</div>
    <div id="register_btn" class="col-sm-6 bg-secondary p-3 text-center logreg-btn">Register</div>
    <div class="col border-top p-5">
        <div id="message"></div>
        <form id="login_form" novalidate>
            <fieldset>
                <div class="form-group">
                    <label for="login_email">Email</label>
                    <input type="email" class="form-control" name="login_email" id="login_email">
                    <div class="text-danger small" id="login_email_err"></div>
                </div>
                <div class="form-group">
                    <label for="login_password">Password</label>
                    <input type="password" class="form-control" name="login_password" id="login_password" aria-describedby="emailHelp">
                    <div class="text-danger small" id="login_password_err"></div>
                </div>
                <div class="row">
                    <div class="col-6"><button type="submit" class="btn btn-block btn-primary">Login</button></div>
                    <div class="col-6"><button type="reset" class="btn btn-block btn-secondary">Reset Password</button></div>
                </div>
            </fieldset>
        </form>

        <form id="register_form" class="hide" novalidate>
            <fieldset>
                <div class="form-group">
                    <label for="register_name">Name</label>
                    <input type="text" class="form-control" name="register_name" id="register_name">
                    <div class="text-danger small" id="register_name_err"></div>
                </div>
                <div class="form-group">
                    <label for="register_email">Email address</label>
                    <input type="email" class="form-control" name="register_email" id="register_email">
                    <div class="text-danger small" id="register_email_err"></div>
                </div>
                <div class="form-group">
                    <label for="register_password">Password</label>
                    <input type="password" class="form-control" name="register_password" id="register_password">
                    <div class="text-danger small" id="register_password_err"></div>
                </div>
                <div class="form-group">
                    <label for="register_passconf">Confirm Password</label>
                    <input type="password" class="form-control" name="register_passconf" id="register_passconf">
                    <div class="text-danger small" id="register_passconf_err"></div>
                </div>
                <div class="form-group">
                    <label for="register_bday">Date of Birth</label>
                    <input type="date" class="form-control" name="register_bday" id="register_bday">
                    <div class="text-danger small" id="register_bday_err"></div>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </fieldset>
        </form>

        <form id="reset_form" class="hide" novalidate>
            <fieldset>
                <div class="form-group">
                    <label for="register_email">Email address</label>
                    <input type="email" class="form-control" name="reset_email" id="reset_email">
                    <div class="text-danger small" id="reset_email_err"></div>
                </div>
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </fieldset>
        </form>

    </div>
</div>

<?php } ?>

<script src="/js/logreg.js"></script>