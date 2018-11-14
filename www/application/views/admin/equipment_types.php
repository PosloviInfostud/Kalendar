<!-- Breadcrumbs -->
<?php $this->load->view('/admin/equipment_arrows'); ?>
<!-- Content -->
<div class="flex">
    <div class="w-4/5">
        <h1 class="pl-2 mb-6 py-1 text-xl xs:text-2xl sm:text-3xl border-l-6 border-indigo">Vrste opreme</h1>
    </div>
    <!-- Button to trigger the modal -->
    <div class="w-1/5">
        <button id="show_add_new_type_modal" class="cursor-pointer w-full bg-indigo hover:bg-indigo-dark text-white font-bold text-sm py-3 px-4 rounded shadow">
            Dodaj novu vrstu opreme
        </button>
    </div>
</div>
<div id="messages"></div>
<!-- Check if there are any entries in the db -->
<?php if(empty($types)) {
        echo 'No entries';
} else { ?>
        <div class="overflow-auto">
            <table class="hidden pt-4 table stripe text-center w-full text-grey-darker text-sm">
                <thead class="bg-grey-light font-medium uppercase text-sm text-grey-dark border border-grey-light">
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Boja u kalendaru</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($types as $type) { ?> 
                        <tr>
                            <td><button class="edit_type_modal_btn cursor-pointer w-1/3 bg-indigo hover:bg-indigo-dark text-white text-sm py-1 px-2 rounded" data-id="<?= $type['id'] ?>"><i class="fas fa-pencil-alt"></i>Izmeni</button></td>
                            <td><?= $type['id'] ?></td>
                            <td><?= $type['name'] ?></td>
                            <td><input type="color" class="bg-grey-lighter w-1/3 h-6 border rounded" value="<?= $type['color'] ?>" disabled></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>z
<?php } ?>

<!-- Add New Equipment Type Modal -->
<div class="hidden modal" id="addNewTypeModal">
  <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
      <div id="modal-content" class="relative p-4 sm:p-8 bg-white w-full max-w-md m-auto flex-col flex rounded shadow">
          <span class="absolute pin-t pin-b pin-r p-4">
              <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-25" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
          </span>
          <small id="insert_error_msg" class="text-danger"></small>
          <form>
            <h2 class="pl-2 font-normal text-lg xs:text-xl sm:text-2xl border-l-4 mb-8 border-indigo">Nova oprema</h2>
            <div class="mt-2 mb-8">
                <label for="type_name" class="text-lg">Naziv vrste opreme <small class="text-grey-dark text-sm">(obavezno)</small></label>
                <input type="text" class="bg-grey-lighter mt-1 p-2 w-full font-light border rounded" id="type_name" required>
            </div>
            <div class="mt-2 mb-8">
                <label for="type_color" class="text-lg">Boja za kalendar <small class="text-grey-dark text-sm">(obavezno)</small></label>
                <input type="color" class="bg-grey-lighter font-light ml-4 mt-2 p-1 w-1/4 h-10 border rounded" id="type_color">
            </div>
          </form>  
          <button id="new_type_btn" class="w-full mr-2 bg-indigo hover:bg-indogo-dark text-white font-bold py-3 px-4 rounded">
              Kreiraj
          </button>
      </div>
  </div>
</div>

<!-- Edit Equipment Type Modal -->

<div class="hidden modal" id="editTypeModal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="relative p-16 bg-white w-full max-w-md m-auto flex-col flex rounded shadow">
            <span class="absolute pin-t pin-b pin-r p-4">
                <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <small id="insert_error_msg" class="text-danger"></small>
            <div id="edit_type_modal_body">
            </div>
        </div>
    </div>
</div>