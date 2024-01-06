<?php
session_start();  
require_once 'common/connect.php';
require_once 'common/checkAuth.php';
require_once 'common/alert.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $user['id'];

    if ($id) {
        $result = deleteAvatar($id);
    }
    if ($result) {
        $_SESSION['user']['avatar'] = 'no-ava.jpg';
        header("Location: settings.php");
        $_SESSION['status'] = 'Avatar deleted successfully';
    }
}
?>
