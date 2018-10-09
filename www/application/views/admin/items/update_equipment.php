<form id="update_equipment_form">
    <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="update_equipment_id" value="<?= $equipment['id'] ?>">
    </div>
    <div class="form-group">
        <label for="Name">Name</label>
        <input type="text" class="form-control" name="name" id="update_equipment_name" value="<?= $equipment['name'] ?>">
    </div>
    <div class="form-group">
        <label for="Name">Barcode</label>
        <input type="text" class="form-control" name="barcode" id="update_equipment_barcode" value="<?= $equipment['barcode'] ?>">
    </div>
    <div class="form-group">
        <label for="Description">Description</label>
        <textarea class="form-control" id="update_equipment_description" rows="3"><?= $equipment['description'] ?></textarea>
    </div>
    <div class="form-group row">
        <div class="col-auto">
        <label for="type">Type</label>
        <select class="form-control" name="type" id="update_equipment_type">
            <?php foreach($types as $type) { ?>
            <option value="<?= $type['id'] ?>" <?php if($type['id'] == $equipment['equipment_type_id']): ?> selected="selected"<?php endif; ?>><?= ucwords($type['name']) ?></option>
            <?php } ?>
        </select>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-block btn-info mt-3">Update</button>
</form>