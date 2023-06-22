<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid ">
        <a class="navbar-brand pl-5" href="dashboard.php"> <img src="./Public/log.jpg" alt="Logo" width="80" height="80"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="user_roles.php">User Roles</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        User Management
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="dashboard.php">Users List</a></li>
                        <li><a class="dropdown-item" href="user_roles.php">Users Roles</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex " method="post" action="logout.php">
                <button type="submit" class="btn btn-warning mb-3">Logout</button>
            </form>
        </div>
    </div>
</nav>