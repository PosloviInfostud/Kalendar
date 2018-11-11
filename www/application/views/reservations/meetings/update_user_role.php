<h3 class="pl-2 py-1 font-light text-lg sm:text-xl border-l-4 mb-6 border-primary">Update <?= $name ?>'s role for this reservation</h3>
<form id="update_user_role_form">
    <div class="flex">
        <select class="w-full p-2 my-2 bg-grey-lighter border rounded" name="active" id="select_role">
            <option value="1" <?php if($role_id == 1): ?> selected="selected"<?php endif; ?>>Editor</option>
            <option value="2" <?php if($role_id == 2): ?> selected="selected"<?php endif; ?>>Member</option>
        </select>        
    </div>
    <input type="hidden" name="user_id" id="update_user_role_form_user_id" value="<?= $user_id ?>">
    <input type="hidden" name="res_id" id="update_user_role_form_res_id" value="<?= $res_id ?>">
    <input type="hidden" name="creator" id="update_user_role_form_creator" value="<?= $creator ?>">
    <input type="submit" value="Change role" class="cursor-pointer bg-primary hover:bg-primary-dark text-grey-darkest text-white w-full py-2 mt-1 border border-primary-light rounded">
</form>