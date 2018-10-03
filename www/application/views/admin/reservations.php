<h3 class="mt-5 mb-3">List of all reservations</h3>

<!-- Check if there are any entries in the db -->
<?php if(empty($reservations)) {
        echo 'No entries';
} else { ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Item</th>
                    <th scope="col">Created by</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Created @</th>
                    <th scope="col">Members</th>
                    <th scope="col">Deleted</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($reservations as $res) { ?> 
                    <tr>
                        <td><?= $res['title'] ?></td>
                        <td><?= $res['description'] ?></td>
                        <td><?= $res['item_name'] ?></td>
                        <td><?= $res['user_name'] ?></td>
                        <td><?= $res['start_time'] ?></td>
                        <td><?= $res['end_time'] ?></td>
                        <td><?= $res['created_at'] ?></td>
                        <td><button class="btn btn-secondary btn-sm">Members</button></td>
                        <td><?= $res['deleted'] == 1 ? 'Yes' : 'No' ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>