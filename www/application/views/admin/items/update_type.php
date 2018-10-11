<form id="update_type_form">
    <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="update_type_id" value="<?= $type['id'] ?>">
    </div>
    <div class="form-group">
        <label for="Name">Name</label>
        <input type="text" class="form-control" name="name" id="update_type_name" value="<?= $type['name'] ?>">
    </div>
    <hr>
    <button type="submit" class="btn btn-block btn-info mt-3">Update</button>
</form>