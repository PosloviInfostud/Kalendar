<div class="bg-white border-x sm:border-y sm:rounded shadow p-8">
    <div id="equipment_errors" class="hidden mb-8 text-red text-sm p-4 border border-red bg-red-lightest"></div>
<?php if(empty($items)) { ?>
        <p>Sorry, nothing is available at the moment! Check again!</p>
<?php }  else { ?>
        <div class="md:flex mb-4">
            <div class="md:w-1/3 mb-2 md:mb-0">
                <label for="equipment_type" class="mr-4 font-light">Which one?</label>
            </div>
            <div class="md:w-2/3">
                <?php
                $i = 99999;
                foreach($items as $item) { ?>
                    <div class="custom-radio">
                        <input type="radio" id="customRadio<?= $i; ?>" name="equipment_id" value="<?= $item['id'] ?>" class="radio_equipment_id" enabled>
                        <label for="customRadio<?= $i; ?>">
                            <?= $item['name']; ?>
                            <small>(Code: <?= $item['barcode']; ?>)</small>
                        </label>
                    </div>
                <?php
                $i++;
                } ?>
            </div>
        </div>
        <div class="md:flex mt-8">
            <div class="md:w-1/3 mb-2 md:mb-0">
                <label for="equipment_type" class="mr-4 font-light">Reason for reservation?</label>
            </div>
            <div class="md:w-2/3">
                <textarea rows="4" class="w-full bg-grey-lighter p-3 font-light border rounded" name="description" id="reservation_description"></textarea>
            </div>
        </div>
</div>
<input type="submit" name="submit" id="reservation_equipment_submit_by_date" class="cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase px-2 py-3 md:px-4 mt-4 border border-primary shadow rounded focus:outline-none" value="Create">

<!-- Confirm reservation modal -->
<div class="hidden modal" id="equip_reservation_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex items-center">
        <div id="modal-content" class="p-8 bg-white w-full sm:w-2/3 md:w-1/3 max-w-smd m-auto flex-col flex">
            <h3 class="mb-4 pb-4 border-b">Are these correct?</h3>
            <div id="modal-body" class="my-2"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-grey-darkest text-white font-bold w-full py-2 mt-2 mr-2 border border-red-light rounded focus:outline-none" id="reservation_equipment_submit_by_date_modal-btn-yes">Yes</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-white text-white font-bold w-full py-2 mt-2 ml-2 border border-grey rounded focus:outline-none" id="reservation_equipment_submit_by_date_modal-btn-no">No</button>
            </div>
        </div>
    </div>
</div>

<?php }; ?>