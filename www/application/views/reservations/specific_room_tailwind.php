<div class="max-w-md mx-auto">
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
        <span class="text-primary font-normal">New Meeting</span>
    </div>
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow p-8">
        <h1 class="font-normal text-xl xs:text-2xl sm:text-3xl">Create a new meeting</h1>
        <p class="mt-8 mb-4">Which conference room do you want to reserve?</p>
        <select name="room" id="room_select" class="select_room w-full p-2 font-light bg-grey-lighter border rounded">
            <option selected="true" disabled="disabled">Choose room</option> 
            <?php foreach ($rooms as $room) { ?>
                <option value="<?= $room['id']; ?>"><?= $room['name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div id="show" class="hidden mt-4"></div>
</div>