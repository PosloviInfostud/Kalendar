<div class="max-w-md mx-auto">
    <!-- Breadcrumb -->
    <div class="flex text-xs sm:text-sm text-black px-2 pb-3 sm:px-0">
        <span>Reservations</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span>Equipment</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span class="text-primary font-normal">New Reservation</span>
    </div>
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow p-8">
        <div id="form_errors" class="hidden mb-8 text-red text-sm p-4 border border-red bg-red-lightest"></div>
        <h1 class="pl-2 font-normal text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Create a new reservation</h1>
        <form id="reservation_equip_form" class="" action="/reservations/submit_reservation_equip_form" method="POST">
            <div class="md:flex mt-8 mb-4">
                <div class="md:w-1/3 mb-2 md:mb-0">
                    <label for="equipment_type" class="mr-4 font-light">What would you like to reserve?</label>
                </div>
                <div class="md:w-2/3">
                    <?php
                    $i=1; 
                    foreach($equips as $equip) { ?>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input radio_equipment" id="customRadio<?= $i ?>" name="equipment_type" value="<?= $equip['id'] ?>">
                            <label class="custom-control-label" for="customRadio<?= $i ?>"><?= $equip['name'] ?></label>
                        </div>
                    <?php $i++;
                    } ?>
                </div>
            </div>
            <div class="md:flex mt-8">
                <div class="md:w-1/3 mb-2 md:mb-0 md:flex">
                    <label for="equipment_type" class="mr-4 font-light">When?</label>
                </div>
                <div class="sm:w-2/3 sm:flex">
                    <div class="sm:mr-2 sm:w-1/2">
                        <input type="text" name="start_time" id="item_datetime_start" placeholder="Start time" class="w-full bg-grey-lighter py-2 font-light text-center border rounded"> 
                        <p class="sm:mr-1 mt-2px text-grey-dark uppercase text-xs">from</p>
                    </div>
                    <div class="sm:w-1/2">
                        <input type="text" name="end_time" id="item_datetime_end" placeholder="End time" class="w-full bg-grey-lighter py-2 font-light text-center border rounded">
                        <p class="sm:mr-1 mt-2px text-grey-dark uppercase text-xs">to</p>
                    </div>
                </div>
            </div>
            <button id="search_equipment" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-1 px-2 py-2 md:px-4 mt-4 shadow rounded focus:outline-none">Search</button>
        </form>
    </div>
    <div id="rest" class="hidden mt-4"></div>