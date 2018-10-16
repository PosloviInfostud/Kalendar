<h2>New Meeting on <?= $start_time; ?></h2>
    <p><?= $admin_name; ?> (<?= $admin_mail; ?>) has invited you on a meeting.</p>
    We have a meeting in a <?= $room; ?> from <?= $start_time; ?> until <?= $end_time; ?>.<br>
    <p>We recommend you to register!</p>
    <a href="<?= invitation_registration_link($email, $token); ?>" class="btn btn-block btn-danger"><span>Click on this link to register!</span></a>


    See you!</p>