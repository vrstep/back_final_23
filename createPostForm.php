<?php

session_start();

require_once 'common/checkAuth.php';
require_once 'common/connect.php';

$categories = getCategories();
$tags = getTags();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Homepage</title>
    <?php require_once 'common/inhead.php'; ?>
</head>

<body>
    <?php require_once 'common/nav.php' ?>

    <!-- Page content-->
    <div class="container py-4">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">

                <form action="createPost.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titleInput">Post title</label>
                        <input name="title" type="text" class="form-control" id="titleInput">
                    </div>
                    <div class="form-group">
                        <label for="contentInput">Post content</label>
                        <textarea name="content" class="form-control" id="contentInput" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="categoryInput">Categories</label>
                        <select name="category_id" class="form-control" id="categoryInput">
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= $cat['id'] ?>"> <?= $cat['name'] ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tagInput">Tags</label>
                        <select name="tag_id[]" class="form-control" id="tagInput" multiple>
                            <?php foreach ($tags as $tag) : ?>
                                <option value="<?= $tag['id'] ?>"><?= $tag['tag_name'] ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="imageInput">Image</label>
                        <input name="image" type="file" class="form-control-file" id="imageInput">
                    </div>
                    <div class="form-group py-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>

            <?php require_once 'common/aside.php' ?>
        </div>
    </div>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>