<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <div>
            <h1>
            Reservation Details
            <small class="text-muted">(<?= $equipment['status'] ?>)</small>
            </h1>
        </div>
        <div>
            <?php if($user_id == $equipment['user_id']) { ?>
                <button data-equip="<?= $equipment['id'] ?>" id="edit_equip_btn" class="btn btn-info">Edit</button>
                <a href="/reservations/delete_equipment_reservation/<?= $equipment['id'] ?>"><button id="delete_equip_btn" class="btn btn-danger ml-2">Delete</button></a>
            <?php } ?>
        </div>
    </div>
    <div class="my-3" id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
    <hr>
    <div class="row mt-1">
        <div class="col-2"><b>Item reserved:</b></div>
        <div class="col-10"><?= $equipment['item_name'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Reservation ends on:</b></div>
        <div class="col-10"><?= $equipment['end_time'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Description:</b></div>
        <div class="col-10"><?= $equipment['full_description'] ?></div>
    </div>
    <div class="d-flex justify-content-end"><a href="/reservations/equipment/"><button class="btn btn-secondary">Back</button></a></div>

<!-- Edit Equipment Reservation -->
<div class="modal fade" id="editEquipModal" tabindex="-1" role="dialog" aria-labelledby="editEquipModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit equipment termin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small id="edit_error_msg" class="text-danger"></small>
        <div id="edit_equip_modal_body"></div>
      </div>
    </div>
  </div>
</div>

<script src="/js/reservations.js"></script>