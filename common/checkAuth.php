<?php

    if(isset($_SESSION['user']))
        $user = $_SESSION['user'];
    else {
        $_SESSION['status'] = 'mainError';
        $_SESSION['message'] = 'First you need to login';
        header("Location: loginForm.php");
    }

?>