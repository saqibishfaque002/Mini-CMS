<?php include(APPPATH . 'Views/templates/header.php'); ?>
<section>
  <div class="container">
    <h1><?= isset($post) ? 'Edit Article' : 'Add Article' ?></h1>
    <!-- Display validation errors, if any -->
    <form method="post" action="<?= isset($post) ? base_url('blog/update/' . $post['id']) : base_url('blog/store') ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= isset($post) ? $post['title'] : old('title'); ?>" required>
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="<?= isset($post) ? $post['slug'] : old('slug'); ?>" required>
        </div>
        <div class="form-group">
            <label>Short Description</label>
            <textarea name="short_description" class="form-control" required><?= isset($post) ? $post['short_description'] : old('short_description'); ?></textarea>
        </div>
        <div class="form-group">
            <label>Full Description</label>
            <textarea name="full_description" class="form-control" required><?= isset($post) ? $post['full_description'] : old('full_description'); ?></textarea>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?= isset($post) ? date('Y-m-d', strtotime($post['date'])) : date('Y-m-d') ; ?>" required>
        </div>
        <div class="mb-3">
            <label for="article_image" class="form-label">Article Image</label>
            <input type="file" class="form-control" id="article_image" name="article_image" accept="image/*"  required>
        </div>
        <div class="form-group">
            <label>Author Nickname</label>
            <input type="text" name="author_nickname" class="form-control" value="<?= isset($post) ? $post['author_nickname'] : old('author_nickname') ?>" required>
        </div>
        <div class="form-group d-flex justify-content-between">
            <a type="button" href="<?php echo base_url('/blog'); ?>" class="btn btn-primary">Back Article</a>
            <button type="submit" class="btn btn-primary"><?= isset($post) ? 'Update' : 'Add' ?> Article</button>
        </div>
    </form>
</div>
</section>

<?php include(APPPATH . 'Views/templates/footer.php'); ?>
