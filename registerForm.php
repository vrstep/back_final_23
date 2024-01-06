<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register form page</title>
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

		<form action="register.php" method="POST" enctype="multipart/form-data">
			<div class="field-group">
				<label for="name">Name</label>
				<input type="text" name="name" id="name">
				<?php if($hasErrors && isset($_SESSION['errors']['name'])): ?>
					<p class="inputError"><?= $_SESSION['errors']['name'] ?></p>
				<?php endif; ?>
			</div>
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
				<label for="confirm_password">Confirm password</label>
				<input type="password" name="confirm_password" id="confirm_password">
				<?php if($hasErrors && isset($_SESSION['errors']['confirm_password'])): ?>
					<p class="inputError"><?= $_SESSION['errors']['confirm_password'] ?></p>
				<?php endif; ?>
			</div>
			<div class="field-group">
                    <label for="avatar">User Avatar</label>
                    <input type="file" id="avatar" name="avatar" />
                    <?php if($hasErrors && isset($_SESSION['errors']['avatar'])): ?>
						<p class="inputError"><?= $_SESSION['errors']['avatar'] ?></p>
					<?php endif; ?>
            </div>
			<button type="submit">Register</button>
		</form>
	</div>

	<?php

	unset($_SESSION['status']);
	unset($_SESSION['errors']);
	unset($_SESSION['message']);

	?>
</body>
</html>