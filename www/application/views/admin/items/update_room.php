<form id="update_room_form">
    <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="update_room_id" value="<?= $room['id'] ?>">
    </div>
    <div class="form-group">
        <label for="Name">Name</label>
        <input type="text" class="form-control" name="name" id="update_room_name" value="<?= $room['name'] ?>">
    </div>
    <div class="form-group">
        <label for="Description">Description</label>
        <textarea class="form-control" id="update_room_description" rows="3"><?= $room['description'] ?></textarea>
    </div>
    <div class="form-group row">
        <div class="col-auto">
            <label for="capacity">Capacity</label>
            <input type="number" class="form-control" name="name" id="update_room_capacity" value="<?= $room['capacity'] ?>" min="4" max="50">
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-block btn-info mt-3">Update</button>
</form>