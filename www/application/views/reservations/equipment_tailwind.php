<div class="max-w-md mx-auto">
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow p-4 sm:px-8 sm:py-6">
        <div class="flex flex-inline">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Nova rezervacija</h1>
            <span class="uppercase text-grey font-medium text-sm ml-1">po slobodnom terminu</span>
        </div>
    </div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow mt-4 px-4 py-8 sm:px-8 sm:py-6">
        <div id="form_errors" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-6 border-red-lighter"></div>
        <form id="reservation_equip_form" action="/reservations/submit_reservation_equip_form" method="POST">
            <div class="md:flex mb-4">
                <div class="md:w-1/3 mb-2 md:mb-0">
                    <label for="equipment_type" class="mr-4 font-light">Koji tip opreme Vam je potreban?</label>
                </div>
                <div class="md:w-2/3">
                    <?php $i=1; foreach($equips as $equip) { ?>
                        <div class="custom-control custom-radio capitalize">
                            <input type="radio" class="custom-control-input radio_equipment" id="customRadio<?= $i ?>" name="equipment_type" value="<?= $equip['id'] ?>">
                            <label class="custom-control-label" for="customRadio<?= $i ?>"><?= $equip['name'] ?></label>
                        </div>
                    <?php $i++; } ?>
                </div>
            </div>
            <div class="md:flex mt-8">
                <div class="md:w-1/3 mb-2 md:mb-0 md:flex">
                    <label for="equipment_type" class="mr-4 font-light">Period</label>
                </div>
                <div class="sm:w-2/3 sm:flex">
                    <div class="sm:mr-2 sm:w-1/2">
                        <input type="text" name="start_time" id="item_datetime_start" placeholder="početak" class="w-full bg-grey-lighter py-2 font-light text-center border rounded"> 
                        <p class="sm:mr-1 mt-2px text-grey-dark uppercase text-xs">od</p>
                    </div>
                    <div class="sm:w-1/2 mt-2 sm:mt-0">
                        <input type="text" name="end_time" id="item_datetime_end" placeholder="kraj" class="w-full bg-grey-lighter py-2 font-light text-center border rounded">
                        <p class="sm:mr-1 mt-2px text-grey-dark uppercase text-xs">do</p>
                    </div>
                </div>
            </div>
            <button id="search_equipment" class="w-full bg-primary hover:bg-primary-dark text-white px-2 py-2 md:px-4 mt-4 shadow rounded focus:outline-none">Pretražite</button>
        </form>
    </div>
    <div id="rest" class="hidden mt-4"><!-- views/reservations/free_equipment_tailwind --></div>