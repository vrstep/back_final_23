<?php

	session_start();
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		unset($_SESSION);
		session_destroy();

		header("Location: loginForm.php");
	}

?>