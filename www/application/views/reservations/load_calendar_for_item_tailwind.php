<script>
var current_reservations = <?= $current_reservations; ?>;
</script>

<div>
    <button id="show_calendar" class="bg-grey hover:bg-grey-dark text-grey-darker hover:text-grey-darkest mb-4 py-3 w-full shadow rounded focus:outline-none">Show equipment schedule</button>
    <div class="hidden mb-4" id="calendar"></div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:p-8">
        <div id="equipment_errors" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-6 border-red-lighter"></div>
        <div class="md:flex">
            <div class="md:w-1/3 mb-2 md:mb-0 md:flex">
                <label for="equipment_type" class="mr-4 font-light">When?</label>
            </div>
            <div class="md:w-2/3 sm:flex">
                <div class="sm:mr-2 sm:w-1/2">
                    <input type="text" name="start_time" id="item_datetime_start" placeholder="Start time" class="w-full bg-grey-lighter py-2 font-light text-center border rounded"> 
                    <p class="sm:mr-1 mt-2px text-grey-dark uppercase text-xs">from</p>
                </div>
                <div class="sm:w-1/2">
                    <input type="text" name="end_time" id="item_datetime_end" placeholder="End time" class="w-full bg-grey-lighter mt-2 sm:mt-0 py-2 font-light text-center border rounded">
                    <p class="sm:mr-1 mt-2px text-grey-dark uppercase text-xs">to</p>
                </div>
            </div>
        </div>
        <div class="md:flex mt-8">
            <div class="md:w-1/3 mb-2 md:mb-0">
                <label for="equipment_type" class="mr-4 font-light">Reason for reservation?</label>
            </div>
            <div class="md:w-2/3">
                <textarea rows="4" class="w-full bg-grey-lighter p-3 font-light border rounded" name="description" id="reservation_description"></textarea>
            </div>
        </div>
        <!-- Button for mobile view -->
        <input type="submit" name="submit" id="reservation_equipment_submit_by_item" class="sm:hidden cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase px-2 py-3 md:px-4 mt-6 border border-primary shadow rounded focus:outline-none" value="Create">
    </div>
    <!-- Button for desktop view -->
    <input type="submit" name="submit" id="reservation_equipment_submit_by_item" class="hidden sm:block cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase px-2 py-3 md:px-4 mt-4 border border-primary shadow rounded focus:outline-none" value="Create">
</div>

<!-- Confirm reservation modal -->
<div class="hidden modal" id="equip_reservation_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex items-center">
        <div id="modal-content" class="p-8 bg-white w-full max-w-sm m-auto flex-col flex rounded shadow">
            <h2 class="pl-2 py-1 text-2xl sm:text-3xl border-l-6 mb-4 border-red">Are these correct?</h2>
            <div id="modal-body" class="my-4"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-white font-medium w-full py-2 mt-2 mr-2 border border-red-light rounded focus:outline-none" id="reservation_equipment_submit_by_item_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-grey-dark font-medium w-full py-2 mt-2 ml-2 border border-grey rounded focus:outline-none" id="reservation_equipment_submit_by_item_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/calendar_for_item.js"></script>
<script src="/js/flatpickr_items.js"></script>