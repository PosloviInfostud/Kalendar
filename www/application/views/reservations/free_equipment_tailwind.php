<div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:px-8 sm:py-6">
    <div id="equipment_errors" class="hidden bg-red-lightest text-red text-sm mb-8 p-4 border-l-6 border-red-lighter"></div>
<?php if(empty($items)) { ?>
        <p>Nažalost, u traženom terminu ništa nije slobodno. Pokušajte ponovo.</p>
<?php }  else { ?>
        <div class="md:flex mb-4">
            <div class="md:w-1/3 mb-2 md:mb-0">
                <label for="equipment_type" class="mr-4 font-light">Izaberite jednu od slobodnih stavki koji želite da rezervišete</label>
            </div>
            <div class="md:w-2/3">
                <?php
                foreach($items as $item) { ?>
                    <div class="custom-radio">
                        <input type="radio" name="equipment_id" value="<?= $item['id'] ?>" class="radio_equipment_id" enabled>
                        <label>
                            <?= $item['name']; ?>
                            <small>(Kod: <?= $item['barcode']; ?>)</small>
                        </label>
                    </div>
                <?php
                } ?>
            </div>
        </div>
        <div class="md:flex mt-8">
            <div class="md:w-1/3 mb-2 md:mb-0">
                <label for="equipment_type" class="mr-4 font-light">Svrha rezervacije</label>
            </div>
            <div class="md:w-2/3">
                <textarea rows="4" class="w-full bg-grey-lighter p-3 font-light border rounded" name="description" id="reservation_description"></textarea>
            </div>
        </div>
        <button class="reservation_equipment_submit_by_date sm:hidden cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase px-2 py-3 md:px-4 mt-6 border border-primary shadow rounded focus:outline-none">Rezerviši</button>
</div>
<!-- Button for desktop view -->
<button class="reservation_equipment_submit_by_date hidden sm:block cursor-pointer w-full bg-primary hover:bg-primary-dark text-white font-bold uppercase px-2 py-3 md:px-4 mt-4 border border-primary shadow rounded focus:outline-none">Rezerviši</button>

<!-- Confirm reservation modal -->
<div class="hidden modal" id="equip_reservation_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex items-center">
        <div id="modal-content" class="p-8 bg-white w-full max-w-sm m-auto flex-col flex sm:rounded shadow">
            <h2 class="pl-2 py-1 text-2xl sm:text-3xl border-l-6 mb-4 border-red">Potvrdite rezervaciju</h2>
            <div id="modal-body" class="my-2"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-white font-bold w-full py-2 mt-2 mr-2 border border-red-light rounded focus:outline-none" id="reservation_equipment_submit_by_date_modal-btn-yes">Potvrdi</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-grey-dark hover:text-grey-darker font-bold w-full py-2 mt-2 ml-2 border border-grey rounded focus:outline-none" id="reservation_equipment_submit_by_date_modal-btn-no">Otkaži</button>
            </div>
        </div>
    </div>
</div>

<?php }; ?>