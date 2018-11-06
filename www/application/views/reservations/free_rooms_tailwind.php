<div id="room_errors" class="hidden mb-4 text-red text-sm p-4 border border-red bg-red-lightest"></div>
<div class="md:flex mb-4 mt-4 md:mt-0">
    <div class="md:w-1/3 md:pr-4 mb-2 md:mb-0">
        <label class="font-normal md:font-light">Which room do you want to reserve?</label>
    </div>
    <div class="md:w-2/3">
        <?php if(empty($rooms)) { ?>
        <p>No free rooms for this time. Try again.</p>
        <?php } else {
            $i=1; 
            foreach($rooms as $room) { ?>
            <div class="py-1">
                <input type="radio" id="customRadio<?= $i; ?>" name="room" class="room_radio" value="<?= $room['id'] ?>" enabled>
                <label for="customRadio<?= $i; ?>" class=""><?= $room['name'] ?></label>
            </div>
            <?php $i++;}
        } ?>
    </div>
</div>

<div class="md:flex mt-8 mb-4">
    <div class="md:w-1/3 mb-2 md:mb-0">
        <label for="res_frequency" class="mr-4 font-normal md:font-light">Frequency</label>
    </div>
    <div class="md:w-2/3">
        <select id="res_frequency" class="w-full md:w-1/3 bg-grey-lighter p-2 border rounded">
            <?php foreach($frequencies as $freq) { ?>
                <option value="<?= $freq['id'] ?>"><?= $freq['name'] ?></option>
                <?php } ?>
        </select>
    </div>
</div>
<div class="md:flex mt-8 mb-4">
    <div class="md:w-1/3 mb-2 md:mb-0">
        <label for="title" class="mr-4 font-normal md:font-light">What is the name of the event?</label>
    </div>
    <div class="md:w-2/3">
        <input type="text" name="title" id="reservation_name" class="w-full md:w-3/4 p-3 bg-grey-lighter border rounded">
    </div>
</div>
<div class="md:flex mt-8 mb-4">
    <div class="md:w-1/3 mb-2 md:mb-0">
        <label for="description" class="mr-4 font-normal md:font-light">Describe it to the attendants</label>
    </div>
    <div class="md:w-2/3">
        <textarea name="description" rows="4" id="reservation_description" class="w-full md:w-3/4 p-3 bg-grey-lighter border rounded"></textarea>
    </div>
</div>
<div class="md:flex mt-8 mb-4">
    <div class="md:w-1/3 mb-2 md:mb-0">
        <label for="description" class="mr-4 font-normal md:font-light">Who do you want to invite?</label>
    </div>
    <div class="md:w-2/3">
    <select class="js-example-basic-multiple w-full md:w-3/4 p-3 bg-grey-lighter border rounded" name="members[]" id="members" multiple="multiple">
        <?php foreach($users as $user) { ?>
            <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
        <?php  } ?>
    </select>
    </div>
</div>
<div class="md:flex mt-8 mb-4">
    <div class="hidden md:block md:w-1/3">
    </div>
    <div class="md:w-2/3">
        <input type="submit" name="submit" id="reservation_room_submit_by_date" class="cursor-pointer w-full md:w-3/4 py-2 px-2 md:px-4 bg-primary hover:bg-primary-dark text-white font-bold border-b-4 border-primary-dark rounded hover:shadow-inner" value="Create">
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
                <button type="button" class="bg-red hover:bg-red-dark text-grey-darkest text-white font-bold w-full py-2 mt-2 mr-2 border border-red-light rounded" id="reservation_room_submit_by_date_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-white text-white font-bold w-full py-2 mt-2 ml-2 border border-grey rounded" id="reservation_room_submit_by_date_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div> 

<script src="/js/select2.js"></script>