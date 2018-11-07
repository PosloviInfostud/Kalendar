<div class="row mt-5 mb-3">
    <div class="col-8"><h3>Conference Room List</h3></div>
</div>
<div class="row mt-5 mb-3">
    <!-- Button to trigger the modal -->
    <div class="col-4"><button id="show_add_new_room_modal" class="cursor-pointer w-1/3 bg-primary hover:bg-primary-dark text-white font-bold text-sm py-2 my-2 px-4 rounded" data-toggle="modal" data-target="#addNewRoomModal"><i class="fas fa-plus-circle mr-1"></i> Add new room</button></div>
    

</div>
<div id="messages"></div>
<!-- Check if there are any entries in the db -->
<?php if(empty($rooms)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed table-striped border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Capacity</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($rooms as $room) { ?> 
                    <tr>
                        <td class="col-2 align-middle text-center"><button id="edit_room_modal" class="cursor-pointer w-1/3 bg-primary hover:bg-primary-dark text-white font-bold text-sm py-2 px-4 rounded" data-id="<?= $room['id'] ?>"><i class="fas fa-pencil-alt"></i>Edit</button></td>
                        <td class="col-2 align-middle text-center"><?= $room['name'] ?></td>
                        <td class="col-2 align-middle"><?= $room['description'] ?></td>
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
                        <label for="room_name" class="font-normal text-lg mb-2">Name <small class="text-muted">(required)</small></label>
                        <input type="text" class="bg-grey-lighter p-2 w-full font-light border rounded" id="room_name" required>
                    </div>
                    <div class="mt-2 mb-8">
                        <label for="room_description" class="font-normal text-lg mb-2">Description</label>
                        <textarea class="bg-grey-lighter font-light p-2 w-full border rounded" id="room_description" rows="3"></textarea>
                    </div>
                    <div class="mt-2 mb-8">
                        <label for="room_capacity" class="font-normal text-lg mb-2">Capacity <small class="text-muted">(required; between 4 and 50)</small></label>
                        <input type="number" class="bg-grey-lighter font-light p-2 w-full border rounded" id="room_capacity" required min="4" max="50">
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
