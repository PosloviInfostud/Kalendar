<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <div>
            <h1>
            <?= $meeting[0]['title'] ?>
            <small class="text-muted">(<?= $meeting[0]['status'] ?>)</small>
            </h1>
        </div>
        <div>
            <?php if($user_id == $meeting[0]['creator_id']) { ?>
                <a href="/reservations/update_room_reservation_form/<?= $meeting[0]['id'] ?>"><button class="btn btn-info">Edit</button></a><a href="/reservations/delete_room_reservation/<?= $meeting[0]['id'] ?>"><button class="btn btn-danger ml-2">Delete</button></a>
            <?php } ?>
        </div>
    </div>
    <div class="my-3" id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
    <hr>
    <div class="row mt-1">
        <div class="col-2"><b>Created by:</b></div>
        <div class="col-10"><?= $meeting[0]['creator_name'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Start Time:</b></div>
        <div class="col-10"><?= $meeting[0]['start_time'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>End Time:</b></div>
        <div class="col-10"><?= $meeting[0]['end_time'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Where:</b></div>
        <div class="col-10"><?= $meeting[0]['name'] ?></div>
    </div>
    <div class="row mt-1">
        <div class="col-2"><b>Description:</b></div>
        <div class="col-10"><?= $meeting[0]['description'] ?></div>
    </div>
    <hr>
    <div class="row mt-1">
        <div class="col-2"><b>Members:</b></div>
        <div class="col-10">
            <ul>
            <?php foreach($members as $mem) { ?>
                <li><?= $mem['name'] ?> <small>(<?= $mem['email'] ?>)</small></li>
            <?php } ?>
            </ul>
        </div>
    </div>
    <div class="d-flex justify-content-end"><a href="/reservations/meetings/"><button class="btn btn-secondary">Back</button></a></div>
