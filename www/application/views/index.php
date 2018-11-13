<div class="bg-white xs:rounded shadow">
    <div class="border-b py-8 text-black text-center text-xl uppercase">
        <span data-section="login" class="font-bold">Dobrodošli!</span>
        <span data-section="register" class="hidden font-bold">Kreiraj svoj nalog</span>
        <span data-section="forgot" class="hidden font-bold">Zaboravljena šifra?</span>
    </div>

    <div class="bg-grey-lightest px-5 py-5 xs:px-10 xs:py-10">
        <!-- Login form -->
        <form id="login_form" data-section="login">
            <div class="mb-3">
                <input type="email" name="email" id="login_email" class="border w-full p-3 rounded" placeholder="Tvoja email adresa">
                <small id="login_email_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <div class="mb-6">
                <input type="password" name="password" id="login_password" class="border w-full p-3 rounded" placeholder="*************">
                <small id="login_password_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <div class="flex">
                <input type="submit" id="login_submit" value="Prijavi se" class="cursor-pointer bg-primary hover:bg-primary-dark w-full p-4 text-sm text-white uppercase font-bold rounded">
            </div>
        </form>

        <!-- Registration form -->
        <form id="register_form" data-section="register" class="hidden">
            <div class="mb-3">
                <input type="text" name="name" id="register_name" class="border w-full p-3 rounded" placeholder="Ime">
                <small id="register_name_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <div class="mb-3">
                <input type="email" name="email" id="register_email" class="border w-full p-3 rounded" placeholder="Email adresa">
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
            <div class="flex">
                <input type="submit" id="register_submit" value="Registruj se" class="cursor-pointer bg-primary hover:bg-primary-dark w-full p-4 text-sm text-white uppercase font-bold rounded">
            </div>
        </form>
        
        <!-- Reset password form -->
        <form id="forgot_form" data-section="forgot" class="hidden">
            <div class="mb-6">
                <p class="mb-3">Unesi svoju email adresu.</p>
                <p class="mb-3">Biće ti poslat email da resetuješ svoju šifru.</p>
            </div>
            <div class="mb-6">
                <input type="email" name="email" id="forgot_email" class="border w-full p-3 rounded" placeholder="Email adresa">
                <small id="forgot_email_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <div class="flex">
                <input type="submit" id="forgot_submit" value="Pošalji email" class="cursor-pointer bg-primary hover:bg-primary-dark w-full p-4 text-sm text-white uppercase font-bold rounded">
            </div>
        </form>
    </div>

    <div class="border-t px-10 py-6">
        <div data-section="login">
            <div class="flex justify-between">
                <button data-link="register" class="font-bold text-primary hover:text-primary-dark no-underline">Nemaš nalog?</button>
                <button data-link="forgot" class="text-grey-darkest hover:text-black no-underline">Zaboravljena šifra?</button>
            </div>
        </div>
        <div data-section="register" class="hidden">
            <div class="flex justify-between">
                <button data-link="login" class="link_login font-bold text-primary hover:text-primary-dark no-underline">Povratak</button>
                <button data-link="forgot" class="link_forgot text-grey-darkest hover:text-black no-underline">Zaboravljena šifra?</button>
            </div>
        </div>
        <div data-section="forgot" class="hidden">
            <div class="hidden flex justify-between">
                <button data-link="register" class="link_register font-bold text-primary hover:text-primary-dark no-underline">Nemaš nalog?</button>
                <button data-link="login" class="link_login text-grey-darkest hover:text-black no-underline">Povratak</button>
            </div>
        </div>
    </div>
</div>