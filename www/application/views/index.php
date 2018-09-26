<div class="container mt-3">
    <div class="row">
        <div id="show" class="col-9">

            <form id="register_form" class="border border-info rounded p-3 hide">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="form-group">

                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <form id="login_form" class="border border-primary rounded p-3">
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
            
        </div>
        <div class="col-3">
            <button class="btn btn-info btn-block" id="register_button">Register</button>
            <button class="btn btn-primary btn-block" id="login_button">Login</button>
        </div>
    </div>
</div>
<script src="/js/reglog.js"></script>
<script src="/js/login.js"></script>