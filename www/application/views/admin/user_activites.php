<!-- Content -->
<h1 class="pl-2 mb-8 py-1 text-xl xs:text-2xl sm:text-3xl border-l-6 border-indigo">Aktivnosti korisnika</h1>
<!-- Check if there are any entries in the db -->
<?php if(empty($user_activites)) {
        echo 'No entries';
} else { ?>
        <div class="overflow-auto">
            <table class="hidden pt-4 table stripe text-center w-full text-grey-darker text-sm">
                <thead class="bg-grey-light font-medium uppercase text-sm text-grey-dark border border-grey-light">
                    <tr class="table-row">
                        <th>Email</th>
                        <th>Type</th>
                        <th>Success</th>
                        <th>Description</th>
                        <th>IP address</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($user_activites as $activity) { ?> 
                        <tr>
                            <td><?= $activity['email'] ?></td>
                            <td><?= $activity['log_type'] ?></td>
                            <td><?= $activity['success'] == 1 ? 'Yes' : 'No' ?></td>
                            <td><?= $activity['log_description'] ?></td>
                            <td><?= $activity['ip_address'] ?></td>
                            <td><?= $activity['log_time'] ?></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
<?php } ?>