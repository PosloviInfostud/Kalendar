<?php
    if($this->input->cookie('usr-vezba') == NULL) {
        url_redirect('/users');
    } else {
        $cookie = $this->input->cookie('usr-vezba'); ?>
        <div class="container mt-5">
            <h1>Welcome, <?= $this->session->userdata[$cookie]; ?>!</h1>
            <div class="row">
                <div class="col"><a href="/reservations/create_reservation" class="btn btn-outline-info btn-block btn-options">Create A Reservation</a></div>
                <div class="col"><a href="" class="btn btn-outline-info btn-block btn-options">See Current Reservations</a></div>
            </div>
        </div>
    <?php }
    