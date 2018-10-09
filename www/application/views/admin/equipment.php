<div class="row mt-5 mb-3">
    <div class="col-8"><h3>Equipment List</h3></div>
    <!-- Button to trigger the modal -->
    <div class="col-4"><button class="btn btn-info float-right" data-toggle="modal" data-target="#addNewItemModal"><i class="fas fa-plus-circle mr-1"></i> Add new item</button></div>
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
                        <td class="align-middle text-center"><button class="btn btn-sm btn-info item-edit" data-id="<?= $item['id'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                        <td class="align-middle text-center"><?= $item['name'] ?></td>
                        <td class="align-middle text-center"><?= ucwords($item['equipment_type_name']) ?></td>
                        <td class="align-middle text-center"><?= $item['barcode'] ?></td>
                        <td class="align-middle"><?= substr($item['description'], 0, 120).'...' ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<!-- Add New Item Modal -->
<div class="modal fade" id="addNewItemModal" tabindex="-1" role="dialog" aria-labelledby="addNewItemModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add new item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <small id="insert_error_msg" class="text-danger"></small>
        <form>
            <div class="form-group">
                <label for="item_name">Name <small class="text-muted">(required)</small></label>
                <input type="text" class="form-control" id="item_name" required>
            </div>
            <div class="form-group">
                <label for="item_type">Type</label>
                <select class="form-control" id="item_type">
                <?php foreach($types as $type) { ?> 
                    <option value="<?= $type['id'] ?>"><?= ucwords($type['name']) ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="item_description">Description</label>
                <textarea class="form-control" id="item_description" rows="3"></textarea>
            </div>
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-info" id="new_item_btn">Create</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="edit_error_msg" class="text-danger"></small>
        <div id="edit_item_modal_body"></div>
      </div>
    </div>
  </div>
</div>