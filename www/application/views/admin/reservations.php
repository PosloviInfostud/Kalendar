<h3 class="mt-5 mb-3">List of all reservations</h3>

<!-- Check if there are any entries in the db -->
<?php if(empty($reservations)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed table-striped border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Item</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Created</th>
                    <th scope="col">Members</th>
                    <th scope="col">Deleted</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($reservations as $res) { ?> 
                    <tr>
                        <td class="align-middle text-center"><?= $res['title'] ?>
                        <td class="align-middle"><?= substr($res['description'], 0, 120).'...' ?></td>
                        <td class="align-middle text-center"><?= $res['item_name'] ?></td>
                        <td class="align-middle text-center"><?= $res['user_name'] ?></td>
                        <td class="align-middle text-center"><?= $res['start_time'] ?></td>
                        <td class="align-middle text-center"><?= $res['end_time'] ?></td>
                        <td class="align-middle text-center"><?= $res['created_at'] ?></td>
                        <td class="align-middle text-center"><button class="btn btn-secondary btn-sm">Members</button></td>
                        <td class="align-middle text-center"><?= $res['deleted'] == 1 ? 'Yes' : 'No' ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>