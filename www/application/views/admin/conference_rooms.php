<!-- Breadcrumbs -->
<div class="flex text-sm text-black py-3 border-b mb-8">
    <span>Admin</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span>Items</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal">Conference rooms</span>
</div>
<!-- Content -->
<div class="flex">
    <div class="w-4/5">
        <h1 class="pl-2 mb-6 py-1 text-xl xs:text-2xl sm:text-3xl border-l-6 border-indigo">Conference Room List</h1>
    </div>
    <!-- Button to trigger the modal -->
    <div class="w-1/5">
        <button id="show_add_new_room_modal" class="cursor-pointer w-full bg-indigo hover:bg-indigo-dark text-white font-bold text-sm py-3 px-4 rounded shadow">
            Add new room
        </button>
    </div>
</div>
<div id="messages"></div>
<!-- Check if there are any entries in the db -->
<?php if(empty($rooms)) {
        echo 'No entries';
} else { ?>
        <table class="hidden pt-4 table stripe text-center w-full text-grey-darker text-sm">
            <thead class="bg-grey-light font-medium uppercase text-sm text-grey-dark border border-grey-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Colour</th>
                    <th>Capacity</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($rooms as $room) { ?> 
                <tr>
                    <td ><button class="edit_room_modal cursor-pointer w-1/3 bg-indigo hover:bg-indigo-dark text-white font-normsl text-sm py-1 px-2 rounded" data-id="<?= $room['id'] ?>"><i class="fas fa-pencil-alt"></i>Edit</button></td>
                    <td ><?= $room['name'] ?></td>
                    <td ><?= $room['description'] ?></td>
                    <td ><input type="color" class="w-1/2 border rounded" value="<?= $room['color'] ?>" disabled></td>
                    <td ><?= $room['capacity'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<!-- Add New Room Modal -->
<div class="hidden modal" id="addNewRoomModal">
        <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
            <div id="modal-content" class="relative p-4 sm:p-8 bg-white w-full max-w-md m-auto flex-col flex rounded shadow">
                <span class="absolute pin-t pin-b pin-r p-4">
                    <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-25" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
                <small id="insert_error_msg" class="hidden bg-red-lightest text-red text-sm my-4 p-4 border-l-6 border-red-lighter"></small>
                <form>
                    <h2 class="pl-2 font-normal text-lg xs:text-xl sm:text-2xl border-l-4 mb-8 border-indigo">Add New Conference Room</h2>
                    <div class="mt-2 mb-8">
                        <label for="room_name" class="text-lg">Name <small class="text-grey-dark text-sm">(required)</small></label>
                        <input type="text" class="bg-grey-lighter mt-1 p-2 w-full font-light border rounded" id="room_name" required>
                    </div>
                    <div class="mt-2 mb-8">
                        <label for="room_description" class="text-lg">Description</label>
                        <textarea class="bg-grey-lighter font-light mt-1 p-2 w-full border rounded" id="room_description" rows="3"></textarea>
                    </div>
                    <div class="mt-2 mb-4">
                        <label for="room_capacity" class="text-lg">Capacity <small class="text-grey-dark text-sm">(required: between 4 and 50)</small></label>
                        <input type="number" class="bg-grey-lighter font-light ml-4 mt-1 p-2 border rounded" id="room_capacity" required min="4" max="50">
                    </div>
                    <div class="mt-2 mb-8">
                        <label for="room_color" class="text-lg">Color for Calendar <small class="text-grey-dark text-sm">(required)</small></label>
                        <input type="color" class="w-20 bg-grey-lighter font-light ml-4 mt-1 p-2 h-10 border rounded" id="room_color">
                    </div>
                </form>  
                <button id="new_room_btn" class="w-full mr-2 bg-indigo hover:bg-indogo-dark text-white font-bold py-3 px-4 rounded">
                    Create
                </button>
            </div>
        </div>
</div>

<!-- Edit Room Modal -->

<div class="hidden modal" id="editRoomModal">
        <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
            <div id="modal-content" class="relative p-4 sm:p-8 bg-white w-full max-w-md m-auto flex-col flex rounded shadow">
                <span class="absolute pin-t pin-b pin-r p-4">
                    <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-25" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
                <small id="insert_error_msg" class="text-danger"></small>
                <div id="edit_room_modal_body">
                </div>
            </div>
        </div>
</div>
