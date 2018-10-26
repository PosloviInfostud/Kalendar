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
<body class="font-sans bg-grey-lighter font-light">
<!-- Navigation -->
    <div>
        <div class="bg-indigo-darkest">
            <div class="sm:container mx-auto px-4">
                <div class="flex items-center sm:justify-between py-4">
                    <div class="w-1/4 sm:hidden">
                        <div class="fill-current h-6 w-6 text-grey-light cursor-pointer" id="phone_menu_btn">
                            <?= file_get_contents("public/icons/menu.svg") ?>
                        </div>
                    </div>
                    <div class="w-1/2 sm:w-auto text-lg text-center text-grey-light font-medium tracking-wide uppercase">
                        Kalendar <span class="text-xs text-indigo-dark">admin</span>
                    </div>
                    <div class="w-1/4 sm:w-auto sm:flex text-right">
                        <div class="flex justify-end">
                            <div class="fill-current h-6 w-6 text-grey-light mr-4 sm:mr-0">
                                <a href="/admin" class="appearance-none no-underline text-grey-light"><?= file_get_contents("public/icons/cog.svg") ?></a>
                            </div>
                            <div class="hidden sm:block sm:flex sm:items-center ml-2">
                                <a href="/admin" class="no-underline text-grey-light"><span class="text-grey-light text-sm mr-6">Admin area</span></a>
                            </div>
                            <div class="fill-current h-6 w-6 text-grey-light">
                                <a href="/profile" class="no-underline text-grey-light"><?= file_get_contents("public/icons/user.svg") ?></a>
                            </div>
                            <div class="hidden sm:block sm:flex sm:items-center ml-2">
                                <a href="/profile" class="no-underline text-grey-light"><span class="text-grey-light text-sm mr-1">Profile</span></a>
                                <div class="fill-current h-3 w-3 -mt-1 text-grey-light opacity-50">
                                    <a href="/profile" class="no-underline text-grey-light"><?= file_get_contents("public/icons/chevron-down.svg") ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-1 bg-indigo sm:hidden"></div>

        <!-- Secondary Nav -->
        <div class="hidden bg-primary-darkest sm:block sm:bg-indigo sm:font-normal border-b border-indigo-light" id="secondary_nav">
            <div class="container mx-auto px-4 py-4 sm:py-0 sm:-mb-px">
                <div class="sm:flex justify-between text-center">
                    <div class="sm:flex text-sm md:text-base">
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                            <a href="#" class="text-white no-underline flex items-center py-4 sm:border-b-4 border-indigo-light">
                            <div class="sm:hidden md:block fill-current h-6 w-6 mr-2">
                                <?= file_get_contents("public/icons/chart-bars.svg") ?>
                            </div>
                                Dashboard
                            </a>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center sm:relative group">
                            <div class="cursor-pointer text-grey-light flex items-center py-4 sm:border-b-4 border-transparent hover:border-indigo-light hover:text-white">
                            <div class="sm:hidden md:block fill-current h-6 w-6 mr-2">
                                <?= file_get_contents("public/icons/calendar-full.svg") ?>
                            </div>
                                <span>Reservations</span>
                            </div>
                            <div class="hidden sm:hover:inline-block sm:group-hover:inline-block bg-white shadow-md sm:absolute mt-12 pin-t pin-l w-48">
                                <ul class="list-reset">
                                    <li><a href="#" class="no-underline px-4 py-2 block text-indigo hover:bg-grey-lighter">Meetings</a></li>
                                    <li><a href="#" class="no-underline px-4 py-2 block text-indigo hover:bg-grey-lighter">Equipment</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center sm:relative group">
                            <div class="cursor-pointer text-grey-light flex items-center py-4 sm:border-b-4 border-transparent hover:border-indigo-light hover:text-white">
                            <div class="sm:hidden md:block fill-current h-6 w-6 mr-2">
                                <?= file_get_contents("public/icons/laptop-phone.svg") ?>
                            </div>
                                <span>Items</span>
                            </div>
                            <div class="hidden sm:hover:inline-block sm:group-hover:inline-block bg-white shadow-md sm:absolute mt-12 pin-t pin-l w-48">
                                <ul class="list-reset">
                                    <li><span class="bg-indigo-lighter no-underline px-4 py-2 block text-white">Meetings</span></li>
                                    <li><a href="#" class="no-underline px-4 py-2 block text-indigo text-sm hover:bg-grey-lighter">Conference room list</a></li>
                                    </li>
                                    <li><span class="bg-indigo-lighter no-underline px-4 py-2 block text-white">Equipment</span></li>
                                    <li>
                                        <ul class="list-reset text-sm">
                                            <li><a href="#" class="no-underline px-4 py-2 block text-indigo hover:bg-grey-lighter">List of items</a></li>
                                            <li><a href="#" class="no-underline px-4 py-2 block text-indigo hover:bg-grey-lighter">Item types</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center sm:relative group">
                            <div class="cursor-pointer text-grey-light flex items-center py-4 sm:border-b-4 border-transparent hover:border-indigo-light hover:text-white">
                            <div class="sm:hidden md:block fill-current h-6 w-6 mr-2">
                                <?= file_get_contents("public/icons/users.svg") ?>
                            </div>
                                <span>Users</span>
                            </div>
                            <div class="hidden sm:hover:inline-block sm:group-hover:inline-block bg-white shadow-md sm:absolute mt-12 pin-t pin-l w-48">
                                <ul class="list-reset">
                                    <li><a href="#" class="no-underline px-4 py-2 block text-indigo hover:bg-grey-lighter">List of users</a></li>
                                    <li><a href="#" class="no-underline px-4 py-2 block text-indigo hover:bg-grey-lighter">User activites</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                            <a href="#" class="text-grey-light no-underline flex items-center py-4 sm:border-b-4 border-transparent hover:border-indigo-light hover:text-white">
                            <div class="sm:hidden md:block fill-current h-6 w-6 mr-2">
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
    <div class="container mx-auto sm:px-4 py-4 mb-4">
        <div id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
        <div class="flex text-sm text-black pb-4 px-2 sm:px-0">
            <span>Admin</span>
            <div class="fill-current h-2 w-2 mx-1 -mt-px">
                <?= file_get_contents("public/icons/chevron-right.svg") ?>
            </div>
            <span class="text-indigo font-normal">Dashboard</span>
        </div>
        <div class="bg-white border sm:rounded shadow py-4 sm:px-4 mb-4">
            <div class="">
            </div>

            <div class="md:flex px-2 sm:px-0">
                <div class="md:w-1/2 md:border-r md:mr-2 md:py-4 md:px-4">
                    <div class="flex py-4">
                        <div class="w-1/2 uppercase text-indigo font-medium">
                            Meetings
                        </div>
                        <div class="w-1/4 text-grey font-normal">
                            Total
                        </div>
                        <div class="w-1/4">
                            
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-1/2">
                            <div class="fill-current h-20 w-20 text-grey">
                                <?= file_get_contents("public/icons/users.svg") ?>
                            </div>
                        </div>
                        <div class="w-1/4 font-normal text-grey-darkest text-6xl">
                            12
                        </div>
                        <div class="w-1/4">
                            <div class="fill-current h-12 w-12 text-grey">
                                <a href="#" class="text-grey"><?= file_get_contents("public/icons/arrow-right-circle.svg") ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2 md:-ml-4 md:py-4 md:px-4">
                    <div class="flex py-4 md:pl-6">
                        <div class="w-1/2 uppercase text-indigo font-medium">
                            Equipment
                        </div>
                        <div class="w-1/4 text-grey font-normal">
                            Total
                        </div>
                        <div class="w-1/4">
                            
                        </div>
                    </div>
                    <div class="flex items-center md:pl-6">
                        <div class="w-1/2">
                            <div class="fill-current h-20 w-20 text-grey">
                                <?= file_get_contents("public/icons/laptop-phone.svg") ?>
                            </div>
                        </div>
                        <div class="w-1/4 font-normal text-grey-darkest text-6xl">
                            3
                        </div>
                        <div class="w-1/4">
                            <div class="fill-current h-12 w-12 text-grey">
                                <a href="#" class="text-grey"><?= file_get_contents("public/icons/arrow-right-circle.svg") ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:flex px-2 sm:px-0">
                <div class="md:w-1/2 md:border-r md:border-t md:mr-2 md:py-4 md:px-4">
                    <div class="flex py-4">
                        <div class="w-1/2 uppercase text-indigo font-medium">
                            Conference Rooms
                        </div>
                        <div class="w-1/4 text-grey font-normal">
                            Total
                        </div>
                        <div class="w-1/4">
                            
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-1/2">
                            <div class="fill-current h-20 w-20 text-grey">
                                <?= file_get_contents("public/icons/enter.svg") ?>
                            </div>
                        </div>
                        <div class="w-1/4 font-normal text-grey-darkest text-6xl">
                            8
                        </div>
                        <div class="w-1/4">
                            <div class="fill-current h-12 w-12 text-grey">
                                <a href="#" class="text-grey"><?= file_get_contents("public/icons/arrow-right-circle.svg") ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2 md:-ml-4 md:py-4 md:px-4 md:border-t">
                    <div class="flex py-4 md:pl-6">
                        <div class="w-1/2 uppercase text-indigo font-medium">
                            Items
                        </div>
                        <div class="w-1/4 text-grey font-normal">
                            Total
                        </div>
                        <div class="w-1/4">
                            
                        </div>
                    </div>
                    <div class="flex items-center md:pl-6">
                        <div class="w-1/2">
                            <div class="fill-current h-20 w-20 text-grey">
                                <?= file_get_contents("public/icons/tag.svg") ?>
                            </div>
                        </div>
                        <div class="w-1/4 font-normal text-grey-darkest text-6xl">
                            25
                        </div>
                        <div class="w-1/4">
                            <div class="fill-current h-12 w-12 text-grey">
                                <a href="#" class="text-grey"><?= file_get_contents("public/icons/arrow-right-circle.svg") ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div><a href="#" id="load-modal">hello</a></div>
    <!-- Modal -->
    <div class="hidden" id="modal">
        <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
            <div id="modal-content" class="relative p-16 bg-white w-full max-w-md m-auto flex-col flex">
                <span class="absolute pin-t pin-b pin-r p-4">
                    <svg id="close-modal" class="h-12 w-12 text-grey hover:text-grey-darkest opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elite. Quod blanditiis, quia ut tempore iusto labore adipisci saepe, dolorem debitis veritatis minima incidunt minus porro, rerum sed mollitia! A, ipsa possimus.</p>
                <div class="inline-flex">
                    <button class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-l">
                        Prev
                    </button>
                    <button class="bg-blue hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded-r">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer section -->
    <script src="/public/js/app.js"></script>
</body>
</html>