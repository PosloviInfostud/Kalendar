<div class="max-w-md mx-auto">
    <!-- Breadcrumb -->
    <div class="flex text-xs sm:text-sm text-black px-2 pb-3 sm:px-0">
        <span>Rezervacije</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span>Sastanci</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span class="text-primary font-normal">Kreiranje nove rezervacije</span>
    </div>
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:px-8 sm:py-6">
        <div class="flex flex-inline">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Novi sastanak</h1>
            <span class="uppercase text-grey font-medium text-sm ml-1">pretraga po slobodnom terminu</span>
        </div>
    </div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow mt-4 px-4 py-8 sm:p-8">
        <div id="form_errors" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-6 border-red-lighter"></div>
        <form id="reservation_form" action="/reservations/submit_reservation_form" method="POST">
            <div>
                <p class="mb-6">Kada će se sastanak odviti?</p>
                <div class="sm:flex sm:items-center mb-2">
                    <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-1 sm:flex-2">
                        <span class="sm:mr-1 text-grey-dark uppercase text-xs">Od</span>
                        <input type="text" name="start_time" id="datetime_start" placeholder="početak" class="w-full bg-grey-lighter py-2 font-light text-center border rounded"> 
                    </div>
                    <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-1 sm:flex-2">
                        <span class="sm:mr-1 text-grey-dark uppercase text-xs">do</span>
                        <input type="text" name="end_time" id="datetime_end" placeholder="kraj" class="w-full bg-grey-lighter py-2 font-light text-center border rounded">
                    </div>
                    <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-1 sm:flex-1">
                        <span class="sm:ml-1 sm:mr-1 text-grey-dark uppercase text-xs">za</span>
                        <input type="number" name="attendants" id="attendants" step=1 placeholder="#" class="w-full bg-grey-lighter py-2 font-light text-center border rounded">
                        <span class="sm:ml-1 text-xs text-grey-dark uppercase sm:mt-1">osoba</span>
                    </div>
                </div>
            </div>
            <button id="search_reserved_rooms" class="w-full bg-primary hover:bg-primary-dark text-white py-1 px-2 py-2 md:px-4 mt-4 shadow rounded focus:outline-none">Pretražite</button>
        </form>
    </div>
    <div id="free" class="hidden mt-4"><!-- views\reservations\free_rooms_tailwind --></div>
</div>
