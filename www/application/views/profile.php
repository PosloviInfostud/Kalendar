<?php
    if($this->input->cookie('usr-vezba') == NULL) {
        url_redirect('/users');
    } else {
        $cookie = $this->input->cookie('usr-vezba'); ?>
        <div class="container mt-5">
            <h1>Welcome, <?= $this->session->userdata[$cookie]; ?>!</h1>
        </div>
    <?php }