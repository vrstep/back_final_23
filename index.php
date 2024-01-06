<?php

session_start();

require_once 'common/checkAuth.php';
require_once 'common/connect.php';

$categories = getCategories();
$tags = getTags();

$search = $_POST['search'] ?? '';

$page = $_GET['page'] ?? 1; // Get the current page number, default is 1
$postsPerPage = 4; // Number of posts per page
$catId = $_GET['cat_id'] ?? null; // Get the category ID if a category filter is applied
$tagId = $_GET['tag_id'] ?? null; // Get the tag ID if a tag filter is applied

$posts = getPostsPagination($page, $postsPerPage, $catId, $tagId); // Retrieve the posts for the current page

$totalPages = getTotalPages($postsPerPage, $catId, $tagId); // Get the total number of pages


// $posts - getPosts();

if ($search) {
    $posts = searchPosts($search);
}
// elseif (isset($_GET['cat_id'])) {
//     $catId = $_GET['cat_id'] ?? null;

//     if ($catId)
//         $posts = getPosts($catId);
// } elseif (isset($_GET['tag_id'])) {
//     $tagId = $_GET['tag_id'] ?? null;

//     if ($tagId) {
//         $posts = getPostsByTagId($tagId);
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Homepage</title>
    <?php require_once 'common/inhead.php'; ?>
    <style>
        .card-body form {
            display: inline;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once 'common/nav.php' ?>
    <div class="container py-4">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                <!-- Nested row for non-featured blog posts-->
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <?php foreach ($posts as $post) : ?>
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="images/posts/<?= $post['image'] ?>" alt="..."></a>
                                <div class="card-body">
                                    <div class="small text-muted"><?= $post['created_at'] ?></div>
                                    <div class="small text-muted">author: <?= $post['name'] ?></div>
                                    <?php $tags = getPostTags($post['id']); ?>
                                    <div class="small text-muted">tags:
                                        <?php foreach ($tags as $tag) : ?>
                                            <a href='index.php?tag_id=<?= $tag['id'] ?>'><?= $tag['tag_name'] ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                    <h2 class="card-title h4"><?= $post['title'] ?></h2>
                                    <p class="card-text"><?= $post['content'] ?></p>
                                    <a class="btn btn-primary" href="onePost.php?post_id=<?= $post['id'] ?>">Read →</a>

                                    <?php if ($post['user_id'] == $user['id']) : ?>

                                        <a class="btn btn-primary" href="editPostForm.php?post_id=<?= $post['id'] ?>">Edit →</a>

                                        <form onsubmit="return confirm('Really want to delete?')" action="deletePost.php" method="post">
                                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                            <button class="btn btn-danger" type="submit">
                                                Delete
                                            </button>
                                        </form>

                                    <?php endif; ?>

                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
                <!-- Pagination -->
                <nav aria-label="Pagination">
                    <hr class="my-0" />
                    <ul class="pagination justify-content-center my-4">
                        <?php
                        $totalPages = getTotalPages($postsPerPage, $catId, $tagId); // Get the total number of pages
                        for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?= (isset($_GET['page']) && $i == $_GET['page']) ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>


            </div>

            <?php require_once 'common/aside.php' ?>
        </div>
    </div>
    <?php require_once 'common/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>