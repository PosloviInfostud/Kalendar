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
                            <div class="fill-current h-6 w-6 text-grey-light mr-4 sm:mr-0">
                                <a href="/admin" class="no-underline text-grey-light"><?= file_get_contents("public/icons/cog.svg") ?></a>
                            </div>
                            <div class="hidden sm:block sm:flex sm:items-center ml-2">
                                <a href="/admin" class="no-underline text-grey-light"><span class="text-grey-light text-sm mr-6">Admin area</span></a>
                            </div>
                            <div class="fill-current h-6 w-6 text-grey-light">
                                <a href="#" class="no-underline text-grey-light"><?= file_get_contents("public/icons/user.svg") ?></a>
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
        <div class="h-1 bg-primary sm:hidden"></div>

        <!-- Secondary Nav -->
        <div class="hidden bg-primary-darkest sm:block sm:bg-primary sm:font-normal border-b border-primary-dark" id="secondary_nav">
            <div class="container mx-auto px-4 py-4 sm:py-0 sm:-mb-px">
                <div class="sm:flex justify-between text-center">
                    <div class="sm:flex text-sm md:text-base">
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                            <a href="#" class="text-white no-underline flex items-center py-4 sm:border-b-4 border-primary-dark">
                            <div class="fill-current h-6 w-6 mr-2">
                                <?= file_get_contents("public/icons/chart-bars.svg") ?>
                            </div>
                                Dashboard
                            </a>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                            <a href="#" class="text-grey-light no-underline flex items-center py-4 sm:border-b-4 border-transparent hover:border-primary-dark hover:text-white">
                            <div class="fill-current h-6 w-6 mr-2">
                                <?= file_get_contents("public/icons/users.svg") ?>
                            </div>
                                Meetings
                            </a>
                        </div>
                        <div class="flex sm:mr-12 sm:mt-1 justify-center">
                            <a href="#" class="text-grey-light no-underline flex items-center py-4 sm:border-b-4 border-transparent hover:border-primary-dark hover:text-white">
                            <div class="fill-current h-6 w-6 mr-2">
                                <?= file_get_contents("public/icons/laptop-phone.svg") ?>
                            </div>
                                Equipment
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="sm:flex sm:justify-end text-sm md:text-base">
                            <button class="w-full sm:w-auto bg-transparent hover:bg-white text-white  py-2 px-4 md:px-8 my-2 md:mt-3 border-2 border-white hover:text-primary hover:border-transparent hover:bg-white rounded">
                                New Reservation
                            </button>
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
            <span>Reservations</span>
            <div class="fill-current h-2 w-2 mx-1 -mt-px">
                <?= file_get_contents("public/icons/chevron-right.svg") ?>
            </div>
            <span class="text-primary font-normal">Dashboard</span>
        </div>
        <div class="bg-white border sm:rounded shadow py-4 sm:px-4 mb-4">
            <div class="md:flex px-2 mx-4 sm:px-0">
                <div class="md:w-1/2 md:border-r md:mr-4">
                    <div class="flex py-4">
                        <div class="w-1/3 uppercase text-primary font-medium">
                            Meetings
                        </div>
                        <div class="w-1/3 text-grey font-normal">
                            Total
                        </div>
                        <div class="w-1/3">
                            
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-1/3">
                            <div class="fill-current h-20 w-20 text-grey">
                                <?= file_get_contents("public/icons/users.svg") ?>
                            </div>
                        </div>
                        <div class="w-1/3 font-normal text-grey-darkest text-6xl">
                            12
                        </div>
                        <div class="w-1/3">
                            <div class="fill-current h-12 w-12 text-grey">
                                <a href="#" class="text-grey"><?= file_get_contents("public/icons/arrow-right-circle.svg") ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2 md:-ml-4">
                    <div class="flex py-4 md:pl-6">
                        <div class="w-1/3 uppercase text-primary font-medium">
                            Equipment
                        </div>
                        <div class="w-1/3 text-grey font-normal">
                            Total
                        </div>
                        <div class="w-1/3">
                            
                        </div>
                    </div>
                    <div class="flex items-center md:pl-6">
                        <div class="w-1/3">
                            <div class="fill-current h-20 w-20 text-grey">
                                <?= file_get_contents("public/icons/laptop-phone.svg") ?>
                            </div>
                        </div>
                        <div class="w-1/3 font-normal text-grey-darkest text-6xl">
                            3
                        </div>
                        <div class="w-1/3">
                            <div class="fill-current h-12 w-12 text-grey">
                                <a href="#" class="text-grey"><?= file_get_contents("public/icons/arrow-right-circle.svg") ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    <!-- Calendars -->
        <div class="hidden md:flex -mx-2">
            <div class="w-1/2 px-2">
                <div class="bg-white rounded border shadow">
                    <h3 class="uppercase text-primary font-medium text-base py-4 px-4">Meetings Calendar</h3>
                    <div class="h-64"><!--Placeholder --></div>
                </div>
            </div>
            <div class="w-1/2 px-2">
                <div class="bg-white rounded border shadow">
                <h3 class="uppercase text-primary font-medium text-base py-4 px-4">Items Calendar</h3>
                <div class="h-64"><!--Placeholder --></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer section -->
    <script src="/public/js/app.js"></script>
</body>
</html>