<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/public/css/app.css">
    <title><?= $title_for_layout ?>Kalendar</title>
</head>
<body class="bg-grey-lighter text-base text-grey-darkest font-light font-sans relative">
    <div class="h-2 bg-primary"></div>
    <div class="container mx-auto sm:px-8 py-16 sm:py-32">
        <div class="mx-auto max-w-sm">
        <div id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
            <div class="bg-white rounded shadow">
                <div class="border-b py-8 font-bold text-black text-center text-xl uppercase">
                    <span data-section="login">Welcome back!</span>
                    <span data-section="register" class="hidden">Create your account</span>
                    <span data-section="forgot" class="hidden">Forgot your password?</span>
                </div>

                <div class="bg-grey-lightest px-10 py-10">
                    <div id="messages"></div>

                    <!-- Login form -->
                    <form id="login_form" data-section="login">
                        <div class="mb-3">
                            <input type="email" name="email" id="login_email" class="border w-full p-3" placeholder="E-Mail">
                        </div>
                        <div class="mb-6">
                            <input type="password" name="password" id="login_password" class="border w-full p-3" placeholder="**************">
                        </div>
                        <div class="flex">
                            <input type="submit" id="login_submit" value="Login" class="bg-primary hover:bg-primary-dark w-full p-4 text-sm text-white uppercase font-bold tracking-wider">
                        </div>
                    </form>

                    <!-- Registration form -->
                    <form id="register_form" data-section="register" class="hidden">
                        <div class="mb-3">
                            <input type="text" name="name" id="register_name" class="border w-full p-3" placeholder="Name">
                        </div>
                        <div class="mb-6">
                            <input type="email" name="email" id="register_email" class="border w-full p-3" placeholder="E-Mail">
                        </div>
                        <div class="mb-6">
                            <input type="password" id="register_password" class="border w-full p-3" placeholder="Password">
                        </div>
                        <div class="mb-6">
                            <input type="password" id="register_password_confirm" class="border w-full p-3" placeholder="Confirm password">
                        </div>
                        <div class="flex">
                            <input type="submit" id="register_submit" value="Register" class="bg-primary hover:bg-primary-dark w-full p-4 text-sm text-white uppercase font-bold tracking-wider">
                        </div>
                    </form>
                    
                    <!-- Reset password form -->
                    <form id="forgot_form" data-section="forgot" class="hidden">
                        <div class="mb-6">
                            <p class="mb-3">Please provide the email address that you used when you signed up for your account.</p>
                            <p class="mb-3">We will send you an email that will allow you to reset your password.</p>
                        </div>
                        <div class="mb-6">
                            <input type="email" name="email" id="reset_email" class="border w-full p-3" placeholder="E-Mail">
                        </div>
                        <div class="flex">
                            <input type="submit" id="reset_submit" value="Send verification email" class="bg-primary hover:bg-primary-dark w-full p-4 text-sm text-white uppercase font-bold tracking-wider">
                        </div>
                    </form>

                    
                </div>

                <div class="border-t px-10 py-6">
                    <div data-section="login">
                        <div class="flex justify-between">
                            <button data-link="register" class="font-bold text-primary hover:text-primary-dark no-underline">Don't have an account?</button>
                            <button data-link="forgot" class="text-grey-darkest hover:text-black no-underline">Forgot Password?</button>
                        </div>
                    </div>
                    <div data-section="register" class="hidden">
                        <div class="flex justify-between">
                            <button data-link="login" class="link_login font-bold text-primary hover:text-primary-dark no-underline">Back to Login</button>
                            <button data-link="forgot" class="link_forgot text-grey-darkest hover:text-black no-underline">Forgot Password?</button>
                        </div>
                    </div>
                    <div data-section="forgot" class="hidden">
                        <div class="hidden flex justify-between">
                            <button data-link="register" class="link_register font-bold text-primary hover:text-primary-dark no-underline">Don't have an account?</button>
                            <button data-link="register" class="link_login text-grey-darkest hover:text-black no-underline">Back to Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer section -->
    <script src="/public/js/app.js"></script>
</body>
</html>