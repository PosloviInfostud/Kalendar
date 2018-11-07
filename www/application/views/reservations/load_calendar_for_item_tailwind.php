<script>
var current_reservations = <?= $current_reservations; ?>;
</script>

<div>
    <button id="show_calendar" class="bg-grey hover:bg-grey-dark text-white font-bold mb-4 py-3 w-full shadow rounded focus:outline-none">Show equipment schedule</button>
    <div class="hidden mb-4" id="calendar"></div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow p-8">
        <div id="equipment_errors" class="hidden mb-4 text-red text-sm p-4 border border-red bg-red-lightest"></div>
        <div class="md:flex mt-8">
            <div class="md:w-1/3 mb-2 md:mb-0 md:flex">
                <label for="equipment_type" class="mr-4 font-light">When?</label>
            </div>
            <div class="md:w-2/3 flex">
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
        <div class="md:flex mt-8">
            <div class="md:w-1/3 mb-2 md:mb-0">
                <label for="equipment_type" class="mr-4 font-light">Reason for reservation?</label>
            </div>
            <div class="md:w-2/3">
                <textarea rows="4" class="w-full bg-grey-lighter p-3 font-light border rounded" name="description" id="reservation_description"></textarea>
            </div>
        </div>
    </div>
    <input type="submit" name="submit" id="reservation_equipment_submit_by_item" class="cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase px-2 py-3 md:px-4 mt-4 border border-primary shadow rounded focus:outline-none" value="Create">
</div>

<!-- Confirm reservation modal -->
<div class="hidden modal" id="equip_reservation_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex items-center">
        <div id="modal-content" class="p-8 bg-white w-full sm:w-2/3 md:w-1/3 max-w-smd m-auto flex-col flex">
            <h3 class="mb-4 pb-4 border-b">Are these correct?</h3>
            <div id="modal-body" class="my-2"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-grey-darkest text-white font-bold w-full py-2 mt-2 mr-2 border border-red-light rounded focus:outline-none" id="reservation_equipment_submit_by_date_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-white text-white font-bold w-full py-2 mt-2 ml-2 border border-grey rounded focus:outline-none" id="reservation_equipment_submit_by_date_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/calendar_for_item.js"></script>
<script src="/js/flatpickr_items.js"></script>