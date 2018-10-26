<div class="text-center">
    <form id="update_notifications_form">
        <h5>Do you want to receive email notifications?</h5>
        <div class="form-group col-6 text-center mx-auto">
            <select class="form-control" name="notify" id="update_notifications_form_notify">
                <option value="1" <?php if($notify == 1): ?> selected="selected"<?php endif; ?>>Yes</option>
                <option value="0" <?php if($notify == 0): ?> selected="selected"<?php endif; ?>>No</option>
            </select>        
        </div>
        <input type="hidden" name="user_id" id="update_notifications_form_user_id" value="<?= $user ?>">
        <input type="submit" value="Change" class="btn btn-info col-6">
    </form>
</div>