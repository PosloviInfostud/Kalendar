<h2>Novi sastanak | <?= $starttime; ?></h2>
<p>Detalji ispod: </p>
<ul>
    <li><strong>Sala: </strong><?= $room; ?></li>
    <li><strong>Naziv: </strong><?= $title; ?></li>
    <?php if($description != "") { ?> 
    <li><strong>Opis: </strong><?= $description; ?></li>
    <?php } ?>
    <li><strong>Dan: </strong><?= $day; ?></li>
    <li><strong>Vreme: </strong><?= $time; ?></li>
</ul>
<p>Vidimo se!</p>