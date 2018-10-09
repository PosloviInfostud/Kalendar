<div class="row mt-5 mb-3">
    <div class="col-8"><h3>Equipment List</h3></div>
    <!-- Button to trigger the modal -->
    <div class="col-4">
      <button class="btn btn-secondary btn-sm float-right" data-toggle="modal" data-target="#addNewEquipmentTypeModal">New type</button>
      <button class="btn btn-info btn-sm float-right mx-1" data-toggle="modal" data-target="#addNewEquipmentModal"><i class="fas fa-plus-circle mr-1"></i> Add new item</button>
    </div>
</div>

<!-- Check if there are any entries in the db -->
<?php if(empty($equipment)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed table-striped border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($equipment as $item) { ?> 
                    <tr>
                        <td class="align-middle text-center"><button class="btn btn-sm btn-info equipment-edit" data-id="<?= $item['id'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                        <td class="align-middle text-center"><?= $item['name'] ?></td>
                        <td class="align-middle text-center"><?= ucwords($item['equipment_type_name']) ?></td>
                        <td class="align-middle text-center"><?= $item['barcode'] ?></td>
                        <td class="align-middle"><?= substr($item['description'], 0, 120).'...' ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<!-- Add New Equipment Modal -->
<div class="modal fade" id="addNewEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="addNewEquipmentModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="equipmentModalLongTitle">Add new equipment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <small id="insert_error_msg" class="text-danger"></small>
        <form>
            <div class="form-group">
                <label for="equipment_name">Name <small class="text-muted">(required)</small></label>
                <input type="text" class="form-control" id="equipment_name" required>
            </div>
            <div class="form-group">
                <label for="equipment_name">Barcode <small class="text-muted">(required)</small></label>
                <input type="text" class="form-control" id="equipment_barcode" required>
            </div>
            <div class="form-group">
                <label for="equipment_type">Type</label>
                <select class="form-control" id="equipment_type">
                <?php foreach($types as $type) { ?> 
                    <option value="<?= $type['id'] ?>"><?= ucwords($type['name']) ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="equipment_description">Description</label>
                <textarea class="form-control" id="equipment_description" rows="3"></textarea>
            </div>
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-info" id="new_equipment_btn">Create</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Equipment Modal -->
<div class="modal fade" id="editEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="editEquipmentModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="equipmentModalLongTitle">Edit equipment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="edit_error_msg" class="text-danger"></small>
        <div id="edit_equipment_modal_body"></div>
      </div>
    </div>
  </div>
</div>