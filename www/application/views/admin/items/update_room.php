<form id="update_room_form" class="mt-4">
    <h2 class="pl-2 font-normal text-lg xs:text-xl sm:text-2xl border-l-4 mb-8 border-indigo">Update Conference Room Details</h2>
    <input type="hidden" name="id" id="update_room_id" value="<?= $room['id'] ?>">
    <div class="mt-2 mb-8">
        <label for="Name" class="text-lg">Name</label>
        <input type="text" class="w-full bg-grey-lighter mt-1 p-2 font-light border rounded" name="name" id="update_room_name" value="<?= $room['name'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <label for="Description" class="text-lg">Description</label>
        <textarea class="bg-grey-lighter font-light mt-1 p-2 w-full border rounded" id="update_room_description" rows="4"><?= $room['description'] ?></textarea>
    </div>
    <div class="mt-2 mb-4">
        <label for="capacity" class="text-lg">Capacity <small class="text-grey-dark text-sm">(required: between 4 and 50)</small></label>
        <input type="number" class="bg-grey-lighter font-light ml-4 p-2 border rounded" name="name" id="update_room_capacity" value="<?= $room['capacity'] ?>" min="4" max="50">
    </div>
    <div class="mt-2 mb-8">
        <label for="color" class="text-lg">Color for Calendar <small class="text-grey text-sm">(required)</small></label>
        <input type="color" class="w-20 bg-grey-lighter font-light ml-4 p-2 h-10 border rounded" id="update_room_color" value="<?= $room['color'] ?>">
    </div>
    <button type="submit" class="w-full mr-2 bg-indigo hover:bg-indogo-dark text-white font-bold py-3 px-4 rounded">Update</button>
</form>