<h3 class="font-light mb-2">Update <?= $name ?>'s role for this reservation</h3>
<form id="update_user_role_form">
    <div class="flex">
        <select class="w-full p-2 my-2 rounded" name="active" id="select_role">
            <option value="1" <?php if($role_id == 1): ?> selected="selected"<?php endif; ?>>Editor</option>
            <option value="2" <?php if($role_id == 2): ?> selected="selected"<?php endif; ?>>Member</option>
        </select>        
    </div>
    <input type="hidden" name="user_id" id="update_user_role_form_user_id" value="<?= $user_id ?>">
    <input type="hidden" name="res_id" id="update_user_role_form_res_id" value="<?= $res_id ?>">
    <input type="hidden" name="creator" id="update_user_role_form_creator" value="<?= $creator ?>">
    <input type="submit" value="Change role" class="cursor-pointer bg-primary-light hover:bg-primary text-grey-darkest text-white font-bold w-full py-2 mt-1 border border-primary-light rounded">
</form>