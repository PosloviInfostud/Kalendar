<div class="bg-white rounded shadow">
    <div class="border-b py-8 text-black text-center text-xl uppercase">
        <span data-section="login" class="font-bold">Reset Password</span>
    </div>
    
    <div class="bg-grey-lightest px-10 py-10">
        <form id="form_reset_password">
            <div class="mb-3">
                <input type="email" class="border w-full p-3" name="email" id="reset_password_email" value="<?= $email; ?>" disabled>
                <small id="reset_email_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <div class="mb-3">
                <input type="password" class="border w-full p-3" name="password" id="reset_password_password" placeholder="Your new password">
                <small id="reset_password_err" class="error_box text-xs text-red font-normal"></small>
            </div>
            <div class="mb-6">
                <input type="password" class="border w-full p-3" name="confirm" id="reset_password_confirm" placeholder="Confirm your new password">
                <small id="reset_confirm_err" class="error_box text-xs text-red font-normal"></small>
            </div>
                <input type="hidden" name="code" id="reset_password_code" value="<?= $code; ?>">
                <input type="submit" name="submit" id="reset_password_submit" class="cursor-pointer bg-primary hover:bg-primary-dark w-full p-4 text-sm text-white uppercase font-bold tracking-wider" value="Reset Password">
        </form>
    </div>
    <div class="border-t px-10 py-6">
        <div data-section="login">
            <div class="flex justify-end">
                <a href="/login"><button data-link="login" class="font-bold text-primary hover:text-primary-dark no-underline">Back to Login</button></a>
            </div>
        </div>
    </div>
</div>