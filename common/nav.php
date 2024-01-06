<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/newsblog">News Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="indexAdmin.php">Admin Panel</a></li>                 -->
                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="http://localhost/newsblog/images/avatars/<?= $user['avatar'] ?>" alt="Avatar" class="avatar">
                    </a>
                    <ul class="dropdown-menu overflow-hidden" aria-labelledby="navbarDropdown">
                        <li class="dropdown-item text-primary">Logged in as <?= $user['name'] ?></li>
                        <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                        <li>
                            <form action="logout.php" method="post">
                                <button class="dropdown-item" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>