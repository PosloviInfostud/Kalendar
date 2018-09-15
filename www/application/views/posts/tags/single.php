<h1>Posts tagged with: <strong><?= $tag[0]['name'] ?></strong></h1>
<hr>
    <?php if(empty($posts)) {
        echo 'No posts.';
    } else { ?>
<ul>
    <?php foreach($posts as $post) { ?>
        <li><a href="/posts/<?= $post['id'] ?>"><?= $post['title'] ?></a></li>
    <?php }} ?> 
</ul>