<h3 class="mt-5 mb-3">List of all users</h3>

<!-- Check if there are any entries in the db -->
<?php if(empty($users)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed table-striped border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Action</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Active</th>
                    <th scope="col">Registered</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user) { ?> 
                    <tr>
                        <td class="align-middle text-center"><button class="btn btn-sm btn-info user-edit" data-id="<?= $user['id'] ?>"><i class="fas fa-pencil-alt"></i></button></td>
                        <td class="align-middle text-center"><?= $user['name'] ?></td>
                        <td class="align-middle text-center"><?= $user['email'] ?></td>
                        <td class="align-middle text-center"><?= $user['role'] ?></td>
                        <td class="align-middle text-center"><?= $user['active'] == 1 ? 'Yes' : 'No' ?></td>
                        <td class="align-middle text-center"><?= $user['created_at'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>

<script src="/js/admin_users.js"></script>