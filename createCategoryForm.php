<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Create Category</title>
    <?php require_once 'common/inhead.php'; ?>
</head>

<body>
    <?php require_once 'common/navAdmin.php' ?>

    <!-- Page content-->
    <div class="container py-4">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">

                <form action="createCategory.php" method="post">
                    <div class="form-group">
                        <label for="nameInput">Category Name</label>
                        <input name="name" type="text" class="form-control" id="nameInput">
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
            <p class="m-0 text-center text-white">Copyright © Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>