<form id="update_equipment_form" class="mt-4">
    <h2 class="pl-2 font-normal text-lg xs:text-xl sm:text-2xl border-l-4 mb-8 border-indigo">Update Item Details</h2>
    <input type="hidden" name="id" id="update_equipment_id" value="<?= $equipment['id'] ?>">
    <div class="mt-2 mb-8">
        <label for="Name" class="text-lg">Name <small class="text-grey-dark text-sm">(required)</small></label>
        <input type="text" class="w-full bg-grey-lighter mt-1 p-2 font-light border rounded" name="name" id="update_equipment_name" value="<?= $equipment['name'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <label for="type" class="text-lg">Type</label>
        <select class="w-full bg-grey-lighter mt-1 p-2 font-light border rounded" name="type" id="update_equipment_type">
            <?php foreach($types as $type) { ?>
            <option value="<?= $type['id'] ?>" <?php if($type['id'] == $equipment['equipment_type_id']): ?> selected="selected"<?php endif; ?>><?= ucwords($type['name']) ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="mt-2 mb-8">
        <label for="Name" class="text-lg">Barcode <small class="text-grey-dark text-sm">(required)</small></label>
        <input type="text" class="w-full bg-grey-lighter mt-1 p-2 font-light border rounded" name="barcode" id="update_equipment_barcode" value="<?= $equipment['barcode'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <label for="Description" class="text-lg">Description</label>
        <textarea class="bg-grey-lighter font-light mt-1 p-2 w-full border rounded" id="update_equipment_description" rows="3"><?= $equipment['description'] ?></textarea>
    </div>
    <button type="submit" class="w-full mr-2 bg-indigo hover:bg-indogo-dark text-white font-bold py-3 px-4 rounded">Update</button>
</form>