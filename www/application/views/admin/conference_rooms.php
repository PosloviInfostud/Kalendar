<h3 class="mt-5 mb-3">Conference Rooms</h3>

<!-- Check if there are any entries in the db -->
<?php if(empty($rooms)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed table-striped border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Capacity</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($rooms as $room) { ?> 
                    <tr>
                    <td class="align-middle text-center"><?= $room['name'] ?></td>
                        <td class="align-middle"><?= substr($room['description'], 0, 120).'...' ?></td>
                        <td class="align-middle text-center"><?= $room['capacity'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>