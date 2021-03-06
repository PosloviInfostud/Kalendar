<!-- Data for calendar -->
<script>
    var current_reservations = <?= $current_reservations ?>;
    var background = "<?= $background; ?>";
</script>

<div class="max-w-md mx-auto">
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow p-4 sm:p-8">
        <!-- Title -->
        <div class="flex flex-inline">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary"><?= $meeting['title'] ?></h1>
            <span class="uppercase text-grey font-medium text-sm ml-1">Izmena</span>
        </div>
    </div>
    <!-- Fullcalendar -->
    <button id="show_calendar" class="bg-grey hover:bg-grey-dark text-white font-bold mt-4 py-3 w-full shadow rounded focus:outline-none">Raspored sastanaka za izabranu salu</button>
    <div class="hidden my-4" id="calendar"></div>
    <!-- Details -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow mt-4 p-4 sm:p-8">
        <div id="form_errors" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-6 border-red-lighter"></div>
        <form id="form_update_room_reservation">
            <div class="mt-2 mb-8">
                <p class="text-lg mb-2">Odaberite salu</p>
                <select name="room" id="update_room_select" class="select_room select-text bg-grey-lighter p-2 font-light text-center border rounded w-full js-example-basic-single">
                    <?php foreach ($rooms as $room) { ?>
                        <?php if($room['id'] == $meeting['room_id']) { ?>
                            <option value="<?= $room['id']; ?>" selected><?= $room['name']; ?></option>
                        <? } else { ?>
                            <option value="<?= $room['id']; ?>"><?= $room['name']; ?></option>
                    <?php }
                        } ?>
                </select>
            </div>
            <div class="mb-8">
                <p class="text-lg mb-2">Kada će se sastanak odviti?</p>
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-2 sm:w-1/2">
                        <span class="sm:mr-2 text-grey text-sm uppercase">od</span>
                        <input type="text" name="start_time" id="datetime_start" placeholder="početak" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" data-default-date="<?= $meeting['starttime'] ?>"> 
                        <input type="hidden" name="default_start_time" id="default_datetime_start" value="<?= $meeting['starttime'] ?>">
                    </div>
                    <div class="sm:flex items-center sm:w-1/2">
                        <span class="sm:mr-2 text-grey text-sm uppercase">do</span>
                        <input type="text" name="end_time" id="datetime_end" placeholder="kraj" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" data-default-date="<?= $meeting['endtime'] ?>">
                        <input type="hidden" name="default_end_time" id="default_datetime_end" value="<?= $meeting['endtime'] ?>">
                    </div>
                </div>
            </div>
            <div class="mt-2 mb-8">
                <p class="text-lg mb-2">Naziv sastanka</p>
                <input type="text" class="bg-grey-lighter p-2 w-full font-light border rounded" name="title" id="reservation_name" value="<?= $meeting['title'] ?>">
            </div>
            <div class="mt-2 mb-8">
                <p class="text-lg mb-2">Opišite detaljnije temu sastanka (ako želite)</p>
                <textarea rows="4" class="bg-grey-lighter font-light p-2 w-full border rounded" id="reservation_description"><?= $meeting['description'] ?></textarea>
            </div>
            <input type="hidden" name="res" id="res" value="<?= $meeting['id'] ?>">
            <input type="hidden" name="parent" id="parent" value="<?= $meeting['parent'] ?>">
            <!-- Check if it's a recurring reservation -->
            <?php if($meeting['recurring'] == 1) { ?>
                <div class="mb-4">
                    <input type="checkbox" class="" id="update_all_child_reservations">
                    <label class="form-check-label" for="update_all_child_reservations">Ažuriraj sve ponavljajuće rezervacije u ovom terminu</label>
                </div>
            <?php } ?>
            <div>
                <input type="checkbox" class="" id="send_email_update">
                <label class="form-check-label" for="send_email_update">Pošalji email obaveštenja članovima sastanka o promenama</label>
            </div>
        </form>
    </div>
    <input type="submit" name="submit" id="update_reservation_room" form="form_update_room_reservation" class="cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold text-sm uppercase py-3 mt-4 px-4 rounded" value="Ažuriraj">
</div>