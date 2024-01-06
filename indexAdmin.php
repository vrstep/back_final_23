<?php
    session_start();
    require_once 'common/checkAuth.php';
    require_once 'common/checkAdmin.php';
    require_once 'common/connect.php';

    $user = $_SESSION['user'];
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
            /* Add this CSS */
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }
            .container.py-4 {
                flex: 1;
            }
        </style> 
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
                            <h1>Hello, <?= $user['name'] ?></h1>
                        </div>
                        <div class="col-lg-12">
                            <p class="lead">What would you like to do today?</p>
                        </div>
                        <div class="col-lg-12">
                            <a href="manageUsers.php" class="btn btn-primary">Manage users</a>
                            <a href="managePosts.php" class="btn btn-primary">Manage posts</a>
                            <a href="manageCategories.php" class="btn btn-primary">Manage categories</a>
                            <a href="manageTags.php" class="btn btn-primary">Manage tags</a>
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
