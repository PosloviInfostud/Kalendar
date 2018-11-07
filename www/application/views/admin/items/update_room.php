<form id="update_room_form" class="mt-8">
        <input type="hidden" name="id" id="update_room_id" value="<?= $room['id'] ?>">
    <div class="mt-2 mb-8">
        <label for="Name" class="font-normal text-lg mb-2">Name</label>
        <input type="text" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" name="name" id="update_room_name" value="<?= $room['name'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <label for="Description">Description</label>
        <textarea class="bg-grey-lighter font-light p-2 w-full border rounded" id="update_room_description" rows="3"><?= $room['description'] ?></textarea>
    </div>
    <div class="mt-2 mb-8 row">
        <div class="col-auto">
            <label for="capacity" class="font-normal text-lg mb-2">Capacity</label>
            <input type="number" class="bg-grey-lighter font-light p-2 w-full border rounded" name="name" id="update_room_capacity" value="<?= $room['capacity'] ?>" min="4" max="50">
        </div>
    </div>
    <hr>
    <button type="submit" class="bg-blue hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-l">Update</button>
    <button id="cancel-edit_modal" class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-r">Cancel</button>
</form>