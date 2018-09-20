<h1 class="mb-5">Tags</h1>
<div class="tags">
    <?php
    foreach($tags as $tag) { ?>
    <a href="/tags/<?= $tag['id'] ?>" id="<?= $tag['id'] ?>" class="tag-buttons btn btn-secondary"><?= $tag['name'] ?></a>
    <?php } ?>
</div>

<div id="result" class="mt-5">
    <ul id="posts"></ul>
</div>

<script src="/js/main.js"></script>