<!-- Breadcrumbs -->
<div class="flex text-sm text-black py-3 border-b mb-8">
    <span>Admin</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span>Reservations</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal">Meetings</span>
</div>
<!-- Content -->
<h1 class="pl-2 mb-6 py-1 text-xl xs:text-2xl sm:text-3xl border-l-6 border-indigo">Meetings</h1>
<!-- Check if there are any entries in the db -->
<?php if(empty($reservations)) {
    echo 'No entries';
} else { ?>
    <div class="justify-center overflow-auto">
        <table id="meetings_table" class="hidden pt-4 table stripe text-center w-full text-grey-darker text-sm">
            <thead class="bg-grey-light font-medium uppercase text-sm text-grey-dark border border-grey-light">
                <tr>
                    <th class="py-4">Title</th>
                    <th class="py-4">Description</th>
                    <th class="py-4">Owner</th>
                    <th class="py-4">Start</th>
                    <th class="py-4">End</th>
                    <th class="py-4">Created</th>
                    <th class="py-4">Recurring</th>
                </tr>
            </thead>
            <tbody class="bg-white">
            <?php foreach($reservations as $res) { ?> 
                    <tr>
                        <div class="my-2">
                            <td class="py-4 my-2"><?= $res['title'] ?></td>
                            <td class="py-2 my-2"><?= $res['description'] ?></td>
                            <td class="py-2 my-2"><?= $res['user_name'] ?></td>
                            <td class="py-2 my-2"><?= $res['start_time'] ?></td>
                            <td class="py-2 my-2"><?= $res['end_time'] ?></td>
                            <td class="py-2 my-2"><?= $res['created_at'] ?></td>
                            <td class="py-2 my-2">Yes / No</td>
                        </div>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>