<script>
    var current_reservations = <?= $current_reservations; ?>;
    var background = "<?= $background; ?>";
</script>
<!-- Breadcrumb -->
<div class="flex text-xs sm:text-sm text-black px-2 pb-3 sm:px-0">
    <span>Reservations</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span>Meetings</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal"><?= $meeting['title'] ?></span>
</div>
<!-- Content -->
<div class="md:flex">
    <div>
        <div class="md:flex-grow bg-white border-x sm:border-y sm:rounded shadow p-4">
            <h1 class="font-normal text-lg xs:text-xl sm:text-2xl my-2">Update "<?= $meeting['title'] ?>"</h1>
            <form id="form_update_room_reservation" class="mt-8">
                <div class="mt-2 mb-8">
                    <p class="font-normal text-lg mb-2">Select conference room</p>
                    <select name="room" id="update_room_select" class="select_room select-text bg-grey-lighter p-2 font-light text-center border rounded w-full">
                        <?php foreach ($rooms as $room) { ?>
                            <?php if($room['id'] == $meeting['room_id']) { ?>
                                <option value="<?= $room['id']; ?>" selected><?= $room['name']; ?></option>
                            <? } else { ?>
                                <option value="<?= $room['id']; ?>"><?= $room['name']; ?></option>
                        <?php }
                            } ?>
                    </select>
                </div>
                <div class="mt-2 mb-8">
                    <p class="font-normal text-lg mb-2">Reservation dates</p>
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex items-center mb-2 sm:mb-0 sm:mr-2 sm:w-1/2">
                            <span class="sm:mr-2">From</span>
                            <input type="text" name="start_time" id="datetime_start" placeholder="start time" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" value="<?= $meeting['starttime'] ?>"> 
                            <input type="hidden" name="default_start_time" id="default_datetime_start" value="<?= $meeting['starttime'] ?>">
                        </div>
                        <div class="sm:flex items-center sm:w-1/2">
                            <span class="sm:mr-2">to</span>
                            <input type="text" name="end_time" id="datetime_end" placeholder="end time" class="w-full bg-grey-lighter p-2 font-light text-center border rounded" value="<?= $meeting['endtime'] ?>">
                            <input type="hidden" name="default_end_time" id="default_datetime_end" value="<?= $meeting['endtime'] ?>">
                        </div>
                    </div>
                </div>
                <div class="mt-2 mb-8">
                    <p class="font-normal text-lg mb-2">Title</p>
                    <input type="text" class="bg-grey-lighter p-2 w-full font-light border rounded" name="title" id="reservation_name" value="<?= $meeting['title'] ?>">
                </div>
                <div class="mt-2 mb-8">
                    <p class="font-normal text-lg mb-2">Description</p>
                    <textarea rows="4" class="bg-grey-lighter font-light p-2 w-full border rounded" id="reservation_description"><?= $meeting['description'] ?></textarea>
                </div>
                <input type="hidden" name="res" id="res" value="<?= $meeting['id'] ?>">
                <input type="hidden" name="parent" id="parent" value="<?= $meeting['parent'] ?>">
                <!-- Check if it's a recurring reservation -->
                <?php if($meeting['recurring'] == 1) { ?>
                    <div class="mb-8">
                        <input type="checkbox" class="" id="update_all_child_reservations">
                        <label class="form-check-label" for="update_all_child_reservations">Update all reservations of this recurring event</label>
                    </div>
                <?php } ?>
                <div class="mb-8">
                    <input type="checkbox" class="" id="send_email_update">
                    <label class="form-check-label" for="send_email_update">Send mail notifications to members about these changes</label>
                </div>
                <div>
                    <input type="submit" name="submit" id="reservation_room_submit_by_room" class="cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold text-sm py-2 px-4 rounded" value="Update">
                </div>
            </form>
        </div>
    </div>
    <div class="" id="calendar"></div>
</div>