<!-- Breadcrumbs -->
<div class="flex text-sm text-black py-3 border-b mb-8">
    <span>Admin</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal">Logovi</span>
</div>
<!-- Content -->
<h1 class="pl-2 mb-6 py-1 text-xl xs:text-2xl sm:text-3xl border-l-6 border-indigo">Logovi</h1>
<!-- Check if there are any entries in the db -->
<?php if(empty($logs)) {
        echo 'No entries';
} else { ?>
        <div class="overflow-auto">
            <table class="hidden pt-4 table stripe text-center w-full text-grey-darkest text-sm">
                <thead class="bg-grey-light font-medium uppercase text-sm text-grey-dark border border-grey-light">
                    <tr>
                        <th class="py-4">Korisnik</th>
                        <th class="py-4">Tabela</th>
                        <th class="py-4">Tip promene</th>
                        <th class="py-4">Promena</th>
                        <th class="py-4">Vreme</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($logs as $log) { ?> 
                        <tr class="table-row">
                            <td class="table-cell"><?= $log['user_email'] ?></td>
                            <td class="table-cell"><?= $log['altered_table'] ?></td>
                            <td class="table-cell"><?= $log['type'] ?></td>
                            <td class="table-cell"><?= $log['value'] ?></td>
                            <td class="table-cell"><?= $log['created_at'] ?></td>
                        </tr>
                <?php } ?>
                </tbody>
            </table>
        </div> 
<?php } ?>