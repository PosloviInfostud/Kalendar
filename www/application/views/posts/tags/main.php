<h1 class="mb-5">Tags</h1>
<?php
    $btn_colors = ['primary', 'secondary', 'success', 'info', 'warning', 'danger'];
    foreach($tags as $tag) { ?>
        <a href="/tags/<?= $tag['id'] ?>" class="btn btn-<?= $btn_colors[array_rand($btn_colors)] ?>"><?= $tag['name'] ?></a>
    <?php } ?>