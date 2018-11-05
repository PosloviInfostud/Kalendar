<h2>New Meeting on <?= $starttime; ?></h2>
<p>Dear <?=$name; ?>, </p>
<p>We have a new meeting, details below: </p>
<ul>
    <li><strong>Room: </strong><?= $room; ?></li>
    <li><strong>Title: </strong><?= $title; ?></li>
    <?php if($description != "") { ?> 
    <li><strong>Description: </strong><?= $description; ?></li>
    <?php } ?>
    <li><strong>Day: </strong><?= $day; ?></li>
    <li><strong>Time: </strong><?= $time; ?></li>
</ul>
<p>See you!</p>