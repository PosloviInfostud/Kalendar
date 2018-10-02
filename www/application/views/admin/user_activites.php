<h3 class="mt-5 mb-3">List of all user activites</h3>

<!-- Check if there are any entries in the db -->
<?php if(empty($user_activites)) {
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
            <?php foreach($user_activites as $activity) { ?> 
                    <tr>
                        <td><?= $activity['name'] ?></td>
                        <td><?= $activity['email'] ?></td>
                        <td><?= $activity['role'] ?></td>
                        <td><?= $activity['active'] == 1 ? 'Yes' : 'No' ?></td>
                        <td><?= $activity['created_at'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>