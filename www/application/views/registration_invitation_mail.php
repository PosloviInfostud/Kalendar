<h2>Novi sastanak: <?= $start; ?></h2>
    <p><?= $admin_name; ?> (<?= $admin_mail; ?>) te je pozvao/la na sastanak.</p>
    Imamo sastanak u sali "<?= $room; ?>" od <?= $start; ?> do <?= $end; ?>.<br>
    <p>Preporučujemo ti da se registruješ.</p>
    <a href="<?= invitation_registration_link($email, $token); ?>" class="btn btn-block btn-danger"><span>Klikni na ovaj link koji će te odvesti do forme za registraciju!</span></a>
    Vidimo se!</p>
