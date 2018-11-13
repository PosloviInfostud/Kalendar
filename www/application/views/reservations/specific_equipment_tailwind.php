<div class="max-w-md mx-auto">
    <!-- Breadcrumb -->
    <div class="flex text-xs sm:text-sm text-black px-2 pb-3 sm:px-0">
        <span>Rezervacije</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span>Oprema</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span class="text-primary font-normal">Kreiranje nove rezervacije</span>
    </div>
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:px-8 sm:py-6">
        <div class="flex flex-inline">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Nova rezervacija</h1>
            <span class="uppercase text-grey font-medium text-sm ml-1">pretraga po određenom artiklu</span>
        </div>
    </div>
    <div class="bg-white border-x sm:border-y sm:rounded shadow mt-4 px-4 py-8 sm:p-8">
        <p class="mb-4">Koju stavku želite da rezervišete?</p>
        <select name="room" id="room" class="js-example-basic-single select_item w-full p-2 bg-grey-lighter font-light rounded">
            <option selected="true" disabled="disabled">Izaberite</option>
            <?php foreach ($equipment as $item) { ?>
                <option value="<?= $item['id']; ?>"><?= $item['equipment_type_name']; ?>, <?= $item['name']; ?> (<?= $item['barcode']; ?>, <?= $item['description']; ?>)</option>
            <?php } ?>
        </select>
    </div>
    <div id="show" class="hidden mt-4"><!-- views/reservations/load_calendar_for_item_tailwind --></div>
</div>