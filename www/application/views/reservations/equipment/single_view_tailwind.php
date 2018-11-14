<div class="max-w-md mx-auto">
    <!-- Content -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:px-8 sm:py-6">
        <!-- Title -->
        <div class="flex flex-inline mb-6">
            <h1 class="pl-2 text-xl xs:text-2xl sm:text-3xl border-l-6 border-primary">Detalji rezervacije</h1>
            <div class="h-5 ml-2 p-1 bg-primary text-white text-xs font-medium rounded"><?= $equipment['status'] ?></div>
        </div>
        <!-- Buttons -->
        <div class="flex flex-inline">
            <?php if($user_id == $equipment['user_id'] && $equipment['status'] != 'expired') { ?>
                <a href="/rezervacije/oprema/izmena/<?= $equipment['id'] ?>">
                    <button id="edit_equip_btn" class="hover:bg-primary text-grey text-sm hover:text-white mr-3 py-1 px-2 border-2 hover:border-primary rounded focus:outline-none">
                        Izmeni
                    </button>
                </a>
                <a href="/rezervacije/oprema/brisanje/<?= $equipment['id'] ?>">
                    <button id="delete_equip_btn" class="hover:bg-red text-grey text-sm hover:text-white mr-3 py-1 px-2 border-2 hover:border-red rounded focus:outline-none">
                        Obriši
                    </button>
                </a>
            <?php } ?>
        </div>
    </div>
    <!-- Reservation details -->
    <div class="bg-white border-x sm:border-y sm:rounded shadow px-4 py-8 sm:p-8 mt-4">
        <div>
            <div class="xs:flex py-1 mb-2">
                <div class="xs:w-1/4"><b>Rezervisani artikal:</b></div>
                <div class="xs:w-3/4"><?= $equipment['item_name'] ?></div>
            </div>
            <div class="xs:flex py-1 mb-2">
                <div class="xs:w-1/4"><b>Rezervisano do:</b></div>
                <div class="xs:w-3/4"><?= $equipment['end_time'] ?></div>
            </div>
            <div class="xs:flex py-1 mb-2">
                <div class="xs:w-1/4"><b>Razlog:</b></div>
                <div class="xs:w-3/4"><?= $equipment['full_description'] ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Delete member confirmation modal -->
<div class="hidden modal" id="delete_equip_reservation_confirm_modal">
    <div class="fixed pin z-50 overflow-auto bg-smoke-light flex">
        <div id="modal-content" class="p-4 sm:p-8 bg-white w-full max-w-sm m-auto flex-col flex rounded shadow">
            <div id="delete_equip_reservation_confirm_modal-body" class="my-4"></div>
            <div class="flex flex-inline justify-between">
                <button type="button" class="bg-red hover:bg-red-dark text-white font-medium w-full py-2 mt-2 mr-2 border border-red-light rounded" id="delete_equip_reservation_confirm_modal-btn-yes">Da</button>
                <button type="button" class="bg-grey hover:bg-grey-dark text-grey-dark hover:text-grey-darker font-medium w-full py-2 mt-2 ml-2 border border-grey rounded" id="delete_equip_reservation_confirm_modal-btn-no">Ne</button>
            </div>
        </div>
    </div>
</div>