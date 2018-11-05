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
    <span class="text-primary font-normal">Create New Meeting</span>
</div>
<!-- Content -->
<div class="bg-white border-x sm:border-y sm:rounded shadow p-4 md:p-8">
    <h1 class="font-normal text-xl xs:text-2xl sm:text-3xl">Create a new meeting</h1>
    <p class="mt-8 mb-4">When is it happening?</p>
    <form id="reservation_form" action="/reservations/submit_reservation_form" method="POST">
        <div class="md:flex md:items-center mb-4">
            <div class="md:flex items-center mb-2 sm:mb-0 md:w-2/5 md:mr-2">
                <span class="md:mr-2 text-sm text-grey font-normal uppercase">From</span>
                <input type="text" name="start_time" id="datetime_start" placeholder="start time" class="w-full bg-grey-lighter p-2 font-light text-center border rounded"> 
            </div>
            <div class="md:flex items-center md:w-2/5">
                <span class="md:mr-2 text-sm text-grey font-normal uppercase">to</span>
                <input type="text" name="end_time" id="datetime_end" placeholder="end time" class="w-full bg-grey-lighter p-2 font-light text-center border rounded">
            </div>
            <div class="md:flex items-center md:w-1/5 mt-6 md:mt-0">
                <button id="search_reserved_rooms" class="w-full bg-primary hover:bg-primary-dark text-white font-bold md:ml-4 py-1 px-2 py-2 md:px-4 border-b-4 border-primary-dark rounded hover:shadow-inner">Search</button>
            </div>
        </div>
        <div id="form_errors" class="text-red text-sm font-base"></div>
    </form>
</div>
<div id="free" class="hidden bg-white border-x sm:border-y sm:rounded shadow p-4 md:p-8 mt-4"></div>