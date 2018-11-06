<script>
var current_reservations = <?= $current_reservations; ?>;
var background = "<?= $background; ?>";
</script>

<div>
    <button id="show_calendar" class="bg-grey hover:bg-grey-dark text-white font-bold mb-4 py-3 w-full rounded shadow">Show conference room schedule</button>
    <div class="hidden mb-4" id="calendar"></div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow p-8">
        <div id="room_errors" class="hidden mb-4 text-red text-sm p-4 border border-red bg-red-lightest"></div>
        <form>
            <div class="mt-2 mb-8">
                <p class="mb-2">When?</p>
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-2 sm:w-1/2">
                        <span class="sm:mr-2 text-grey-dark uppercase text-sm">From</span>
                        <input type="text" name="start_time" id="datetime_start" placeholder="start time" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" value=""> 
                    </div>
                    <div class="sm:flex items-center sm:w-1/2">
                        <span class="sm:mr-2 text-grey-dark uppercase text-sm">to</span>
                        <input type="text" name="end_time" id="datetime_end" placeholder="end time" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" value="">
                    </div>
                </div>
            </div>
            <div class="mt-2 mb-8">
                <p class="mb-2">Frequency</p>
                <select class="w-full p-2 font-light bg-grey-lighter border rounded" id="res_frequency">
                    <?php foreach($frequencies as $freq) { ?>
                        <option value="<?= $freq['id'] ?>"><?= $freq['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mt-2 mb-8">
                <p class="mb-2">What is the name of the event?</p>
                <input type="text" class="bg-grey-lighter p-2 w-full font-light border rounded" name="title" id="reservation_name">
            </div>
            <div class="mt-2 mb-8">
                <p class="mb-2">Describe it to the attendants</p>
                <textarea rows="4" class="bg-grey-lighter font-light p-2 w-full border rounded"></textarea>
            </div>
            <div class="mt-2 mb-8">
                <p class="mb-2">Who do you want to invite?</p>
                <select class="js-example-basic-multiple w-full p-2 bg-grey-lighter border rounded" name="members[]" id="members" multiple="multiple">
                <?php foreach($users as $user) { ?>
                    <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
                <?php  } ?> 
                </select>
            </div>
        </form>
    </div>
    <div>
        <input type="submit" name="submit" id="reservation_room_submit_by_room" class="cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase py-3 px-4 mt-4 border border-primary shadow rounded" value="Create">
    </div>
</div>

<!-- Confirm reservation modal -->
<div class="hidden modal" id="room_reservation_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex items-center">
        <div id="modal-content" class="relative p-8 bg-white w-full sm:w-2/3 md:w-1/3 max-w-smd m-auto flex-col flex">
            <span class="absolute pin-t pin-b pin-r p-6">
                <svg class="close-modal h-6 w-6 tex-grey-lighter hover:text-grey-darkest opacity-75" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            <h3 class="mb-4 pb-4 border-b">Are these correct?</h3>
            <div id="modal-body" class="my-2"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-grey-darkest text-white font-bold w-full py-2 mt-2 mr-2 border border-red-light rounded" id="reservation_room_submit_by_room_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-white text-white font-bold w-full py-2 mt-2 ml-2 border border-grey rounded" id="reservation_room_submit_by_room_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div> 

<script src="/js/calendar_for_room.js"></script>
<script src="/js/flatpickr_rooms.js"></script>
<script src="/js/select2.js"></script>