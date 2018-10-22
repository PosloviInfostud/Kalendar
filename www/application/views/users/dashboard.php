<div class="container mt-5">
    <h1>Dashboard</h1>
    <div class="my-3" id="flash_message"><?= $this->session->flashdata('flash_message') ?></div>
    <div class="row mt-5">
        <div class="col"><a href="/reservations/create" class="btn btn-outline-info btn-lg btn-block btn-options">Create A Reservation</a></div>
        <div class="col"><a href="/reservations" class="btn btn-outline-info btn-lg btn-block btn-options">See Current Reservations</a></div>
    </div>
</div>