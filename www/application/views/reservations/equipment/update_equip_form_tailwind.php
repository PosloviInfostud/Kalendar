<!-- Data for calendar -->
<script>
var current_reservations = <?= $current_reservations; ?>;
</script>

<?php $date = date('Y-m-d h:i:s', time()); ?>

<div class="max-w-md mx-auto">
    <!-- Breadcrumb -->
    <div class="flex text-xs sm:text-sm text-black px-2 mb-3 sm:px-0">
        <span>Reservations</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span>Equipment</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span>Edit</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span class="text-primary font-normal"><?= $equipment['item_name'] ?></span>
    </div>
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow p-4 sm:p-8">
        <!-- Title -->
        <div class="flex flex-inline">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary capitalize"><?= $equipment['item_name'] ?> Reservation</h1>
            <span class="uppercase text-grey font-medium text-sm ml-1">Update</span>
        </div>
    </div>
    <!-- Fullcalendar -->
    <button id="show_calendar" class="bg-grey hover:bg-grey-dark text-white font-bold mt-4 py-3 w-full shadow rounded focus:outline-none">Show item schedule</button>
    <div class="hidden my-4" id="calendar"></div>
    <!-- Details -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow mt-4 p-4 sm:p-8">
        <div id="form_errors" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-6 border-red-lighter"></div>
        <div class="mb-8">
            <p class="text-lg mb-2">Reservation dates</p>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-2 sm:w-1/2">
                <?php if($equipment['starttime'] < $date) { ?>
                    <span class="sm:mr-2 text-grey text-sm uppercase">From</span>
                    <input type="text" name="start_time" id="update_item_datetime_start" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" data-default-date="<?= $equipment['starttime'] ?>"  disabled="disabled"> 
                <?php } else { ?>
                    <span class="sm:mr-2 text-grey text-sm uppercase">From</span>
                    <input type="text" name="start_time" id="update_item_datetime_start" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" data-default-date="<?= $equipment['starttime'] ?>"> 
                <?php } ?>
                </div>
                <div class="sm:flex items-center sm:w-1/2">
                    <span class="sm:mr-2 text-grey text-sm uppercase">to</span>
                    <input type="text" name="end_time" id="update_item_datetime_end" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" data-default-date="<?= $equipment['endtime'] ?>">
                </div>
            </div>
        </div>
        <div class="mt-2 mb-8">
            <p class="text-lg mb-2">Reason for reservation</p>
            <textarea rows="4" class="bg-grey-lighter font-light p-2 w-full border rounded" id="reservation_description"><?= $equipment['description'] ?></textarea>
        </div>
        <input type="hidden" name="res_id" id="res_id" value="<?= $equipment['id'] ?>">
        <input type="hidden" name="equip_id" id="equip_id" value="<?= $equipment['equipment_id'] ?>">
    </div>
    <input type="submit" name="submit" id="update_equipment_submit" class="cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold text-sm uppercase py-3 mt-4 px-4 rounded" value="Update">
</div>
