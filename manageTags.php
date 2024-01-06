<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'common/checkAdmin.php';
require_once 'common/connect.php';

function updateTag($id, $name)
{
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE tags SET tag_name = :name WHERE id = :id");
    try {
        $queryObj->execute(['id' => $id, 'name' => $name]);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
    return true;
}

function deleteTag($id)
{
    global $pdo;
    $queryObj = $pdo->prepare("DELETE FROM tags WHERE id = :id");
    try {
        $queryObj->execute(['id' => $id]);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        deleteTag($id);
        $_SESSION['status'] = 'Tag deleted successfully';
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        updateTag($id, $name);
        $_SESSION['status'] = 'Tag updated successfully';
    }
}

$tags = getTags();
?>

<!-- Page content-->
<div class="container py-4">
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-12">
            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                <div class="col-lg-12">
                    <h1>Manage Tags</h1>
                    <form action="createTag.php" method="post">
                        <div class="form-group">
                            <label for="nameInput">Tag Name</label>
                            <input name="name" type="text" class="form-control" id="nameInput">
                        </div>
                        <div class="form-group py-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tags as $tag) : ?>
                                <tr>
                                    <th scope="row"><?= $tag['id'] ?></th>
                                    <td>
                                        <form action="manageTags.php" method="post">
                                            <input type="hidden" name="id" value="<?= $tag['id'] ?>">
                                            <input name="name" type="text" value="<?= $tag['tag_name'] ?>">
                                            <button type="submit" name="update">Update</button>
                                            <button type="submit" name="delete">Delete</button>
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