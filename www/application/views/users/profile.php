<?php
    if($this->input->cookie('usr-vezba') == NULL) {
        url_redirect('/users');
    } else {
        $cookie = $this->input->cookie('usr-vezba'); ?>
        <div class="container mt-5">
            <h1>Welcome, <?= $this->session->userdata[$cookie]; ?>!</h1>
            <div class="row">
                <div class="col"><button class="button btn-info btn-block">Create A Reservation</button></div>
                <div class="col"><button class="button btn-info btn-block">See Current Reservation</button></div>
            </div>
        </div>
    <?php }
    