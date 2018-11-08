<div class="max-w-md mx-auto">
    <!-- Breadcrumb -->
    <div class="flex text-xs sm:text-sm text-black px-2 pb-3 sm:px-0">
        <span>Reservations</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span>Meetings</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span class="text-primary font-normal">New Meeting</span>
    </div>
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow p-8">
        <div id="form_errors" class="hidden mb-4 text-red text-sm p-4 border border-red bg-red-lightest"></div>
        <h1 class="pl-2 font-normal text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Create a new meeting</h1>
        <form id="reservation_form" action="/reservations/submit_reservation_form" method="POST">
            <div class="mt-8">
                <p class="mb-4">When is it happening?</p>
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-1 sm:flex-2">
                        <span class="sm:mr-1 text-grey-dark uppercase text-xs">From</span>
                        <input type="text" name="start_time" id="datetime_start" placeholder="start time" class="w-full bg-grey-lighter py-2 font-light text-center border rounded"> 
                    </div>
                    <div class="sm:flex items-center sm:flex-2">
                        <span class="sm:mr-1 text-grey-dark uppercase text-xs">to</span>
                        <input type="text" name="end_time" id="datetime_end" placeholder="end time" class="w-full bg-grey-lighter py-2 font-light text-center border rounded">
                    </div>
                    <div class="sm:flex items-center sm:flex-1">
                        <span class="sm:ml-1 sm:mr-1 text-grey-dark uppercase text-xs">for</span>
                        <input type="number" name="attendants" id="attendants" step=1 placeholder="#" class="w-full bg-grey-lighter py-2 font-light text-center border rounded">
                        <span class="sm:ml-1 text-xs text-grey-dark uppercase">people</span>
                    </div>
                </div>
            </div>
            <button id="search_reserved_rooms" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-1 px-2 py-2 md:px-4 mt-4 shadow rounded focus:outline-none">Search</button>
        </form>
    </div>
    <div id="free" class="hidden mt-4"></div>
</div>
