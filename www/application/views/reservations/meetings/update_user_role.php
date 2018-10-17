<div class="text-center">
    <form id="update_user_role_form">
        <h5>Update <?= $name ?>'s role for this reservation</h5>
        <div class="form-group col-6 text-center mx-auto">
            <select class="form-control" name="active" id="select_role">
                <option value="1" <?php if($role_id == 1): ?> selected="selected"<?php endif; ?>>Editor</option>
                <option value="2" <?php if($role_id == 2): ?> selected="selected"<?php endif; ?>>Member</option>
            </select>        
        </div>
        <input type="hidden" name="user_id" id="update_user_role_form_user_id" value="<?= $user_id ?>">
        <input type="hidden" name="res_id" id="update_user_role_form_res_id" value="<?= $res_id ?>">
        <input type="submit" value="Change role" class="btn btn-info col-6">
    </form>
</div>