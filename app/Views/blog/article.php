<?php include(APPPATH . 'Views/templates/header.php'); ?>
<section>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <img src="<?= base_url('public/uploads/articleImages/' . ($article['article_image'] ? $article['article_image'] : 'dummy.jpg')); ?>" class="card-img-top" alt="Article Image">
                    <div class="card-body">
                        <h1 class="card-title"><?= $article['title']; ?></h1>
                        <p class="card-text"><?= $article['short_description']; ?></p>
                        <hr>
                        <p class="card-text"><?= $article['full_description']; ?></p>
                        <hr>
                        <p class="card-text">Date: <?= date('F j, Y', strtotime($article['date'])); ?></p>
                        <p class="card-text">Author: <?= $article['author_nickname']; ?></p>
                    </div>
                    <div class="card-footer  d-flex justify-content-between">
                        <a type="button" href="<?php echo base_url('/blog'); ?>" class="btn btn-primary">Back Article</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(APPPATH . 'Views/templates/footer.php'); ?>
