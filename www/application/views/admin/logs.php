<h3 class="mt-5 mb-3">List of all logs</h3>

<!-- Check if there are any entries in the db -->
<?php if(empty($logs)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed table-striped border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">User</th>
                    <th scope="col">Table</th>
                    <th scope="col">Type</th>
                    <th scope="col">Value</th>
                    <th scope="col">Timestamp</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($logs as $log) { ?> 
                    <tr>
                        <td class="align-middle text-center"><?= $log['user_email'] ?></td>
                        <td class="align-middle text-center"><?= $log['altered_table'] ?></td>
                        <td class="align-middle text-center"><?= $log['type'] ?></td>
                        <td class="align-middle"><?= $log['value'] ?></td>
                        <td class="align-middle text-center"><?= $log['created_at'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>