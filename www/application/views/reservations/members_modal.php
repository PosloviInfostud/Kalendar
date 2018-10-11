<?php
foreach($members as $member) {
    if($member['res_role_id'] == 1) { ?>
        <button class="btn btn-sm btn-danger"><?= $member['name'] ?> (editor)</button>
    <?php } else { ?>
        <button class="btn btn-sm btn-secondary"><?= $member['name'] ?></button>
    <?php }
}
?>

