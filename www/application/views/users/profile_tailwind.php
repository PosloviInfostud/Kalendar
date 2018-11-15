<div class="max-w-md mx-auto">
        <!-- Content -->
        <div class="bg-white border-x sm:border-y sm:rounded px-4 py-8 sm:px-8 sm:py-6">
        <!-- Title -->
        <div class="flex flex-inline mb-6">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Moj profil</h1>
        </div>
        <!-- Buttons -->
        <div class="flex flex-inline">
                <button id="btn_edit_profile" class="user-edit hover:bg-primary text-grey text-sm hover:text-white mr-3 py-1 px-2 border-2 hover:border-primary rounded focus:outline-none" data-id="<?= $this->user_data['user']['id'] ?>">Izmeni</button>
        </div>
    </div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow mt-4 p-4 sm:p-8">
    <div>
        <div class="xs:flex py-1 mb-2">
            <div class="xs:w-1/4"><b>Ime:</b></div>
            <div class="xs:w-3/4"><?= $this->user_data['user']['name'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2">
            <div class="xs:w-1/4"><b>Email adresa:</b></div>
            <div class="xs:w-3/4"><?= $this->user_data['user']['email'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2">
            <div class="xs:w-1/4"><b>Član od:</b></div>
            <div class="xs:w-3/4"><?= $this->user_data['user']['created_at'] ?></div>
        </div>
        <div class="xs:flex py-1 mb-2">
            <div class="xs:w-1/4"><b>Obavesti me:</b></div>
            <div class="xs:w-3/4">
                <div class="mb-1">
                    <?php if($this->user_data['user']['not_create'] == 1) { ?>
                        <input type="checkbox" class="user_notify" name="not_create" data-user="<?= $this->user_data['user']['id'] ?>" checked="checked"> kada budem pozvan na sastanak
                    <?php } else { ?>
                        <input type="checkbox" class="user_notify" name="not_create" data-user="<?= $this->user_data['user']['id'] ?>"> kada budem pozvan na sastanak
                    <?php } ?>
                </div>
                <div class="mb-1">
                    <?php if($this->user_data['user']['not_update'] == 1) { ?>
                        <input type="checkbox" class="user_notify" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>" checked="checked"> kada se informacije u vezi sastanka ažuriraju ili se sastanak otkaže
                    <?php } else { ?>
                        <input type="checkbox" class="user_notify" name="not_update" data-user="<?= $this->user_data['user']['id'] ?>"> kada se informacije u vezi sastanka ažuriraju ili se sastanak otkaže
                    <?php } ?>
                </div>
                <div class="mb-1">
                    <?php if($this->user_data['user']['not_remind'] == 1) { ?>
                        <input type="checkbox" class="user_notify" name="not_remind" data-user="<?= $this->user_data['user']['id'] ?>" checked="checked"> da sastanak počinje za 15 minuta
                    <?php } else { ?>
                        <input type="checkbox" class="user_notify" name="not_remind" data-user="<?= $this->user_data['user']['id'] ?>"> da sastanak počinje za 15 minuta
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="hidden modal" id="editProfileModal">
        <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
            <div id="modal-content" class="relative p-4 sm:p-8 bg-white w-full max-w-sm m-auto flex-col flex rounded shadow">
                <span class="absolute pin-t pin-b pin-r p-4">
                    <svg class="close-modal h-6 w-6 text-grey hover:text-grey-darkest opacity-25" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
                <small id="insert_error_msg" class="text-danger"></small>
                <div id="edit_profile_modal_body"><!-- views/update_profile.php --></div>
            </div>
        </div>
</div>