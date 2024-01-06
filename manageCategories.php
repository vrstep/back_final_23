<?php
if(!isset($_SESSION)) { session_start(); }
require_once 'common/checkAdmin.php';
require_once 'common/connect.php';

function updateCategory($id, $name)
{
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE categories SET category_name = :name WHERE id = :id");
    try {
        $queryObj->execute(['id' => $id, 'name' => $name]);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        return false;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        deleteCategory($id);
        $_SESSION['status'] = 'Category deleted successfully';
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        updateCategory($id, $name);
        $_SESSION['status'] = 'Category updated successfully';
    } elseif (isset($_POST['create'])) {
        $name = $_POST['new_category_name'];
        createCategory($name);
        $_SESSION['status'] = 'Category created successfully';
    }
    header('Location: settings.php');
}

$categories = getCategories();
?>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Manage Categories</h1>
                    <form action="manageCategories.php" method="post">
                        <div class="form-group">
                            <label for="newCategoryNameInput">New Category Name</label>
                            <input name="new_category_name" type="text" class="form-control" id="newCategoryNameInput">
                        </div>
                        <div class="form-group py-3">
                            <button type="submit" name="create" class="btn btn-primary">Create</button>
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
                            <?php foreach ($categories as $category) : ?>
                                <tr>
                                    <th scope="row"><?= $category['id'] ?></th>
                                    <td>
                                        <form action="manageCategories.php" method="post">
                                            <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                            <input name="name" type="text" value="<?= $category['name'] ?>">
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