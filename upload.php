<?php
session_start();

require_once 'common/checkAuth.php';
require_once 'common/connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){   
    $id = $user['id'];
    $old_avatar = $_POST['avatar'];

    if(!empty($_FILES['fileToUpload']['name'])){
        $avatar = $_FILES['fileToUpload'];
        $time = time();
        $avatar_name = $time . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = 'images/avatars/' . $avatar_name;

        $allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
        $extension = explode('.', $avatar_name);
        $extension = end($extension);

        if(in_array($extension, $allowed_files)){
            if($avatar['size'] < 1000000){
                move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
            }else{
                $errors['avatar'] = "File Size Too Big. Choose Less Than 1mb File..!";
            }
        }else{
            $errors['avatar'] = "File Should Be PNG, JPG, JPEG or WEBP";
        }
    }else{
        $avatar_name = $old_avatar;
    }

    require_once 'common/connect.php';
    $result = editAvatar($id, $avatar_name);

    if($result){
        $_SESSION['user']['avatar'] = $avatar_name;
        header("Location: settings.php");
        $_SESSION['status'] = 'Avatar updated successfully';
    }
}
?>