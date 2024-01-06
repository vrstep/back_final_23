<?php

try {
	$pdo = new PDO("mysql:host=localhost;dbname=blog;", "root", "1234");
} catch (PDOException $ex) {
	echo $ex->getMessage();
}

function registerUser($email, $password, $name, $avatar = 'no-ava.jpg', $role = 'user')
{

	global $pdo;
	$queryObj = $pdo->prepare("insert into users(email, password, name, role, avatar) values(:ue, :up, :un, :ur, :ua)");

	try {
		$queryObj->execute([
			'ue' => $email,
			'up' => md5($password),
			'un' => $name,
			'ur' => $role,
			'ua' => $avatar,
		]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	return true;
}

function loginUser($email, $password)
{
	global $pdo;
	$queryObj = $pdo->prepare("select * from users where email = :ue and password = :up");

	$queryObj->execute([
		'ue' => $email,
		'up' => md5($password)
	]);

	$user = $queryObj->fetch(PDO::FETCH_ASSOC);
	return $user;
}


function getComments($postId, $parentId = NULL)
{
	global $pdo;

	// Fetch all comments for the given post ID and parent ID
	$queryObj = $pdo->prepare("SELECT comments.*, users.name AS user_name FROM comments LEFT JOIN users ON comments.user_id=users.id WHERE comments.post_id = ? AND (comments.parent_id = ? OR (? IS NULL AND comments.parent_id IS NULL)) ORDER BY comments.created_at DESC");
	$queryObj->execute([$postId, $parentId, $parentId]);
	$comments = $queryObj->fetchAll(PDO::FETCH_ASSOC);

	// Fetch replies for each comment
	foreach ($comments as &$comment) {
		$comment['replies'] = getComments($postId, $comment['id']);
	}

	return $comments;
}

function getCategories()
{
	global $pdo;
	$queryObj = $pdo->query("select * from categories");
	$categories = $queryObj->fetchAll(PDO::FETCH_ASSOC);
	return $categories;
}

function createCategory($name)
{
	global $pdo;
	$queryObj = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
	try {
		$queryObj->execute(['name' => $name]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	return true;
}

function deleteCategory($id)
{
	global $pdo;
	$queryObj = $pdo->prepare("DELETE FROM categories WHERE id = :id");
	try {
		$queryObj->execute(['id' => $id]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	return true;
}

function editCategory($id, $name)
{
	global $pdo;
	$queryObj = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
	try {
		$queryObj->execute(['id' => $id, 'name' => $name]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	return true;
}

function getTags()
{
	global $pdo;
	$queryObj = $pdo->query("select * from tags");
	$tags = $queryObj->fetchAll(PDO::FETCH_ASSOC);
	return $tags;
}

function createTag($name)
{
	global $pdo;
	$queryObj = $pdo->prepare("INSERT INTO tags(tag_name) VALUES (:name)");
	try {
		$queryObj->execute(['name' => $name]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	return true;
}

function editTag($id, $name)
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

function createPost($title, $content, $category_id, $user_id, $status = 'draft', $image = 'no-img.jpg')
{

	global $pdo;
	$queryObj = $pdo->prepare("insert into posts(title, content, category_id, user_id, status, image, created_at) values(:ptt, :pcn, :pci, :pui, :pst, :pim, :pca)");

	date_default_timezone_set('Asia/Almaty');

	try {
		$queryObj->execute([
			'ptt' => $title,
			'pcn' => $content,
			'pci' => $category_id,
			'pui' => $user_id,
			'pst' => $status,
			'pim' => $image,
			'pca' => date("Y-m-d H:i:s", time()),
		]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	return true;
}

function getPosts($catId = null)
{
	global $pdo;

	if ($catId) {
		$queryObj = $pdo->prepare("SELECT posts.*, users.name FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.category_id = ? ORDER BY posts.created_at DESC");
		$queryObj->execute([$catId]);
	} else {
		$queryObj = $pdo->query("SELECT posts.*, users.name FROM posts LEFT JOIN users ON posts.user_id=users.id ORDER BY posts.created_at DESC");
	}

	$posts = $queryObj->fetchAll(PDO::FETCH_ASSOC);
	return $posts;
}

function getPostsPagination($page, $postsPerPage, $catId = null, $tagId = null) {
    global $pdo;

    // Calculate the starting post
    $start = ($page - 1) * $postsPerPage;

    if ($catId) {
        $queryObj = $pdo->prepare("SELECT posts.*, users.name FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.category_id = :catId ORDER BY posts.created_at DESC LIMIT :start, :postsPerPage");
        $queryObj->bindValue(':catId', $catId, PDO::PARAM_INT);
    } elseif ($tagId) {
        $queryObj = $pdo->prepare("SELECT posts.*, users.name FROM posts JOIN post_tags ON posts.id = post_tags.post_id LEFT JOIN users ON posts.user_id=users.id WHERE post_tags.tag_id = :tagId ORDER BY posts.created_at DESC LIMIT :start, :postsPerPage");
        $queryObj->bindValue(':tagId', $tagId, PDO::PARAM_INT);
    } else {
        $queryObj = $pdo->prepare("SELECT posts.*, users.name FROM posts LEFT JOIN users ON posts.user_id=users.id ORDER BY posts.created_at DESC LIMIT :start, :postsPerPage");
    }

    $queryObj->bindValue(':start', $start, PDO::PARAM_INT);
    $queryObj->bindValue(':postsPerPage', $postsPerPage, PDO::PARAM_INT);
    $queryObj->execute();

    $posts = $queryObj->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

function getTotalPages($postsPerPage, $catId = null, $tagId = null) {
    global $pdo;

    if ($catId) {
        $queryObj = $pdo->prepare("SELECT COUNT(*) as total FROM posts WHERE category_id = :catId");
        $queryObj->bindValue(':catId', $catId, PDO::PARAM_INT);
    } elseif ($tagId) {
        $queryObj = $pdo->prepare("SELECT COUNT(*) as total FROM posts JOIN post_tags ON posts.id = post_tags.post_id WHERE post_tags.tag_id = :tagId");
        $queryObj->bindValue(':tagId', $tagId, PDO::PARAM_INT);
    } else {
        $queryObj = $pdo->query("SELECT COUNT(*) as total FROM posts");
    }

    $queryObj->execute();
    $result = $queryObj->fetch(PDO::FETCH_ASSOC);

    return ceil($result['total'] / $postsPerPage);
}


// function getTotalPages($postsPerPage) {
//     global $pdo;

//     $queryObj = $pdo->query("SELECT COUNT(*) as total FROM posts");
//     $result = $queryObj->fetch(PDO::FETCH_ASSOC);

//     return ceil($result['total'] / $postsPerPage);
// }


function searchPosts($search)
{
	global $pdo;

	if ($search) {
		$queryObj = $pdo->prepare("select * from posts where title like :search OR content like :search");
		$queryObj->execute(['search' => '%' . $search . '%']);
	} else {
		$queryObj = $pdo->query("select * from posts");
	}


	$posts = $queryObj->fetchAll(PDO::FETCH_ASSOC);
	return $posts;
}

function getOnePost($postId)
{
	global $pdo;

	$queryObj = $pdo->prepare("select * from posts where id = ?");
	$queryObj->execute([$postId]);



	$post = $queryObj->fetch(PDO::FETCH_ASSOC);
	return $post;
}

function editPost($id, $title, $content, $category_id, $status = 'draft', $image = 'no-img.jpg')
{

	global $pdo;
	$queryObj = $pdo->prepare("update posts SET title=:ptt, content=:pcn, category_id=:pci, status=:pst, image=:pim where id=:pid");

	try {
		$queryObj->execute([
			'pid' => $id,
			'ptt' => $title,
			'pcn' => $content,
			'pci' => $category_id,
			'pst' => $status,
			'pim' => $image,
		]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	return true;
}

function deletePost($postId)
{
	global $pdo;

	$queryObj = $pdo->prepare("delete from posts where id = ?");
	$result = $queryObj->execute([$postId]);

	return $result;
}

function ratePost($user_id, $post_id, $rating)
{
	global $pdo;
	$queryObj = $pdo->prepare("select * from user_post where uid=:uid and pid=:pid");

	try {
		$queryObj->execute([
			'uid' => $user_id,
			'pid' => $post_id,
		]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}

	$result = $queryObj->fetch(PDO::FETCH_ASSOC);

	if ($result) {
		$queryObj = $pdo->prepare("update user_post SET rating=:rating where uid=:uid and pid=:pid");
	} else {
		$queryObj = $pdo->prepare("insert into user_post(uid, pid, rating) values(:uid, :pid, :rating)");
	}

	try {
		$queryObj->execute([
			'uid' => $user_id,
			'pid' => $post_id,
			'rating' => $rating,
		]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	return true;
}


function getRating($post_id)
{
	global $pdo;
	$queryObj = $pdo->prepare("select avg(rating) as rating from user_post where pid=:pid");

	try {
		$queryObj->execute([
			'pid' => $post_id,
		]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	$result = $queryObj->fetch(PDO::FETCH_ASSOC);
	return $result;
}

function getPostTags($post_id) {
    global $pdo;
    $query = $pdo->prepare("SELECT tags.id, tag_name FROM tags JOIN post_tags ON tags.id = post_tags.tag_id WHERE post_tags.post_id = :post_id");
    $query->execute(['post_id' => $post_id]);
    return $query->fetchAll();
}

function getPostsByTagId($tag_id) {
    global $pdo;
    $query = $pdo->prepare("SELECT * FROM posts JOIN post_tags ON posts.id = post_tags.post_id WHERE post_tags.tag_id = :tag_id");
    $query->execute(['tag_id' => $tag_id]);
    return $query->fetchAll();
}	

function editAvatar($id, $avatar_name)
{
	global $pdo;
	$queryObj = $pdo->prepare("update users SET avatar=:avatar where id=:id");

	try {
		$queryObj->execute([
			'id' => $id,
			'avatar' => $avatar_name,
		]);
	} catch (PDOException $ex) {
		echo $ex->getMessage();
		return false;
	}
	return true;
}

function deleteAvatar($id){
    global $pdo;
    $queryObj = $pdo->prepare("UPDATE users SET avatar = 'no-avatar.jpg' WHERE id = :id");
    try{
        $queryObj->execute(['id' => $id]);
    }catch(PDOException $ex){
        echo $ex->getMessage();
        return false;
    }
    return true;
}