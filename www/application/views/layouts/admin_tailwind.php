<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/src/img/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="/public/css/app.css">
    <link rel="stylesheet" href="/style/style.css">
    <title><?= $title_for_layout ?>Kalendar</title>
</head>
<body class="font-sans bg-grey-lighter font-light">
<!-- Navigation -->
    <div>
        <div class="bg-indigo-darkest">
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
                                <span class="block text-xs text-indigo-dark xs:ml-2px">admin</span>
                            </div>
                        </a>
                    </div>
                    <div class="w-1/4 sm:w-auto sm:flex text-right">
                        <div class="flex justify-end">
                            <a href="/reservations/meetings" class="no-underline text-grey-light hover:text-indigo">
                                <div class="flex justify-end">
                                    <div class="fill-current h-5 w-5 xs:h-6 xs:w-6 mr-2 xs:mr-4 sm:mr-0">
                                       <?= file_get_contents("public/icons/cog.svg") ?>
                                    </div>
                                    <div class="hidden sm:block sm:flex sm:items-center ml-1 mr-6">
                                        <span class="text-sm">Members area</span>
                                    </div>
                                </div>
                            </a>
                            <a href="/profile" class="no-underline text-grey-light hover:text-indigo">
                                <div class="flex justify-end">
                                    <div class="fill-current h-5 w-5 xs:h-6 xs:w-6 mr-2 xs:mr-4 sm:mr-0">
                                        <?= file_get_contents("public/icons/user.svg") ?>
                                    </div>
                                    <div class="hidden sm:block sm:flex sm:items-center ml-1 mr-6">
                                        <span class="text-sm">Profile</span>
                                    </div>
                                </div>
                            </a>
                            <a href="/logout" class="no-underline text-grey-light hover:text-indigo">
                                <div class="flex justify-end">
                                    <div class="fill-current h-5 w-5 xs:h-6 xs:w-6">
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
        <div class="h-1 bg-indigo sm:hidden"></div>

        <!-- Secondary Nav -->
        <div class="hidden bg-indigo-darkest sm:block sm:bg-indigo sm:font-normal border-b border-indigo-light" id="secondary_nav">
            <div class="container mx-auto px-4 py-4 sm:py-0 sm:-mb-px">
                <div class="sm:flex justify-between text-center">
                    <div class="sm:flex text-sm">
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                            <a href="/admin" class="text-grey-light no-underline flex items-center py-4 sm:border-b-4 border-transparent hover:border-indigo-light hover:text-white">
                            <div class="sm:hidden md:block fill-current h-5 w-5 mr-2">
                                <?= file_get_contents("public/icons/chart-bars.svg") ?>
                            </div>
                                Dashboard
                            </a>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center sm:relative group">
                            <div class="cursor-pointer text-grey-light flex items-center py-4 sm:border-b-4 border-transparent hover:border-indigo-light hover:text-white">
                            <div class="sm:hidden md:block fill-current h-5 w-5 mr-2">
                                <?= file_get_contents("public/icons/calendar-full.svg") ?>
                            </div>
                                <span>Reservations</span>
                            </div>
                            <div class="z-50 hidden sm:hover:inline-block sm:group-hover:inline-block bg-white shadow-md sm:absolute mt-12 pin-t pin-l w-48">
                                <ul class="list-reset">
                                    <li><a href="/admin/meetings" class="no-underline px-4 py-2 block text-sm text-indigo hover:bg-grey-lighter">Meetings</a></li>
                                    <li><a href="/admin/equipment" class="no-underline px-4 py-2 block text-sm text-indigo hover:bg-grey-lighter">Equipment</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center sm:relative group">
                            <div class="cursor-pointer text-grey-light flex items-center py-4 sm:border-b-4 border-transparent hover:border-indigo-light hover:text-white">
                            <div class="sm:hidden md:block fill-current h-5 w-5 mr-2">
                                <?= file_get_contents("public/icons/laptop-phone.svg") ?>
                            </div>
                                <span>Items</span>
                            </div>
                            <div class="z-50 hidden sm:hover:inline-block sm:group-hover:inline-block bg-white text-indigo shadow-md sm:absolute mt-12 pin-t pin-l w-48">
                                <ul class="list-reset">
                                    <li class="bg-grey-light no-underline px-4 py-2 block uppercase font-medium text-sm">Meetings</li>
                                    <li><a href="/admin/conference_rooms" class="no-underline px-4 py-2 block text-sm text-indigo hover:bg-grey-lighter">Conference room list</a></li>
                                    </li>
                                    <li><span class="bg-grey-light no-underline px-4 py-2 block uppercase font-medium text-sm">Equipment</span></li>
                                    <li>
                                        <ul class="list-reset text-sm">
                                            <li><a href="/admin/items" class="no-underline px-4 py-2 block text-indigo hover:bg-grey-lighter">List of items</a></li>
                                            <li><a href="/admin/types" class="no-underline px-4 py-2 block text-indigo hover:bg-grey-lighter">Item types</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center sm:relative group">
                            <div class="cursor-pointer text-grey-light flex items-center py-4 sm:border-b-4 border-transparent hover:border-indigo-light hover:text-white">
                            <div class="sm:hidden md:block fill-current h-5 w-5 mr-2">
                                <?= file_get_contents("public/icons/users.svg") ?>
                            </div>
                                <span>Users</span>
                            </div>
                            <div class="z-50 hidden sm:hover:inline-block sm:group-hover:inline-block bg-white shadow-md sm:absolute mt-12 pin-t pin-l w-48">
                                <ul class="list-reset">
                                    <li><a href="/admin/users" class="no-underline px-4 py-2 block text-sm text-indigo hover:bg-grey-lighter">List of users</a></li>
                                    <li><a href="/admin/activities" class="no-underline px-4 py-2 block text-sm text-indigo hover:bg-grey-lighter">User activites</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                            <a href="/admin/logs" class="text-grey-light no-underline flex items-center py-4 sm:border-b-4 border-transparent hover:border-indigo-light hover:text-white">
                            <div class="sm:hidden md:block fill-current h-5 w-5 mr-2">
                                <?= file_get_contents("public/icons/database.svg") ?>
                            </div>
                                Logs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content section -->
    <div class="container mx-auto sm:px-4">
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
        <div class="z-0">
        <?= $content_for_layout ?>
        </div>
    <!-- Footer section -->
    <script src="/js/admin.js"></script>
    <script src="/public/js/app.js"></script>
</body>
</html>