<!-- Content -->
<h1 class="pl-2 mb-6 py-1 text-xl xs:text-2xl sm:text-3xl border-l-6 border-indigo">Sastanci</h1>
<!-- Check if there are any entries in the db -->
<?php if(empty($reservations)) {
    echo 'Nema rezervacija';
} else { ?>
    <div class="justify-center overflow-auto">
        <table id="meetings_table" class="hidden pt-4 table stripe text-center w-full text-grey-darker text-sm">
            <thead class="bg-grey-light font-medium uppercase text-sm text-grey-dark border border-grey-light">
                <tr>
                    <th class="py-4">Naziv</th>
                    <th class="py-4">Opis</th>
                    <th class="py-4">Sala</th>
                    <th class="py-4">Kreator</th>
                    <th class="py-4">Dan</th>
                    <th class="py-4">Trajanje</th>
                    <th class="py-4">Kreirano</th>
                    <th class="py-4">Ponavljajući</th>
                </tr>
            </thead>
            <tbody class="bg-white">

            <?php foreach($reservations as $res) { ?> 
                    <tr>
                        <div class="my-2">
                            <td class="py-4 my-2"><?= $res['title'] ?></td>
                            <td class="py-2 my-2"><?= $res['description'] ?></td>
                            <td class="py-2 my-2"><?= $res['room'] ?></td>
                            <td class="py-2 my-2"><?= $res['user_name'] ?></td>
                            <td class="py-2 my-2"><?= $res['day'] ?></td>
                            <td class="py-2 my-2"><?= $res['duration'] ?></td>
                            <td class="py-2 my-2"><?= $res['created_at'] ?></td>
                            <td class="py-2 my-2"><?= $res['recurring'] ?></td>

                        </div>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>