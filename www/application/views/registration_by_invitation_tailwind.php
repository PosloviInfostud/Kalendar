<div class="bg-white xs:rounded shadow">
    <div class="border-b py-8 text-black text-center text-xl uppercase">
        <span data-section="login" class="font-bold">Kreiraj svoj nalog</span>
    </div>

    <div class="bg-grey-lightest px-5 py-5 xs:px-10 xs:py-10">
        <!-- Registration form -->
        <form id="register_by_invite_form">
            <div class="mb-3">
                <input type="text" name="name" id="register_name" class="border w-full p-3 rounded" placeholder="Ime">
                <small id="register_name_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <div class="mb-3">
                <input type="email" name="email" id="register_email" class="border w-full p-3 rounded" value="<?= $email; ?>" disabled>
                <small id="register_email_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <div class="mb-3">
                <input type="password" name="password" id="register_password" class="border w-full p-3 rounded" placeholder="Šifra">
                <small id="register_password_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <div class="mb-6">
                <input type="password" name="password_confirm" id="register_password_confirm" class="border w-full p-3 rounded" placeholder="Potvrdi šifru">
                <small id="register_password_confirm_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <input type="hidden" name="token" value="<?= $token; ?>" id="token">
            <div class="flex">
                <button type="submit" id="register_invite_submit" class="cursor-pointer bg-primary hover:bg-primary-dark w-full p-4 text-sm text-white uppercase font-bold rounded">Registruj se</button>
            </div>
        </form>
    </div>
</div>

<div class="border-t px-10 py-6">
</div>