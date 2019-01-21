<form id="update_user" class="mt-4">
    <h2 class="pl-2 font-normal text-lg xs:text-xl sm:text-2xl border-l-4 mb-8 border-indigo">Izmena podataka korisnika</h2>
    <input type="hidden" class="form-control" name="name" id="user_id" value="<?= $user['id'] ?>">
    <div class="mt-2 mb-8">
        <label for="Name" class="text-lg">Ime</label>
        <input type="text" class="w-full bg-grey-lighter mt-1 p-2 font-light border rounded" name="name" id="user_name" value="<?= $user['name'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <label for="Email" class="text-lg">Email adresa</label>
        <input type="email" class="w-full bg-grey-lighter mt-1 p-2 font-light border rounded" name="email" id="user_email" value="<?= $user['email'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <div class="sm:flex">
            <div class="sm:w-1/3 sm:flex sm:flex-inline sm:items-center">
                <label for="Role" class="text-lg">Uloga</label>
                <select class="bg-grey-lighter font-light ml-4 p-2 border rounded" name="role" id="select_role">
                    <?php foreach($roles as $role) { ?>
                    <option value="<?= $role['id'] ?>" <?php if($role['id'] == $user['user_role_id']): ?> selected="selected"<?php endif; ?>><?= ucwords($role['name']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="sm:w-2/3 sm:flex sm:flex-inline sm:items-center mt-4 sm:mt-0">
                <label for="Role" class="text-lg">Status naloga</label>
                <select class="bg-grey-lighter font-light ml-4 p-2 border rounded" name="active" id="select_active">
                    <option value="1" <?php if($user['active'] == 1): ?> selected="selected"<?php endif; ?>>Aktivan</option>
                    <option value="0" <?php if($user['active'] == 0): ?> selected="selected"<?php endif; ?>>Neaktivan</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="w-full mr-2 bg-indigo hover:bg-indogo-dark text-white font-bold py-3 px-4 rounded">Ažuriraj</button>
</form>