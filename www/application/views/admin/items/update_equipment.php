<form id="update_equipment_form" class="mt-8">
        <input type="hidden" name="id" id="update_equipment_id" value="<?= $equipment['id'] ?>">
    <div class="mt-2 mb-8">
        <label for="Name" class="font-light text-lg mb-2">Name</label>
        <input type="text" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" name="name" id="update_equipment_name" value="<?= $equipment['name'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <label for="Name" class="font-light text-lg mb-2">Barcode</label>
        <input type="text" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" name="barcode" id="update_equipment_barcode" value="<?= $equipment['barcode'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <label for="Description" class="font-light text-lg mb-2">Description</label>
        <textarea class="bg-grey-lighter font-light p-2 w-full border rounded" id="update_equipment_description" rows="3"><?= $equipment['description'] ?></textarea>
    </div>
    <div class="mt-2 mb-8">
        <label for="type" class="font-light text-lg mb-2">Type</label>
        <select class="w-full bg-grey-lighter p-2 font-light text-center border rounded" name="type" id="update_equipment_type">
            <?php foreach($types as $type) { ?>
            <option value="<?= $type['id'] ?>" <?php if($type['id'] == $equipment['equipment_type_id']): ?> selected="selected"<?php endif; ?>><?= ucwords($type['name']) ?></option>
            <?php } ?>
        </select>
    </div>
    <hr>
    <button type="submit" class="bg-blue hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-l">Update</button>
    <button id="cancel-edit_item_modal" class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-r">Cancel</button>
</form>