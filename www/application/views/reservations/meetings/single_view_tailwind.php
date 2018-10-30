<div class="flex text-sm text-black pb-3 px-2 sm:px-0 border-b">
    <span>Reservations</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span>Meetings</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal"><?= $meeting['title'] ?></span>
</div>
<div class="bg-white border-x sm:border-y sm:rounded shadow p-4 my-4">
    <!-- Title and buttons section -->
    <div class="flex items-center">
        <div class="w-2/3">
            <div class="flex items-top">
                <h1 class="font-normal"><?= $meeting['title'] ?></h1>
                <div class="flex flex-inline items-center h-5 ml-2 p-1 bg-primary text-white text-xs font-medium rounded"><?= $meeting['status'] ?></div>
            </div>
        </div>
        <div class="w-1/3">
            <div class="flex sm:justify-end">
                <?php if (in_array($user_id, $editors)) { ?>
                <a href="/reservations/meetings/edit/<?= $meeting['id'] ?>"><button class="bg-primary hover:bg-primary-dark text-white font-bold mr-3 py-2 px-4 border-b-4 border-primary-dark rounded hover:shadow-inner">Edit</button></a>
                <a href="/reservations/meetings/delete/<?= $meeting['id'] ?>" id="del_res_btn"><button class="bg-red hover:bg-red-dark text-white font-bold mr-3 py-2 px-4 border-b-4 border-red-dark rounded hover:shadow-inner">Delete</button></a>
                    <?php if($meeting['recurring'] == 1) { ?>
                        <a href="/reservations/meetings/delete/<?= $meeting['id'] ?>?option=all&parent=<?= $meeting['parent'] ?>" id="del_all_res_btn"><button class="bg-red hover:bg-red-dark text-white font-bold mr-3 py-2 px-4 border-b-4 border-red-dark rounded hover:shadow-inner">Delete All</button></a>
                    <?php } ?>            <?php } ?>
            </div>
        </div>
    </div>
    hello
</div>