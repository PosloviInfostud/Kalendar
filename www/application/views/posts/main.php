<h1 class="mb-5">Latest Blog Posts</h1>

<?php
    if($posts === FALSE) {
        echo 'No posts.';
    } else { ?>

    <table class="table table-hover">
        <thead class="thead-light">
        <tr>
        <th scope="col">Title</th>
        <th scope="col">Published</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($posts as $post) { ?>
        <tr>
        <td><a href="/posts/<?= $post['id'] ?>"><?= $post['title'] ?></a></td>
        <td><?= date( "d/m/Y", strtotime($post['created_at'])); ?></td>
        <td><a href="/posts/delete/<?= $post['id']; ?>">Delete</a> | <a href="/posts/update/<?= $post['id']; ?>">Edit</a></td>
        </tr>
        <?php }; ?>

        <?php }; ?>

    </tbody>
</table>
