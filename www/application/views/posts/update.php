<div class="content">
<h1 class="mb-5">Update Post</h1>
<form action="/posts/update_post/<?= $post['id']; ?>" method="POST">
    <fieldset>
    <div class="form-group">
        <label for="exampleInputEmail1">Title</label>
        <input type="text" class="form-control" name="post_title" id="Title" aria-describedby="emailHelp" value="<?= $post['title'] ?>">
    </div>
    <div class="form-group">
        <label for="exampleTextarea">Body</label>
        <textarea class="form-control" name="post_content" id="exampleTextarea" rows="6"><?= $post['content'] ?></textarea>
    </div>
    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label for="exampleSelect2">Post Tags</label>
          <select name="post_tags[]" multiple="multiple" size="6" class="form-control" id="exampleSelect2">
            <?php foreach($all_tags as $tag) { ?>
              <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $tags) ? "selected" : "" ?>><?= $tag['name'] ?></option>
            <?php } ?>
          </select>
        </div>
      <div class="col-8">
      </div>
    </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </fieldset>
</form>

</div>