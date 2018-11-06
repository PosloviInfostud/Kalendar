<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <?= $this->layouts->print_header_includes() ?>
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/public/css/app.css">
    <title><?= $title_for_layout ?>Kalendar</title>
</head>
<body class="font-sans bg-grey-lighter font-light">
<!-- Navigation -->
    <div>
        <div class="bg-primary-darkest">
            <div class="sm:container mx-auto px-4">
                <div class="flex items-center sm:justify-between py-4">
                    <div class="w-1/4 sm:hidden">
                        <div class="fill-current h-6 w-6 text-grey-light cursor-pointer" id="phone_menu_btn">
                            <?= file_get_contents("public/icons/menu.svg") ?>
                        </div>
                    </div>
                    <div class="w-1/2 sm:w-auto text-lg text-center text-grey-light font-medium tracking-wide uppercase">
                        Kalendar <span class="text-xs text-primary-dark">infostud</span>
                    </div>
                    <div class="w-1/4 sm:w-auto sm:flex text-right">
                        <div class="flex justify-end">
                        <?php if($this->user_data['user']['user_role_id'] == 1) { ?>
                            <a href="/admin" class="no-underline text-grey-light hover:text-primary">
                                <div class="flex justify-end">
                                    <div class="fill-current h-6 w-6 mr-4 sm:mr-0">
                                       <?= file_get_contents("public/icons/cog.svg") ?>
                                    </div>
                                    <div class="hidden sm:block sm:flex sm:items-center ml-1 mr-6">
                                       <span class="text-sm">Admin area</span>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                            <a href="/profile" class="no-underline text-grey-light hover:text-primary">
                                <div class="flex justify-end">
                                    <div class="fill-current h-6 w-6 mr-4 sm:mr-0">
                                        <?= file_get_contents("public/icons/user.svg") ?>
                                    </div>
                                    <div class="hidden sm:block sm:flex sm:items-center ml-1 mr-6">
                                        <span class="text-sm">Profile</span>
                                    </div>
                                </div>
                            </a>
                            <a href="/logout" class="no-underline text-grey-light hover:text-primary">
                                <div class="flex justify-end">
                                    <div class="fill-current h-6 w-6">
                                        <?= file_get_contents("public/icons/exit.svg") ?>
                                    </div>
                                    <div class="hidden sm:block sm:flex sm:items-center ml-1">
                                        <span class="text-sm">Logout</span>
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
        <div class="hidden bg-primary-darkest sm:block sm:bg-primary sm:font-normal border-b border-primary-dark" id="secondary_nav">
            <div class="container mx-auto px-4 py-4 sm:py-0 sm:-mb-px">
                <div class="sm:flex justify-between text-center">
                    <div class="sm:flex text-sm">
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                            <a href="/reservations/meetings" class="text-grey-light no-underline flex items-center py-4 sm:border-b-4 border-transparent hover:border-primary-dark hover:text-white">
                            <div class="fill-current h-5 w-5 mr-2">
                                <?= file_get_contents("public/icons/users.svg") ?>
                            </div>
                                Meetings
                            </a>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                            <a href="/reservations/equipment" class="text-grey-light no-underline flex items-center py-4 sm:border-b-4 border-transparent hover:border-primary-dark hover:text-white">
                            <div class="fill-current h-5 w-5 mr-2">
                                <?= file_get_contents("public/icons/laptop-phone.svg") ?>
                            </div>
                                Equipment
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center text-sm z-40 sm:relative group">
                            <button class="w-full sm:w-auto bg-transparent hover:bg-white text-white  py-2 px-4 md:px-8 my-2 md:mt-2 border-2 border-white hover:text-primary hover:border-transparent hover:bg-white">
                                New Reservation
                            </button>
                        <div class="hidden sm:hover:inline-block sm:group-hover:inline-block bg-white text-primary shadow-md sm:absolute mt-12 pin-t pin-l w-full border">
                            <ul class="list-reset">
                                <li class="bg-grey-light no-underline px-4 py-2 block uppercase font-medium text-sm">Meeting</li>
                                <li><a href="/reservations/meeting/create_by_date" class="no-underline px-4 py-2 block text-sm text-primary hover:bg-grey-lighter">by date</a></li>
                                <li><a href="/reservations/meeting/create_by_room" class="no-underline px-4 py-2 block text-sm text-primary hover:bg-grey-lighter">by room</a></li>
                                </li>
                                <li><span class="bg-grey-light no-underline px-4 py-2 block uppercase font-medium text-sm">Equipment</span></li>
                                <li>
                                    <ul class="list-reset text-sm">
                                        <li><a href="/reservations/equipment/create_by_date" class="no-underline px-4 py-2 block text-primary hover:bg-grey-lighter">by date</a></li>
                                        <li><a href="/reservations/equipment/create_by_item" class="no-underline px-4 py-2 block text-primary hover:bg-grey-lighter">by item</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content section :: container replacement -->
    <div class="mx-auto max-w-2/5xl sm:px-4 py-4 mb-4">
        <!-- Flash notifications -->
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
        <?= $content_for_layout ?>
    </div>
    <!-- Footer section -->
    <?= $this->layouts->print_footer_includes() ?>
    <script src="/js/reservations.js"></script>
    </body>
</html>