<div class="flex text-sm text-black pb-4 px-2 sm:px-0">
    <span>Admin</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span>Users</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal">User Activities</span>
</div>
<h3 class="mt-5 mb-3">List of all user activites</h3>

<!-- Check if there are any entries in the db -->
<?php if(empty($user_activites)) {
        echo 'No entries';
} else { ?>
        <table class="table table-text-sm table-condensed stripe border">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Type</th>
                    <th scope="col">Success</th>
                    <th scope="col">Description</th>
                    <th scope="col">IP address</th>
                    <th scope="col">Timestamp</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($user_activites as $activity) { ?> 
                    <tr>
                        <td class="align-middle text-center"><?= $activity['email'] ?></td>
                        <td class="align-middle text-center"><?= $activity['log_type'] ?></td>
                        <td class="align-middle text-center"><?= $activity['success'] == 1 ? 'Yes' : 'No' ?></td>
                        <td class="align-middle"><?= substr($activity['log_description'],0, 120).'...' ?></td>
                        <td class="align-middle text-center"><?= $activity['ip_address'] ?></td>
                        <td class="align-middle text-center"><?= $activity['log_time'] ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
<?php } ?>