<div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:p-8">
    <div id="room_errors" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-6 border-red-lighter"></div>
    <div class="md:flex mb-4 mt-4 md:mt-0">
        <div class="md:w-1/3 md:pr-4 mb-2 md:mb-0">
            <label class="">Koju salu želite da rezervišete?</label>
        </div>
        <div class="md:w-2/3">
            <?php if(empty($rooms)) { ?>
            <p>U zadatom terminu nema slobodnih sala. Pokušajte ponovo.</p>
            <?php } else {
                foreach($rooms as $room) { ?>
                <div class="py-1">
                    <input type="radio" name="room" class="room_radio" value="<?= $room['id'] ?>" data-room_name="<?= $room['name'] ?>" enabled>
                    <label><?= $room['name'] ?></label>
                </div>
                <?php }
            } ?>
        </div>
    </div>
    
    <div class="md:flex mt-6 sm:mt-8 mb-4">
        <div class="md:w-1/3 mb-2 md:mb-0">
            <label for="res_frequency" class="mr-4 font-light">Učestalost</label>
        </div>
        <div class="md:w-2/3">
            <select id="res_frequency" class="w-full bg-grey-lighter p-2 font-light border rounded capitalize">
                <?php foreach($frequencies as $freq) { ?>
                    <option value="<?= $freq['id'] ?>"><?= $freq['name'] ?></option>
                    <?php } ?>
            </select>
        </div>
    </div>
    <div class="md:flex mt-6 sm:mt-8 mb-4">
        <div class="md:w-1/3 mb-2 md:mb-0">
            <label for="title" class="mr-4">Naziv sastanka</label>
        </div>
        <div class="md:w-2/3">
            <input type="text" name="title" id="reservation_name" class="w-full p-2 font-light bg-grey-lighter border rounded">
        </div>
    </div>
    <div class="md:flex mt-6 sm:mt-8 mb-4">
        <div class="md:w-1/3 mb-2 md:mb-0">
            <label for="description" class="mr-4">Opišite detaljnije temu sastanka (ako želite)</label>
        </div>
        <div class="md:w-2/3">
            <textarea name="description" rows="4" id="reservation_description" class="w-full p-2 font-light bg-grey-lighter border rounded"></textarea>
        </div>
    </div>
    <div class="md:flex mt-6 sm:mt-8">
        <div class="md:w-1/3 mb-2 md:mb-0">
            <label for="description" class="mr-4">Koga želite da pozovete?</label>
        </div>
        <div class="md:w-2/3">
        <select class="js-example-basic-multiple w-full p-2 font-light bg-grey-lighter border rounded" name="members[]" id="members" multiple="multiple">
            <?php foreach($users as $user) { ?>
                <option value="<?= $user['email'] ?>"><?= $user['name'] ?><small> (<?= $user['email'] ?>)</small></option>
            <?php  } ?>
        </select>
        </div>
    </div>
    <!-- Submit button for mobile view  -->
    <button class="reservation_room_submit_by_date sm:hidden cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase px-2 py-3 md:px-4 mt-8 sm:mt-4 border border-primary shadow rounded focus:outline-none">Rezerviši</button>
</div>
<!-- Submit button for desktop view  -->
<button class="reservation_room_submit_by_date hidden sm:block cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase px-2 py-3 md:px-4 mt-4 border border-primary shadow rounded focus:outline-none">Rezerviši</button>


<!-- Confirm reservation modal -->
<div class="hidden modal" id="room_reservation_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex items-center">
        <div id="modal-content" class="p-8 bg-white w-full max-w-sm m-auto flex-col flex rounded shadow">
            <h2 class="pl-2 py-1 text-2xl sm:text-3xl border-l-6 mb-4 border-red">Potvrdite rezervaciju</h2>
            <div id="modal-body" class="my-4"></div>
            <div class="flex flex-inline justify-between mt-2">
                <button type="button" class="bg-red hover:bg-red-dark text-white font-medium w-full py-2 mt-2 mr-2 border border-red-light rounded focus:outline-none" id="reservation_room_submit_by_date_modal-btn-yes">Potvrdi</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-grey-dark hover:text-grey-darkest font-medium w-full py-2 mt-2 ml-2 border border-grey rounded focus:outline-none" id="reservation_room_submit_by_date_modal-btn-no">Otkaži</button>
            </div>
        </div>
    </div>
</div> 

<script src="/js/select2.js"></script>