<!-- Side widgets-->
<div class="col-lg-4">
    <!-- Search widget-->
    <div class="card mb-4">
        <div class="card-header">Search</div>
        <div class="card-body">
            <form action="index.php" method="post">
                <div class="input-group">
                    <input name="search" class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                    <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card mb-4">
        <form class="text-center" action="createPostForm.php">
        <button class="bg-light-subtle border rounded border-white p-4" href="createPost.php">Create post</button>
        </form>
    </div>

    <!-- Categories widget-->
    <div class="card mb-4">
        <div class="card-header">Categories</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($categories as $cat) : ?>
                            <li><a href="index.php?cat_id=<?= $cat['id'] ?>"><?= $cat['name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php $tags = getTags(); ?>
    <!-- Tags widget-->
    <div class="card mb-4">
        <div class="card-header">Tags</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($tags as $tag) : ?>
                            <li><a href="index.php?tag_id=<?= $tag['id'] ?>"><?= $tag['tag_name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>