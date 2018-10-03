<h3 class="mt-5 mb-3">List of all logs</h3>

<!-- Check if there are any entries in the db -->
<?php if(empty($users)) {
        echo 'No entries';
} else { ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Active</th>
                    <th scope="col">Registered @</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user) { ?> 
                    <tr>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td><?= $user['active'] == 1 ? 'Yes' : 'No' ?></td>
                        <td><?= $user['created_at'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>