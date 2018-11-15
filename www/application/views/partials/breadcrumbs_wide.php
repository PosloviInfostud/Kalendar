<div class="flex text-sm text-black pb-3 border-b">
    <?php
    $crumbs = explode('/', $_SERVER['REQUEST_URI']);

    for ($i=1; $i<count($crumbs)-1; $i++) { ?>

        <?php if($crumbs[$i] == 'kreiraj') { ?>
        <span class="text-primary font-normal">Kreiranje nove rezervacije</span>
        <?php break; } ?>
        <span><?= ucfirst($crumbs[$i]) ?></span>
        <div class="fill-current h-2 w-2 mx-1 -mt-px">
            <?= file_get_contents("public/icons/chevron-right.svg") ?>
        </div>
        <?php 
        ?>

    <?php } ?>
    <?php if(!in_array("kreiraj", $crumbs) && !ctype_digit($crumbs[count($crumbs)-1])) { ?>
    <span class="text-primary font-normal"><?= ucfirst($crumbs[count($crumbs)-1]) ?></span>
    <?php  } ?>
    <?php if(ctype_digit($crumbs[count($crumbs)-1])) { ?>
    <span class="text-primary font-normal"><?= substr_replace($title_for_layout, "", -3) ?></span>
    <?php  } ?>

</div>

