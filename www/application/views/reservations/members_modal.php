<?php var_dump($members);

foreach($members as $member) {
    if($member['res_role_id']) { ?>
         <p><?= $member['name'] ?> (editor)</p>
    <?php } else { ?>
        <p> <?= $member['name'] ?></p>
    <?php }
}
?>

