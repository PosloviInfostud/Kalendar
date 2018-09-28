<div class="container mt-3">
    <div class="row">
        <div id="show" class="col-9">
            <div id="messages">
            <?php if(!empty($this->session->userdata['message'])) {
                echo $this->session->userdata['message'];
                $this->session->unset_userdata('message');
            } ?>
            </div>

            <form id="register_form" class="border border-info rounded p-3 hide">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" id="register_name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" id="register_email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="register_password">
                </div>
                <div class="form-group">

                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" id="register_password_confirm">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <form id="login_form" class="border border-primary rounded p-3 hide">
            <button id="forgot_button" type="reset" class="btn btn-warning btn-block p-2">Forgot your password?</button><br>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="email" name="email" id="login_email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password" name="password" id="password">Password</label>
                    <input type="password" name="password" id="login_password" class="form-control">
                </div>
                <input type="submit" id="login_submit" class="btn btn-primary">
            </form>

            <form id="forgot_form" class="border border-warning rounded p-3 hide">
                <div class="form-group">
                    <label for="email">Please, enter your E-Mail so we can send you link to reset your password!</label><br>
                    <input type="email" class="form-control" name="email" id="forgot_email">
                </div>
                <input type="submit" name="submit" id="forgot_submit" class="btn btn-warning btn-block" value="Reset Password">
            </form>

            <div id="welcome">
            <?php 
            $this->load->helper('cookie');
            $cookie = $this->input->cookie('usr-vezba',true);
            if(!empty($this->session->userdata[$cookie])) { ?>
            <p>Welcome, <?= $this->session->userdata[$cookie]; ?>!</p>

            <?php } else { ?>
            <p>Welcome! Please, login in to proceed!</p>
            <?php } ?>
            </div>
            
        </div>
        <div class="col-3">
            <button class="btn btn-info btn-block" id="register_button">Register</button>
            <button class="btn btn-primary btn-block" id="login_button">Login</button>
        </div>
    </div>
</div>
<script src="/js/reglog.js"></script>