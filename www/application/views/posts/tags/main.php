<h1 class="mb-5">Tags</h1>
<?php
    $btn_colors = ['primary', 'secondary', 'success', 'info', 'warning', 'danger'];
    foreach($tags as $tag) { ?>
        <a href="/tags/<?= $tag['id'] ?>" id="<?= $tag['id'] ?>" class="tag-buttons btn btn-<?= $btn_colors[array_rand($btn_colors)] ?>"><?= $tag['name'] ?></a>
    <?php } ?>

<div id="result">
    <ul id="posts"></ul>
</div>

<script src="/js/main.js"></script>