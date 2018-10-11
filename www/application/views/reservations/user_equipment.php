<div class="container mt-5">
    <h1>
        Equipment reservations
    </h1>
    <div class="my-3" id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
    <div class="row p-3 mb-3 text-center align-items-center border-bottom">
        <div class="col-1">ID</div>
        <div class="col">What</div>
        <div class="col-4">Why</div>
        <div class="col">Until</div>
    </div>
<?php
foreach($equipment as $item) { ?>
    <div data-id="" class="row p-3 mb-2 text-sm bg-info text-center align-items-center text-white equipment-card">
        <div class="col-1"><?= $item['id'] ?></div>
        <div class="col"><?= $item['item_name'] ?></div>
        <div class="col-4"><?= $item['description'] ?></div>
        <div class="col"><?= $item['end_time'] ?></div>
    </div>
<?php } ?>
<div class="my-3 float-right"><a href="/reservations">Back to my reservations</a></div>
</div>