<h3 class="mt-5 mb-3">Edit user</h3>

<div id="messages"></div>

<form id="update_user">
    <div class="form-group">
        <input type="hidden" class="form-control" name="name" id="user_id" value="<?= $user['id'] ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control" name="name" id="user_name" value="<?= $user['name'] ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" name="email" id="user_email" value="<?= $user['email'] ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Last Token</label>
        <input type="email" class="form-control" name="email" id="user_token" value="<?= $user['token'] ?>" disabled>
    </div>
    <!-- <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" class="form-control" id="register_password">
    </div>
    <div class="form-group">

        <label for="exampleInputPassword1">Confirm New Password</label>
        <input type="password" class="form-control" id="register_password_confirm">
    </div> -->
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script src="/js/admin.js"></script>