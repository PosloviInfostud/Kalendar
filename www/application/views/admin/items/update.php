<div id="messages"></div>

<form id="update_item">
    <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="item_id" value="<?= $item['id'] ?>">
    </div>
    <div class="form-group">
        <label for="Name">Name</label>
        <input type="text" class="form-control" name="name" id="item_name" value="<?= $item['name'] ?>">
    </div>
    <div class="form-group">
        <label for="Description">Description</label>
        <textarea class="form-control" id="item_description" rows="3"><?= $item['description'] ?></textarea>
    </div>
    <div class="form-group row">
        <div class="col-auto">
        <label for="type">Type</label>
        <select class="form-control" name="type" id="select_type">
            <?php foreach($types as $type) { ?>
            <option value="<?= $type['id'] ?>" <?php if($type['id'] == $item['res_type_id']): ?> selected="selected"<?php endif; ?>><?= ucwords($type['name']) ?></option>
            <?php } ?>
        </select>
        </div>
    </div>
    <button type="submit" class="btn btn-info mt-3">Submit</button>
</form>