<?php
    session_start();
    require_once 'common/checkAuth.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        require_once 'common/connect.php';
        $result = createTag($name);
        $_SESSION['status'] = 'Tag created successfully';

        if($result)
            header("Location: settings.php");
    }
?>
