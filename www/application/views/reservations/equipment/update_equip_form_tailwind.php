<!-- Data for calendar -->
<script>
var current_reservations = <?= $current_reservations; ?>;
</script>

<?php $date = date('Y-m-d h:i:s', time()); ?>

<div class="max-w-md mx-auto">
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:px-8 sm:py-6">
        <!-- Title -->
        <div class="flex flex-inline">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary capitalize"><?= $equipment['item_name'] ?> rezervacija</h1>
            <span class="uppercase text-grey font-medium text-sm ml-1">Izmena</span>
        </div>
    </div>
    <!-- Fullcalendar -->
    <button id="show_calendar" class="bg-grey hover:bg-grey-dark text-grey-darker hover:text-grey-darkest mt-4 py-3 w-full shadow rounded focus:outline-none">Raspored rezervacija za odabranu stavku</button>
    <div class="hidden my-4" id="calendar"></div>
    <!-- Details -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow mt-4 px-4 py-8 sm:p-8">
        <div id="form_errors" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-6 border-red-lighter"></div>
        <div class="mb-8">
            <p class="text-lg mb-2">Period</p>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-2 sm:w-1/2">
                <?php if($equipment['starttime'] < $date) { ?>
                    <span class="sm:mr-2 text-grey text-sm uppercase">od</span>
                    <input type="text" name="start_time" id="update_item_datetime_start" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" data-default-date="<?= $equipment['starttime'] ?>"  disabled="disabled"> 
                <?php } else { ?>
                    <span class="sm:mr-2 text-grey text-sm uppercase">od</span>
                    <input type="text" name="start_time" id="update_item_datetime_start" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" data-default-date="<?= $equipment['starttime'] ?>"> 
                <?php } ?>
                </div>
                <div class="sm:flex items-center sm:w-1/2">
                    <span class="sm:mr-2 text-grey text-sm uppercase">do</span>
                    <input type="text" name="end_time" id="update_item_datetime_end" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" data-default-date="<?= $equipment['endtime'] ?>">
                </div>
            </div>
        </div>
        <div class="mt-2">
            <p class="text-lg mb-2">Svrha rezervacije</p>
            <textarea rows="4" class="bg-grey-lighter font-light p-2 w-full border rounded" id="reservation_description"><?= $equipment['description'] ?></textarea>
        </div>
        <input type="hidden" name="res_id" id="res_id" value="<?= $equipment['id'] ?>">
        <input type="hidden" name="equip_id" id="equip_id" value="<?= $equipment['equipment_id'] ?>">
        <!-- Submit button for mobile view -->
        <input type="submit" name="submit" class="update_equipment_submit sm:hidden cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold text-sm uppercase py-3 mt-6 px-4 rounded" value="Ažuriraj">
    </div>
    <!-- Submit button for desktop view -->
    <input type="submit" name="submit" class="update_equipment_submit hidden sm:block cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold text-sm uppercase py-3 mt-4 px-4 rounded" value="Ažuriraj">
</div>
