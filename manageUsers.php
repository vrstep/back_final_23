<?php
if(!isset($_SESSION)) { session_start(); }
require_once 'common/checkAdmin.php';
require_once 'common/connect.php';

function getUsers()
{
    global $pdo;
    $queryObj = $pdo->query("SELECT * FROM users");
    $users = $queryObj->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function changeUserRole($id, $role)
{
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE users SET role = :role WHERE id = :id");
    try {
        $queryObj->execute(['id' => $id, 'role' => $role]);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $role = $_POST['role'];
    changeUserRole($id, $role);
    $_SESSION['status'] = 'User role changed successfully';
    header('Location: settings.php');
}

$users = getUsers();
?>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Manage Roles</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <th scope="row"><?= $user['id'] ?></th>
                                        <td><?= $user['name'] ?></td>
                                        <td><?= $user['role'] ?></td>
                                        <td>
                                            <form action="manageUsers.php" method="post">
                                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                <select name="role">
                                                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                    <option value="moderator" <?= $user['role'] == 'moderator' ? 'selected' : '' ?>>Moderator</option>
                                                </select>
                                                <button type="submit">Update</button>
                                            </form>
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