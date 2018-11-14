<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/src/img/favicon.ico" type="image/x-icon">
    <link href="/public/css/font.css" rel="stylesheet">
    <script src="/scripts/jquery.min.js"></script>
    <?= $this->layouts->print_header_includes() ?>
    <link rel="stylesheet" href="/public/css/app.css">
    <link rel="stylesheet" href="/style/style.css">
    <title><?= $title_for_layout ?>Kalendar</title>
</head>
<body class="font-sans bg-grey-lighter font-light">
<!-- Back to top button -->
<a id="back_to_top_btn" class="hidden cursor-pointer fixed bg-smoke hover:bg-smoke-dark m-2 sm:m-8 h-10 w-10 sm:h-12 sm:w-12 pin-b pin-r pin-4 z-50 rounded"></a>
<!-- Navigation -->
    <div>
        <div class="bg-primary-darkest">
            <div class="sm:container mx-auto px-2 xs:px-4">
                <div class="flex items-center sm:justify-between py-4">
                    <div class="w-1/4 sm:hidden">
                        <div class="fill-current h-6 w-6 text-grey-light cursor-pointer" id="phone_menu_btn">
                            <?= file_get_contents("public/icons/menu.svg") ?>
                        </div>
                    </div>
                    <div class="w-1/2 sm:w-auto text-lg text-center text-grey-light font-medium tracking-wide uppercase">
                        <a href="/" class="no-underline">
                            <div class="xs:flex xs:items-baseline text-white">
                                Kalendar
                                <span class="block text-xs text-primary-dark xs:ml-2px">infostud</span>
                            </div>
                        </a>
                    </div>
                    <div class="w-1/4 sm:w-auto sm:flex text-right">
                        <div class="flex justify-end">
                        <?php if($this->user_data['user']['user_role_id'] == 1) { ?>
                            <a href="/admin" class="no-underline text-grey-light hover:text-primary">
                                <div class="flex justify-end">
                                    <div class="fill-current h-5 w-5 xs:h-6 xs:w-6 mr-2 xs:mr-4 sm:mr-0">
                                       <?= file_get_contents("public/icons/cog.svg") ?>
                                    </div>
                                    <div class="hidden sm:block sm:flex sm:items-center ml-1 mr-6">
                                       <span class="text-sm">Admin panel</span>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                            <a href="/korisnik/nalog" class="no-underline text-grey-light hover:text-primary">
                                <div class="flex justify-end">
                                    <div class="fill-current h-5 w-5 xs:h-6 xs:w-6 mr-2 xs:mr-4 sm:mr-0">
                                        <?= file_get_contents("public/icons/user.svg") ?>
                                    </div>
                                    <div class="hidden sm:block sm:flex sm:items-center ml-1 mr-6">
                                        <span class="text-sm">Nalog</span>
                                    </div>
                                </div>
                            </a>
                            <a href="/logout" class="no-underline text-grey-light hover:text-primary">
                                <div class="flex justify-end">
                                    <div class="fill-current h-5 w-5 xs:h-6 xs:w-6">
                                        <?= file_get_contents("public/icons/exit.svg") ?>
                                    </div>
                                    <div class="hidden sm:block sm:flex sm:items-center ml-1">
                                        <span class="text-sm">Odjava</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-1 bg-primary sm:hidden"></div>

        <!-- Secondary Nav -->
        <div class="hidden bg-primary-darkest sm:block sm:bg-primary border-b border-primary-dark" id="secondary_nav">
            <div class="mx-auto max-w-2/5xl px-4 py-4 sm:py-0 sm:-mb-px">
                <div class="sm:flex justify-between text-center">
                    <div class="sm:flex text-sm">
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                        <?php $text_meetings = $_SERVER['REQUEST_URI'] == '/rezervacije/sastanci' ? 'text-white font-normal border-primary-dark' : 'text-grey-light' ?>
                            <a href="/rezervacije/sastanci" class="<?= $text_meetings ?> no-underline flex items-center py-4 sm:border-b-4 border-transparent hover:border-primary-dark hover:text-white">
                                <div class="fill-current h-5 w-5 mr-2">
                                    <?= file_get_contents("public/icons/users.svg") ?>
                                </div>
                                Sastanci
                            </a>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                        <?php $text_equipment = $_SERVER['REQUEST_URI'] == '/rezervacije/oprema' ? 'text-white font-normal border-primary-dark' : 'text-grey-light' ?>

                            <a href="/rezervacije/oprema" class="<?= $text_equipment ?> no-underline flex items-center py-4 sm:border-b-4 border-transparent hover:border-primary-dark hover:text-white">
                            <div class="fill-current h-5 w-5 mr-2">
                                <?= file_get_contents("public/icons/laptop-phone.svg") ?>
                            </div>
                                Oprema
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center text-sm z-40 relative group justify-center">
                    <?php if(strpos($_SERVER["REQUEST_URI"], 'sastanci') !== false) { ?>
                        <button id="new_reservation" class="w-auto bg-transparent hover:bg-white text-white sm:font-normal py-2 px-4 md:px-8 my-2 md:mt-2 border-2 border-white hover:text-primary hover:border-transparent hover:bg-white rounded">
                            Kreiraj novi sastanak
                        </button>
                        <div id="new_reservation_options" class="hidden sm:hover:inline-block sm:group-hover:inline-block bg-white text-primary shadow-md absolute mt-12 pin-t pin-l w-full border rounded">
                            <ul class="list-reset">
                                <li><a href="/rezervacije/sastanci/kreiraj/datum" class="no-underline px-4 py-2 block text-sm font-normal text-primary hover:bg-grey-lighter">po slobodnom terminu</a></li>
                                <li><a href="/rezervacije/sastanci/kreiraj/sala" class="no-underline px-4 py-2 block text-sm font-normal text-primary hover:bg-grey-lighter">po salama</a></li>
                            </ul>
                        </div>
                    <?php } elseif(strpos($_SERVER["REQUEST_URI"], 'oprema') !== false) { ?>
                        <button id="new_reservation" class="w-auto bg-transparent hover:bg-white text-white py-2 px-4 md:px-8 my-2 md:mt-2 border-2 border-white hover:text-primary hover:border-transparent hover:bg-white rounded">
                            Rezerviši novi artikal
                        </button>
                        <div id="new_reservation_options" class="hidden sm:hover:inline-block sm:group-hover:inline-block bg-white text-primary shadow-md absolute mt-12 pin-t pin-l w-full border rounded">
                            <ul class="list-reset">
                                <li><a href="/rezervacije/oprema/kreiraj/datum" class="no-underline px-4 py-2 block text-primary hover:bg-grey-lighter">po slobodnom terminu</a></li>
                                <li><a href="/rezervacije/oprema/kreiraj/artikal" class="no-underline px-4 py-2 block text-primary hover:bg-grey-lighter">po artiklima</a></li>
                            </ul>
                        </div>
                        <?php } else { ?>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Content section :: container replacement -->
    <div class="mx-auto max-w-2/5xl sm:px-4 py-4">
        <!-- Flash notifications -->
        <div class="max-w-md mx-auto">
            <div id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
            <!-- Error messages -->
            <div id="alert_box" class="hidden">
                <div class="bg-red-alert border-l-4 border-red text-red-dark p-4 mb-5 mt-1 shadow relative" role="alert">
                    <p class="font-bold uppercase mb-2">Attention</p>
                    <p id="messages"></p>
                    <span class="absolute pin-t pin-b pin-r px-4 py-3">
                        <svg id="close_alert" class="fill-current h-6 w-6 text-red opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            </div>
        </div>
        <!-- Breadcrumbs -->
        <?php $this->load->view('/partials/breadcrumbs'); ?>
        <?= $content_for_layout ?>
    </div>
    <!-- Footer section -->
    <?= $this->layouts->print_footer_includes() ?>
    <script src="/js/reservations.js"></script>
    </body>
</html>