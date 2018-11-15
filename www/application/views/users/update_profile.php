<form id="update_profile" class="mt-4">
    <h2 class="pl-2 font-normal text-lg xs:text-xl sm:text-2xl border-l-4 mb-8 border-indigo">Izmeni podatke</h2>
    <input type="hidden" class="form-control" name="name" id="user_id" value="<?= $user['id'] ?>">
    <div class="mt-2 mb-8">
        <label for="Name" class="text-lg">Ime</label>
        <input type="text" class="w-full bg-grey-lighter mt-1 p-2 font-light border rounded" name="name" id="user_name" value="<?= $user['name'] ?>">
    </div>
    <div class="mt-2 mb-8">
        <label for="Email" class="text-lg">Email adresa</label>
        <input type="email" class="w-full bg-grey-lighter mt-1 p-2 font-light border rounded" name="email" id="user_email" value="<?= $user['email'] ?>">
    </div>
    </div>
    <button type="submit" class="w-full mr-2 bg-indigo hover:bg-indogo-dark text-white font-bold py-3 px-4 rounded">Ažuriraj</button>
</form>