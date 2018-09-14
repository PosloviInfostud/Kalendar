<?php

    if($post === FALSE) {
        echo 'Post doesn\'t exist.';
        // redirect('/posts', 'location');
    } else { ?>
    <div class="article">
        <div class="article-header">
            <h1><?= $post['title'] ?></h1>
            <small>Published by <?= $post['author'] ?> @ <?= date( "d/m/Y", strtotime($post['created_at'])); ?></small>
        </div>
        <div class="article-body mt-3">
            <?= nl2br($post['content']) ?>
        </div>
        <hr>
        <div class="tags">
            <?php foreach($tags as $tag) { ?>
                <a href="/tags/<?= $tag['id'] ?>" class="btn btn-secondary btn-sm"><?= $tag['name'] ?></a>
            <?php } ?>
        </div>
    </div>
<?php } ?>