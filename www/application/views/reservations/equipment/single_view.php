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
                <a href="#"><button class="btn btn-info">Edit</button></a><a href="#"><button class="btn btn-danger ml-2">Delete</button></a>
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
