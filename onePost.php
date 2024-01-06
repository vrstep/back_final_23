<?php

session_start();

require_once 'common/checkAuth.php';
require_once 'common/connect.php';

$categories = getCategories();

$postId = $_GET['post_id'] ?? null;

if ($postId)
    $post = getOnePost($postId);

$avg = getRating($postId); // $avg is an array

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
                <!-- Post content-->
                <article>
                    <!-- Post header-->
                    <header class="mb-4">
                        <!-- Post title-->
                        <h1 class="fw-bolder mb-1"><?= $post['title'] ?></h1>
                        <h4>
                            <?php

                            // if ($avg['rating'])
                            //     echo "rating: " . round($avg['rating'], 2);
                            // else
                            //     echo "not rated";

                            ?>
                        </h4>
                        <!-- Post meta content-->
                        <div class="text-muted fst-italic mb-2"><?= $post['created_at'] ?></div>

                    </header>
                    <!-- Preview image figure-->
                    <figure class="mb-4"><img class="img-fluid rounded" src="images/posts/<?= $post['image'] ?>" alt="..." /></figure>
                    <!-- Post content-->
                    <section class="mb-5">
                        <?= $post['content'] ?>
                    </section>
                </article>

                <form action="rate.php" method="post">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <select class="form-select" name="rating">
                        <option value="1">very bad (1)</option>
                        <option value="2">bad (2)</option>
                        <option value="3">ok (3)</option>
                        <option value="4">good (4)</option>
                        <option value="5">very good (5)</option>
                    </select>
                    <button type="submit" class="btn btn-info my-3">Rate</button>
                </form>

                <!-- Comments section-->
                <section class="mb-5">
                    <div class="card bg-light">
                        <div class="card-body">
                            <form class="mb-4" action="submitComment.php" method="post">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <input type="hidden" name="parent_id" id="parent_id">
                                <textarea class="form-control" rows="3" name="comment" placeholder="Join the discussion and leave a comment!"></textarea>
                                <button type="submit" class="btn btn-primary">Comment</button>
                            </form>
                            <?php
                            function displayComments($comments)
                            {
                                foreach ($comments as $comment) {
                                    echo '<div class="d-flex mb-4" id="comment-' . $comment['id'] . '">';
                                    echo '<div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..."></div>';
                                    echo '<div class="ms-3">';
                                    echo '<div class="fw-bold">' . $comment['user_name'] . '</div>';
                                    echo $comment['comment'];
                                    echo '<button class="btn btn-link reply-btn" data-comment-id="' . $comment['id'] . '">Reply</button>';
                                    echo '<div id="reply-form-' . $comment['id'] . '"></div>'; // Div to hold the reply form

                                    // Display replies
                                    if (!empty($comment['replies'])) {
                                        echo '<div class="ms-3">'; // Add some margin for nested comments
                                        displayComments($comment['replies']);
                                        echo '</div>';
                                    }

                                    echo '</div></div>';
                                }
                            }

                            $comments = getComments($post['id']);
                            displayComments($comments);

                            ?>




                        </div>
                    </div>
                </section>
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
    <!-- <script src="js/scripts.js"></script> -->
    <script>
        document.querySelectorAll('.reply-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                let commentId = this.getAttribute('data-comment-id');
                let replyFormDiv = document.getElementById('reply-form-' + commentId);
                let replyForm = document.createElement('form');
                replyForm.setAttribute('action', 'submitComment.php');
                replyForm.setAttribute('method', 'post');
                replyForm.innerHTML = '<input type="hidden" name="post_id" value="<?= $post['id'] ?>">' +
                    '<input type="hidden" name="parent_id" value="' + commentId + '">' +
                    '<textarea class="form-control" rows="3" name="comment" placeholder="Write your reply here..."></textarea>' +
                    '<button type="submit" class="btn btn-primary">Submit Reply</button>' +
                    '<button type="button" class="btn btn-secondary cancel-btn">Cancel</button>';
                replyFormDiv.appendChild(replyForm);

                // Add event listener to the cancel button after it is appended to the DOM
                replyForm.querySelector('.cancel-btn').addEventListener('click', function() {
                    this.parentElement.remove();
                });
            });
        });
    </script>
</body>

</html>