<div class="row mt-5 mb-3">
    <div class="col-8"><h3>Equipment Types List</h3></div>
    <!-- Button to trigger the modal -->
    <div class="col-4">
      <button class="btn btn-info btn-sm float-right mx-1" data-toggle="modal" data-target="#addNewTypeModal"><i class="fas fa-plus-circle mr-1"></i> Add new type</button>
    </div>
</div>

<!-- Check if there are any entries in the db -->
<?php if(empty($types)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed table-striped border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($types as $type) { ?> 
                    <tr>
                        <td class="align-middle text-center"><button class="btn btn-sm btn-info type-edit" data-id="<?= $type['id'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                        <td class="align-middle text-center"><?= $type['id'] ?></td>
                        <td class="align-middle text-center"><?= $type['name'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<!-- Add New Equipment Type Modal -->
<div class="modal fade" id="addNewTypeModal" tabindex="-1" role="dialog" aria-labelledby="addNewTypeModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="typeModalLongTitle">Add new type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <small id="insert_error_msg" class="text-danger"></small>
        <form>
            <div class="form-group">
                <label for="type_name">Name <small class="text-muted">(required)</small></label>
                <input type="text" class="form-control" id="type_name" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-info" id="new_type_btn">Create</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Equipment Type Modal -->
<div class="modal fade" id="editTypeModal" tabindex="-1" role="dialog" aria-labelledby="editTypeModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="typeModalLongTitle">Edit type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="edit_error_msg" class="text-danger"></small>
        <div id="edit_type_modal_body"></div>
      </div>
    </div>
  </div>
</div>