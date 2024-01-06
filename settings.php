<?php
session_start();
require_once 'common/checkAuth.php';
require_once 'common/connect.php';
require_once 'common/alert.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <?php require_once 'common/inhead.php'; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once 'common/nav.php' ?>
    <?php displayAlert(); ?>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="py-3">
                    <h1>Settings</h1>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="security-tab" data-bs-toggle="tab" href="#security" role="tab" aria-controls="security" aria-selected="false">Security</a>
                        </li>
                        <?php if ($user['role'] == 'admin') { ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="manage-tab" data-bs-toggle="tab" href="#manageUsers" role="tab" aria-controls="manage" aria-selected="false">Manage Roles</a>
                            </li>
                        <?php } ?>
                        <?php if ($user['role'] == 'admin' || $user['role'] == 'moderator') { ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="manage-tab" data-bs-toggle="tab" href="#manageCategories" role="tab" aria-controls="manage" aria-selected="false">Manage Categories</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="manage-tab" data-bs-toggle="tab" href="#manageTags" role="tab" aria-controls="manage" aria-selected="false">Manage Tags</a>
                            </li>
                        <?php } ?>
                        <!-- Add more tabs as needed -->
                    </ul>
                </div>
                <!-- Tab panes -->
                <div class="tab-content text-black" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3 class="mb-3">Profile Picture</h3>
                        <div class="card bg-dark text-white p-1">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle overflow-hidden d-inline-block me-3">
                                        <!-- Replace 'path_to_your_image' with the actual path to the user's profile picture -->
                                        <img src="http://localhost/newsblog/images/avatars/<?= $user['avatar'] ?>" alt="Avatar" width="80" height="80">
                                    </div>
                                    <div class="pl-3">
                                        <button class="btn btn-primary mb-2 me-2" id="uploadButton">
                                            <i class="fa fa-camera"></i>
                                        </button>
                                        <button class="btn btn-danger mb-2" id="deleteButton">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
                                            <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;">
                                        </form>
                                        <form action="deleteAvatar.php" method="post" id="deleteForm" style="display: none;">
                                            <input type="hidden" name="userId" value="<?php echo $_SESSION['id']; ?>">
                                        </form>
                                        <p>Must be JPEG, PNG, or GIF and cannot exceed 10MB.</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                        <form action="changePassword.php" method="post" id="changePasswordForm">
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label">Old Password</label>
                                <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="manageUsers" role="tabpanel" aria-labelledby="security-tab">
                        <?php include_once 'manageUsers.php'; ?>
                    </div>

                    <div class="tab-pane fade" id="manageCategories" role="tabpanel" aria-labelledby="security-tab">
                        <?php include_once 'manageCategories.php'; ?>
                    </div>

                    <div class="tab-pane fade" id="manageTags" role="tabpanel" aria-labelledby="security-tab">
                        <?php include_once 'manageTags.php'; ?>
                    </div>
            </div>
        </div>
    </div>
</div>
    <?php require_once 'common/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>