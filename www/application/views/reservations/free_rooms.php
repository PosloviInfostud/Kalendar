<?php var_dump($message); die; ?>
<table class="table">

    <thead>
        <th>No.</th>
        <th>Name</th>
    </thead>
    <tbody>
    <?php foreach($message as $room) { ?> 
        <tr>
            <td><?= $room['id'] ?></td>
            <td><?= $room['name'] ?></td>
        </tr>
        <?php } ?>    
    </tbody>
</table>