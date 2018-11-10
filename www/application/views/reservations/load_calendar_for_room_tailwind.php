<script>
var current_reservations = <?= $current_reservations; ?>;
var background = "<?= $background; ?>";
</script>

<div>
    <button id="show_calendar" class="bg-grey hover:bg-grey-dark text-grey-darker hover:text-grey-darkest mb-4 py-3 w-full shadow rounded focus:outline-none">Show conference room schedule</button>
    <div class="hidden mb-4" id="calendar"></div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:p-8">
        <div id="room_errors" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-6 border-red-lighter"></div>
        <form>
            <div class="mb-4">
                <p class="mb-2">When is it happening?</p>
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-1 sm:flex-2">
                        <span class="sm:mr-1 text-grey-dark uppercase text-xs">From</span>
                        <input type="text" name="start_time" id="datetime_start" placeholder="start time" class="w-full bg-grey-lighter py-2 font-light text-center border rounded"> 
                    </div>
                    <div class="sm:flex items-center mb-2 sm:mb-0 sm:flex-2">
                        <span class="sm:mr-1 text-grey-dark uppercase text-xs">to</span>
                        <input type="text" name="end_time" id="datetime_end" placeholder="end time" class="w-full bg-grey-lighter py-2 font-light text-center border rounded">
                    </div>
                    <div class="sm:flex items-center mb-2 sm:mb-0 sm:flex-1">
                        <span class="sm:ml-1 sm:mr-1 text-grey-dark uppercase text-xs">for</span>
                        <input type="number" name="attendants" id="attendants" step=1 placeholder="#" class="w-full bg-grey-lighter py-2 font-light text-center border rounded">
                        <span class="sm:ml-1 text-xs text-grey-dark uppercase">people</span>
                    </div>
                </div>
            </div>
            <div class="mt-6 sm:mt-8 mb-4">
                <p class="mb-2">Frequency</p>
                <select class="w-full p-2 font-light bg-grey-lighter border rounded capitalize" id="res_frequency">
                    <?php foreach($frequencies as $freq) { ?>
                        <option value="<?= $freq['id'] ?>"><?= $freq['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mt-6 sm:mt-8 mb-4">
                <p class="mb-2">What is the name of the event?</p>
                <input type="text" class="bg-grey-lighter p-2 w-full font-light border rounded" name="title" id="reservation_name">
            </div>
            <div class="mt-6 sm:mt-8 mb-4">
                <p class="mb-2">Describe it to the attendants</p>
                <textarea rows="4" class="bg-grey-lighter font-light p-2 w-full border rounded" id="reservation_description"></textarea>
            </div>
            <div class="mt-6 sm:mt-8">
                <p class="mb-2">Who do you want to invite?</p>
                <select class="js-example-basic-multiple w-full p-2 bg-grey-lighter border rounded" name="members[]" id="members" multiple="multiple">
                <?php foreach($users as $user) { ?>
                    <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
                <?php  } ?> 
                </select>
            </div>
            <!-- Submit button for mobile view -->
            <input type="submit" name="submit" id="reservation_room_submit_by_room" class="sm:hidden cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase py-3 px-4 mt-8 border border-primary shadow rounded focus:outline-none" value="Create">
        </form>
    </div>
    <!-- Submit button for desktop view -->
    <input type="submit" name="submit" id="reservation_room_submit_by_room" class="hidden sm:block cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase py-3 px-4 mt-4 border border-primary shadow rounded focus:outline-none" value="Create">
</div>

<!-- Confirm reservation modal -->
<div class="hidden modal" id="room_reservation_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex items-center">
    <div id="modal-content" class="p-8 bg-white w-full max-w-sm m-auto flex-col flex rounded shadow">
            <h1 class="pl-2 text-2xl sm:text-3xl border-l-6 mb-4 border-red">Are these correct?</h1>
            <div id="modal-body" class="my-4"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-white font-medium w-full py-2 mt-2 mr-2 border border-red-light rounded focus:outline-none" id="reservation_room_submit_by_room_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-grey-darker font-medium w-full py-2 mt-2 ml-2 border border-grey rounded focus:outline-none" id="reservation_room_submit_by_room_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div> 

<script src="/js/calendar_for_room.js"></script>
<script src="/js/flatpickr_rooms.js"></script>
<script src="/js/select2.js"></script>