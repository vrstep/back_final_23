<?php
session_start();
require_once 'common/connect.php';
require_once 'common/checkAuth.php';

$oldPassword = $_POST['oldPassword'] ?? '';
$newPassword = $_POST['newPassword'] ?? '';
$confirmNewPassword = $_POST['confirmNewPassword'] ?? '';
$user_id = $user['id'];

$errors = [];

if (empty($oldPassword)) {
    $errors['oldPassword'] = 'Old password is empty';
} else {
    // Check if old password is correct
    $queryObj = $pdo->prepare("SELECT password FROM users WHERE id = :id");
    $queryObj->execute(['id' => $user_id]);
    $user = $queryObj->fetch(PDO::FETCH_ASSOC);
    if ($user['password'] !== md5($oldPassword)) {
        $errors['oldPassword'] = 'Old password is incorrect';
    }
}

if (empty($newPassword)) {
    $errors['newPassword'] = 'New password is empty';
} else {
    if (strlen($newPassword) < 6) {
        $errors['newPassword'] = 'Password length should be at least 6 symbols';
    }
}

if (empty($confirmNewPassword)) {
    $errors['confirmNewPassword'] = 'Confirm new password is empty';
} else {
    if ($confirmNewPassword !== $newPassword) {
        $errors['confirmNewPassword'] = 'Passwords does not match';
    }
}

if (empty($errors)) {
    // Update password
    $queryObj = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
    try {
        $queryObj->execute(['password' => md5($newPassword), 'id' => $user_id]);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
    $_SESSION['status'] = 'Password changed successfully';
} else {
    // Handle errors
    $_SESSION['status'] = 'Password change failed: ' . implode(', ', $errors);
}
header('Location: settings.php');
exit();
?>
