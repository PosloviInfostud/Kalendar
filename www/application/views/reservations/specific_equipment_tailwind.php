<div class="max-w-md mx-auto">
    <!-- Breadcrumb -->
    <div class="flex text-xs sm:text-sm text-black px-2 pb-3 sm:px-0">
        <span>Reservations</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span>Equipment</span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <span class="text-primary font-normal">New Reservation</span>
    </div>
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow p-8">
        <h1 class="pl-2 font-normal text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Create a new meeting</h1>
        <p class="mt-8 mb-4">Which item would you like to reserve?</p>
        <select name="room" id="room" class="js-example-basic-single select_item w-full p-2 bg-grey-lighter font-light rounded">
            <option selected="true" disabled="disabled">Choose an item</option>
            <?php foreach ($equipment as $item) { ?>
                <option value="<?= $item['id']; ?>"><?= $item['equipment_type_name']; ?>, <?= $item['name']; ?> (<?= $item['barcode']; ?>, <?= $item['description']; ?>)</option>
            <?php } ?>
        </select>
    </div>
    <div id="show" class="hidden mt-4"></div>
</div>