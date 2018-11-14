<div class="flex text-sm text-black py-3 border-b mb-8">
    <?php
    $crumbs = explode('/', $_SERVER['REQUEST_URI']);

    for ($i=1; $i< count($crumbs) -1; $i++) { ?>

        <span><?= ucfirst($crumbs[$i]) ?></span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>

    <?php } ?>

    <span class="text-primary font-normal"><?= ucfirst($crumbs[count($crumbs)-1]) ?></span>
</div>