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
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/public/css/app.css">
    <title><?= $title_for_layout ?>Kalendar</title>
</head>
<body class="bg-grey-lighter text-base text-grey-darkest font-light font-sans relative">
    <div class="flex items-center h-screen">
        <div class="h-2 bg-primary fixed pin-t w-full"></div>
            <div class="mx-auto max-w-sm sm:px-8">
                <!-- Logo -->
                <div class="text-center pb-4">
                    <img class="w-1/6" src="/src/img/logo-no-text.png">
                </div>
                <!-- Flash notifications -->
                <div id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
                <!-- Error messages -->
                <div id="alert_box" class="hidden">
                    <div class="bg-red-alert border-l-4 border-red text-red-dark p-4 mb-5 mt-1 shadow relative" role="alert">
                        <p class="font-bold uppercase mb-2">Pažnja</p>
                        <p id="messages"></p>
                        <span class="absolute pin-t pin-b pin-r px-4 py-3">
                            <svg id="close_alert" class="fill-current h-6 w-6 text-red opacity-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>
                </div>
        <!-- CONTENT FROM THE VIEW -->
                <?= $content_for_layout ?>
            </div>
        <!-- FOOTER -->
        <?= $this->layouts->print_header_includes() ?>
        <script src="/js/reglog.js"></script>
        <!-- <script src="/public/js/app.js"></script> -->
    </div>
</body>
</html>