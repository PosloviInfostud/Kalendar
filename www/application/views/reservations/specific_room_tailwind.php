<div class="max-w-md mx-auto">
    <!-- Breadcrumb -->
    <div class="flex text-xs sm:text-sm text-black px-2 pb-3 sm:px-0">
        <span>Rezervacije</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span>Sastanci</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span class="text-primary font-normal">Kreiranje nove rezervacije</span>
    </div>
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:p-8">
        <div id="form_errors" class="hidden bg-red-lightest text-red text-sm mb-6 p-4 border-l-6 border-red-lighter"></div>
        <div class="flex flex-inline">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Novi sastanak</h1>
            <span class="uppercase text-grey font-medium text-sm ml-1">pretraga po određenoj sali</span>
        </div>
    </div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow mt-4 px-4 py-8 sm:p-8">
        <p class="mb-4">Koju salu želite da rezervišete?</p>
        <select name="room" id="room_select" class="select_room w-full p-2 font-light bg-grey-lighter border rounded js-example-basic-single">
            <option selected="true" disabled="disabled">Izaberi salu</option> 
            <?php foreach ($rooms as $room) { ?>
                <option value="<?= $room['id']; ?>" data-room_name="<?= $room['name'] ?>"><?= $room['name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div id="show" class="hidden mt-4"><!-- views\reservations\load_calendar_for_room_tailwind --></div>
</div>