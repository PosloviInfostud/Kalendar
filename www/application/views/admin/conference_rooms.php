<div class="row mt-5 mb-3">
    <div class="col-8"><h3>Conference Room List</h3></div>
    <!-- Button to trigger the modal -->
    <div class="col-4"><button class="btn btn-info btn-sm float-right" data-toggle="modal" data-target="#addNewRoomModal"><i class="fas fa-plus-circle mr-1"></i> Add new room</button></div>
</div>

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
                    <td class="align-middle text-center"><button class="btn btn-sm btn-info room-edit" data-id="<?= $room['id'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                    <td class="align-middle text-center"><?= $room['name'] ?></td>
                        <td class="align-middle"><?= $room['description'] ?></td>
                        <td class="align-middle text-center"><?= $room['capacity'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<!-- Add New Room Modal -->
<div class="modal fade" id="addNewRoomModal" tabindex="-1" role="dialog" aria-labelledby="addNewRoomModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add new room</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <small id="insert_error_msg" class="text-danger"></small>
        <form>
            <div class="form-group">
                <label for="room_name">Name <small class="text-muted">(required)</small></label>
                <input type="text" class="form-control" id="room_name" required>
            </div>
            <div class="form-group">
                <label for="room_description">Description</label>
                <textarea class="form-control" id="room_description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="room_capacity">Capacity <small class="text-muted">(required; between 4 and 50)</small></label>
                <input type="number" class="form-control" id="room_capacity" required min="4" max="50">
            </div>
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-info" id="new_room_btn">Create</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Room Modal -->
<div class="modal fade" id="editRoomModal" tabindex="-1" role="dialog" aria-labelledby="editRoomModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="RoomModalLongTitle">Edit conference room</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="edit_error_msg" class="text-danger"></small>
        <div id="edit_room_modal_body"></div>
      </div>
    </div>
  </div>
</div>