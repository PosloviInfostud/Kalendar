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
        <table class="hidden table table-text-sm table-condensed stripe border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Colour</th>
                    <th scope="col">Capacity</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($rooms as $room) { ?> 
                    <tr>
                        <td class="col-2 align-middle text-center"><button class="edit_room_modal cursor-pointer w-1/3 bg-indigo hover:bg-indigo-dark text-white font-bold text-sm py-2 px-4 rounded" data-id="<?= $room['id'] ?>"><i class="fas fa-pencil-alt"></i>Edit</button></td>
                        <td class="col-2 align-middle text-center"><?= $room['name'] ?></td>
                        <td class="col-2 align-middle"><?= $room['description'] ?></td>
                        <td class="col-2 align-middle"><input type="color" class="bg-grey-lighter font-light ml-4 mt-2 p-1 w-1/2 h-10 border rounded" value="<?= $room['color'] ?>" disabled></td>
                        <td class="col-2 align-middle text-center"><?= $room['capacity'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<!-- Add New Room Modal -->
<div class="hidden" id="addNewRoomModal">
        <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
            <div id="modal-content" class="relative p-16 bg-white w-full max-w-md m-auto flex-col flex">
                <span class="absolute pin-t pin-b pin-r p-4">
                    <svg id="close-modal" class="h-12 w-12 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
                <small id="insert_error_msg" class="text-danger"></small>
                <form>
                    <div class="mt-2 mb-8">
                        <label for="room_name" class="font-light text-lg mb-2">Name <small class="text-muted">(required)</small></label>
                        <input type="text" class="bg-grey-lighter p-2 w-full font-light border rounded" id="room_name" required>
                    </div>
                    <div class="mt-2 mb-8">
                        <label for="room_description" class="font-light text-lg mb-2">Description</label>
                        <textarea class="bg-grey-lighter font-light p-2 w-full border rounded" id="room_description" rows="3"></textarea>
                    </div>
                    <div class="mt-2 mb-8">
                        <label for="room_capacity" class="font-light text-lg mb-2">Capacity <br><small class="text-grey text-sm">(required; between 4 and 50)</small></label>
                        <input type="number" class="bg-grey-lighter font-light ml-4 py-2 w-auto border rounded" id="room_capacity" required min="4" max="50">
                    </div>
                    <div class="mt-2 mb-8">
                        <label for="room_color" class="font-light text-lg mb-2">Color for Calendar <br><small class="text-grey text-sm">(required)</small></label>
                        <input type="color" class="bg-grey-lighter font-light ml-4 mt-2 p-1 w-1/4 h-10 border rounded" id="room_color">
                    </div>
                </form>  
            <div class="inline-flex">
                <button id="new_room_btn" class="bg-blue hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-l">
                    Create
                </button>
                <button id="cancel-modal" class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-r">
                    Cancel
                </button>
            </div>
            </div>
        </div>
</div>

<!-- Edit Room Modal -->

<div class="hidden" id="editRoomModal">
        <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
            <div id="modal-content" class="relative p-16 bg-white w-full max-w-md m-auto flex-col flex">
                <span class="absolute pin-t pin-b pin-r p-4">
                    <svg id="close-edit_modal" class="h-12 w-12 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
                <small id="insert_error_msg" class="text-danger"></small>
                <div id="edit_room_modal_body">
                </div>
            </div>
        </div>
</div>
