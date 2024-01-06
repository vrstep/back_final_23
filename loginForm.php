<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login form page</title>
	<?php require_once 'common/inhead.php'; ?>
</head>
<body>

	<?php session_start(); ?>

	<?php
	$hasErrors = false; 
	if(isset($_SESSION['status']) && $_SESSION['status'] == 'error')
		$hasErrors = true;
	?>

	<div class="centerForm">
		<?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
			<div class="success">
				<?= $_SESSION['message'] ?>
			</div>
		<?php endif; ?>

		<?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'mainError'): ?>
			<div class="mainError">
				<?= $_SESSION['message'] ?>
				<i class="fa-regular fa-circle-xmark" onclick="this.parentElement.remove()"></i>
			</div>
		<?php endif; ?>

		<form action="login.php" method="POST">
			<div class="field-group">
				<label for="email">Email</label>
				<input type="email" name="email" id="email">
				<?php if($hasErrors && isset($_SESSION['errors']['email'])): ?>
					<p class="inputError"><?= $_SESSION['errors']['email'] ?></p>
				<?php endif; ?>
			</div>
			<div class="field-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password">
				<?php if($hasErrors && isset($_SESSION['errors']['password'])): ?>
					<p class="inputError"><?= $_SESSION['errors']['password'] ?></p>
				<?php endif; ?>
			</div>
			<div class="field-group">
				<input type="checkbox" name="remember" value="yes"> Remember me
			</div>
			<button type="submit">Login</button>
		</form>
		<span class="mt-3">Not registered? <a href="registerForm.php">Register page</a></span>
	</div>

	<?php

	unset($_SESSION['status']);
	unset($_SESSION['errors']);
	unset($_SESSION['message']);

	?>
</body>
</html>