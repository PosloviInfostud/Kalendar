<form id="update_user">
    <div class="form-group">
        <input type="hidden" class="form-control" name="name" id="user_id" value="<?= $user['id'] ?>">
    </div>
    <div class="form-group">
        <label for="Name">Name</label>
        <input type="text" class="form-control" name="name" id="user_name" value="<?= $user['name'] ?>">
    </div>
    <div class="form-group">
        <label for="Email">Email address</label>
        <input type="email" class="form-control" name="email" id="user_email" value="<?= $user['email'] ?>">
    </div>
    <div class="form-group row">
        <div class="col-auto">
        <label for="Role">Role</label>
        <select class="form-control" name="role" id="select_role">
            <?php foreach($roles as $role) { ?>
            <option value="<?= $role['id'] ?>" <?php if($role['id'] == $user['user_role_id']): ?> selected="selected"<?php endif; ?>><?= ucwords($role['name']) ?></option>
            <?php } ?>
        </select>
        </div>
        <div class="col-auto">
        <label for="Role">Account Status</label>
        <select class="form-control" name="active" id="select_active">
            <option value="1" <?php if($user['active'] == 1): ?> selected="selected"<?php endif; ?>>Active</option>
            <option value="0" <?php if($user['active'] == 0): ?> selected="selected"<?php endif; ?>>Inactive</option>
        </select>
        </div>
    </div>
    <button type="submit" class="btn btn-info mt-3">Update</button>
</form>