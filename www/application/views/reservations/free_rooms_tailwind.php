<div class="bg-white border-x sm:border-y sm:rounded shadow p-8">
    <div id="room_errors" class="hidden mb-8 text-red text-sm p-4 border border-red bg-red-lightest"></div>
    <div class="md:flex mb-4 mt-4 md:mt-0">
        <div class="md:w-1/3 md:pr-4 mb-2 md:mb-0">
            <label class="">Which room do you want to reserve?</label>
        </div>
        <div class="md:w-2/3">
            <?php if(empty($rooms)) { ?>
            <p>No free rooms for this time. Try again.</p>
            <?php } else {
                $i=1; 
                foreach($rooms as $room) { ?>
                <div class="py-1">
                    <input type="radio" id="customRadio<?= $i; ?>" name="room" class="room_radio" value="<?= $room['id'] ?>" enabled>
                    <label for="customRadio<?= $i; ?>"><?= $room['name'] ?></label>
                </div>
                <?php $i++;}
            } ?>
        </div>
    </div>
    
    <div class="md:flex mt-8 mb-4">
        <div class="md:w-1/3 mb-2 md:mb-0">
            <label for="res_frequency" class="mr-4 font-light">Frequency</label>
        </div>
        <div class="md:w-2/3">
            <select id="res_frequency" class="w-full bg-grey-lighter p-2 font-light border rounded">
                <?php foreach($frequencies as $freq) { ?>
                    <option value="<?= $freq['id'] ?>"><?= $freq['name'] ?></option>
                    <?php } ?>
            </select>
        </div>
    </div>
    <div class="md:flex mt-8 mb-4">
        <div class="md:w-1/3 mb-2 md:mb-0">
            <label for="title" class="mr-4">What is the name of the event?</label>
        </div>
        <div class="md:w-2/3">
            <input type="text" name="title" id="reservation_name" class="w-full p-2 font-light bg-grey-lighter border rounded">
        </div>
    </div>
    <div class="md:flex mt-8 mb-4">
        <div class="md:w-1/3 mb-2 md:mb-0">
            <label for="description" class="mr-4">Describe it to the attendants</label>
        </div>
        <div class="md:w-2/3">
            <textarea name="description" rows="4" id="reservation_description" class="w-full p-2 font-light bg-grey-lighter border rounded"></textarea>
        </div>
    </div>
    <div class="md:flex mt-8">
        <div class="md:w-1/3 mb-2 md:mb-0">
            <label for="description" class="mr-4">Who do you want to invite?</label>
        </div>
        <div class="md:w-2/3">
        <select class="js-example-basic-multiple w-full p-2 font-light bg-grey-lighter border rounded" name="members[]" id="members" multiple="multiple">
            <?php foreach($users as $user) { ?>
                <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
            <?php  } ?>
        </select>
        </div>
    </div>
</div>
<input type="submit" name="submit" id="reservation_room_submit_by_date" class="cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase px-2 py-3 md:px-4 mt-4 border border-primary shadow rounded focus:outline-none" value="Create">

<!-- Confirm reservation modal -->
<div class="hidden modal" id="room_reservation_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex items-center">
        <div id="modal-content" class="p-8 bg-white w-full sm:w-2/3 md:w-1/3 max-w-smd m-auto flex-col flex">
            <h3 class="mb-4 pb-4 border-b">Are these correct?</h3>
            <div id="modal-body" class="my-2"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-grey-darkest text-white font-bold w-full py-2 mt-2 mr-2 border border-red-light rounded focus:outline-none" id="reservation_room_submit_by_date_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-white text-white font-bold w-full py-2 mt-2 ml-2 border border-grey rounded focus:outline-none" id="reservation_room_submit_by_date_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div> 

<script src="/js/select2.js"></script>