<form id="update_item_form">
    <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="update_item_id" value="<?= $item['id'] ?>">
    </div>
    <div class="form-group">
        <label for="Name">Name</label>
        <input type="text" class="form-control" name="name" id="update_item_name" value="<?= $item['name'] ?>">
    </div>
    <div class="form-group">
        <label for="Description">Description</label>
        <textarea class="form-control" id="update_item_description" rows="3"><?= $item['description'] ?></textarea>
    </div>
    <div class="form-group row">
        <div class="col-auto">
        <label for="type">Type</label>
        <select class="form-control" name="type" id="update_item_type">
            <?php foreach($types as $type) { ?>
            <option value="<?= $type['id'] ?>" <?php if($type['id'] == $item['res_type_id']): ?> selected="selected"<?php endif; ?>><?= ucwords($type['name']) ?></option>
            <?php } ?>
        </select>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-block btn-info mt-3">Update</button>
</form>