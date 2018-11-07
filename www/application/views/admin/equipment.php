<div class="row mt-5 mb-3">
    <div class="col-8"><h3>Items List</h3></div>
    <!-- Button to trigger the modal -->
    <div class="col-4">
      <button id="show_add_new_item_modal" class="cursor-pointer w-1/3 bg-indigo hover:bg-indigo-dark text-white font-bold text-sm py-2 my-2 px-4 rounded"><i class="fas fa-plus-circle mr-1"></i> Add new item</button>
    </div>
</div>

<!-- Check if there are any entries in the db -->
<?php if(empty($equipment)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed stripe border">
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
                        <td class="align-middle text-center"><button class="edit_item_btn cursor-pointer w-1/3 bg-indigo hover:bg-indigo-dark text-white font-bold text-sm py-2 px-4 rounded" data-id="<?= $item['id'] ?>"><i class="fas fa-pencil-alt"></i>Edit</button></td>
                        <td class="align-middle text-center"><?= $item['name'] ?></td>
                        <td class="align-middle text-center"><?= $item['equipment_type_name'] ?></td>
                        <td class="align-middle text-center"><?= $item['barcode'] ?></td>
                        <td class="align-middle"><?= $item['description'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<!-- Add New Equipment Modal -->
<div class="hidden" id="addNewItemModal">
  <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
      <div id="modal-content" class="relative p-16 bg-white w-full max-w-md m-auto flex-col flex">
          <span class="absolute pin-t pin-b pin-r p-4">
              <svg id="close-addNewItemModal" class="h-12 w-12 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
          </span>
          <small id="insert_error_msg" class="text-danger"></small>
          <form>
              <div class="mt-2 mb-8">
                  <label for="equipment_name" class="font-light text-lg mb-2">Name <small class="text-grey text-sm">(required)</small></label>
                  <input type="text" class="bg-grey-lighter p-2 w-full font-light border rounded" id="equipment_name" required>
              </div>
              <div class="mt-2 mb-8">
                <label for="equipment_type">Type</label>
                <select class="bg-grey-lighter p-2 w-full font-light border rounded" id="equipment_type">
                <?php foreach($types as $type) { ?> 
                    <option value="<?= $type['id'] ?>"><?= ucwords($type['name']) ?></option>
                <?php } ?>
                </select>
            </div>
              <div class="mt-2 mb-8">
                <label for="equipment_barcode" class="font-light text-lg mb-2">Barcode <small class="text-grey text-sm">(required)</small></label>
                <input type="text" class="bg-grey-lighter p-2 w-full font-light border rounded" id="equipment_barcode" required>
              </div>
              <div class="mt-2 mb-8">
                  <label for="equipment_description" class="font-light text-lg mb-2">Description</label>
                  <textarea class="bg-grey-lighter font-light p-2 w-full border rounded" id="equipment_description" rows="3"></textarea>
              </div>
          </form>  
      <div class="inline-flex">
          <button id="new_equipment_btn" class="bg-blue hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-l">
              Create
          </button>
          <button id="cancel-addNewItemModal" class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-r">
              Cancel
          </button>
      </div>
      </div>
  </div>
</div>


<!-- Edit Equipment Modal -->

<div class="hidden" id="editItemModal">
  <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
      <div id="modal-content" class="relative p-16 bg-white w-full max-w-md m-auto flex-col flex">
          <span class="absolute pin-t pin-b pin-r p-4">
              <svg id="close-edit_item_modal" class="h-12 w-12 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
          </span>
          <small id="insert_error_msg" class="text-danger"></small>
          <div id="edit_item_modal_body">
          </div>
      </div>
  </div>
</div>