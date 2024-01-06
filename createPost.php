<?php

	session_start();

	require_once 'common/checkAuth.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$title = $_POST['title'];
		$content = $_POST['content'];
		$category_id = $_POST['category_id'];
		$tag_id = $_POST['tag_id'] ?? [];

		$user_id = $user['id'];

		$status = $_POST['status'] ?? 'draft';

		$image = $_FILES['image']; // $image is an array

		$time = time(); // $time = 1231232134
		$image_name = $time . $image['name']; // $image_name = 1231232134girl.png
		$image_tmp_name = $image['tmp_name']; // $image_tmp_name = C:\xampp\tmp\phpAE3C.tmp
		$image_destination_path = 'images/posts/' . $image_name;

		$allowed_files = ['png', 'jpg', 'jpeg', 'webp'];
		$extension = explode('.', $image_name); // [1231232134girl, png]
		$extension = end($extension); // $extension = 'png'

		if (in_array($extension, $allowed_files)) {
			if ($image['size'] < 1000000) {
				move_uploaded_file($image_tmp_name, $image_destination_path);
			} else {
				$errors['image'] = "File Size Too Big. Choose Less Than 1mb File..!";
			}
		} else {
			$errors['image'] = "File Should Be PNG, JPG, JPEG or WEBP";
		}

		require_once 'common/connect.php';
		$result = createPost($title, $content, $category_id, $user_id, $status, $image_name);

		if($result) {
            $post_id = $pdo->lastInsertId();

            // Add tags for the post
            foreach($tag_id as $tag){
				$queryObj=$pdo->prepare("INSERT INTO post_tags(post_id,tag_id) VALUES(:post_id,:tag_id)");
				$queryObj->execute(['post_id'=>$post_id,'tag_id'=>$tag]);
			}
			

            header("Location: index.php");
        }

	}

?>