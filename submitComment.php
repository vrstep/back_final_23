<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postId = $_POST['post_id'];
    $parentId = !empty($_POST['parent_id']) ? $_POST['parent_id'] : NULL;
    $userId = $user['id'];
    $comment = $_POST['comment'];

    $queryObj = $pdo->prepare("INSERT INTO comments (post_id, parent_id, user_id, comment) VALUES (?, ?, ?, ?)");
    $result = $queryObj->execute([$postId, $parentId, $userId, $comment]);

    if (!$result) {
        print_r($queryObj->errorInfo());
    }

    header("Location: onePost.php?post_id=$postId");
}
?>
