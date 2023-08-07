<?php include(APPPATH . 'Views/templates/header.php'); ?>
<section>
  <div class="container">
    <h1 class="mt-5">Articles Listing</h1>

    <!-- Add button to create a new blog post -->
    <a href="<?php echo base_url('blog/create'); ?>" class="btn btn-primary my-3">Add</a>

    <?php if (!empty($blogPosts)) : ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Short Description</th>
                    <th>Full Description</th>
                    <th>Date</th>
                    <th>Article Image</th>
                    <th>Author Nickname</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blogPosts as $post) : ?>
                    <tr>
                        <td><?php echo $post['title']; ?></td>
                        <td><?php echo $post['short_description']; ?></td>
                        <td><?php echo $post['full_description']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($post['date'])); ?></td>
                        <td>
                            <img src="<?= base_url('public/uploads/articleImages/' . ($post['article_image'] ? $post['article_image'] : 'dummy.jpg')); ?>" alt="Article Image" class="img-thumbnail" style="width: 100px; height: auto;"/> 
                        </td>
                        <td><?php echo $post['author_nickname']; ?></td>
                        <td>
                            <!-- Action buttons -->
                            <a href="<?= base_url('blog/' . $post['slug']) ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?= base_url('blog/create?edit=' . $post['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= route_to('blog-delete', $post['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this article?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No blog posts found.</p>
    <?php endif; ?>
  </div>
</section>

<?php include(APPPATH . 'Views/templates/footer.php'); ?>
