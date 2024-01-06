<?php
    session_start();
    require_once 'common/checkAdmin.php';
    require_once 'common/connect.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        deletePost($id);
    }

    $posts = getPosts();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Manage Posts</title>
        <?php require_once 'common/inhead.php'; ?>  
    </head>
    <body>
        <?php require_once 'common/navAdmin.php' ?>
        
        <!-- Page content-->
        <div class="container py-4">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-12">
                    <!-- Nested row for non-featured blog posts-->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1>Manage Posts</h1>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($posts as $post): ?>
                                        <tr>
                                            <th scope="row"><?= $post['id'] ?></th>
                                            <td><?= $post['title'] ?></td>
                                            <td>
                                                <form action="managePosts.php" method="post">
                                                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                                    <button type="submit">Delete</button>
                                                </form>
                                                <a href="editPostForm.php?id=<?=$post['id'] ?>">Update</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright © Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
