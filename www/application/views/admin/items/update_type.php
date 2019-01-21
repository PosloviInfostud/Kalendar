<form id="update_type_form">
        <input type="hidden" name="id" id="update_type_id" value="<?= $type['id'] ?>">
    <div class="mt-2 mb-8">
        <label for="Name" class="font-light text-lg mb-2">Ime</label>
        <input type="text" class="bg-grey-lighter p-2 w-full font-light border rounded" name="name" id="update_type_name" value="<?= $type['name'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <label for="update_type_color" class="font-light text-lg mb-2">Boja za kalendar <br><small class="text-grey text-sm">(obavezno)</small></label>
        <input type="color" class="bg-grey-lighter font-light ml-4 mt-2 p-1 w-1/4 h-10 border rounded" id="update_type_color" value="<?= $type['color'] ?>">
    </div>
    <hr>
    <button type="submit" class="bg-blue hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-l">Ažuriraj</button>
    <button id="cancel-edit_type_modal" class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-r">Otkaži</button>
</form>