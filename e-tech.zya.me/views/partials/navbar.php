<?php

$user_id = isset($_SESSION['user']) ? $_SESSION['user']['uid'] : '';

?>

<nav class="navbar navbar-expand-lg navbar-transparent navbar-light">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="index.php?page=index"><h1 class="drop-shadow">e-Tech</h1></a>

        <!-- Toggler button -->
        <button class="navbar-toggler" type="button" 
                data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="bi bi-list text-white"></span>
        </button>

        <!-- Navbar items -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item btn btn-outline-light m-1">
                    <a class="nav-link text-white fw-bold" href="index.php?page=index">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>
                <li class="nav-item btn btn-outline-light m-1">
                    <a class="nav-link text-white fw-bold" href="index.php?page=products">
                        <i class="bi bi-shop"></i> Products
                    </a>
                </li>
                <li class="nav-item btn <?= $user_id ? ' btn-outline-warning' : ' btn-outline-light'; ?> m-1">
                    <a class="nav-link <?= $user_id ? 'text-warning' : 'text-white'; ?> fw-bold" 
                        href="<?= $user_id ? 'api/signout.php' : 'index.php?page=signin'; ?>">
                        <i class="bi bi-person"></i><?= $user_id ? ' Sign out' : ' Sign in'; ?>
                    </a>
                </li>
                <li class="nav-item btn btn-outline-light m-1">
                    <a  role="link" id="cart-popover" tabindex="-1" class="nav-link fw-bold text-white position-relative">
                        <span class="bi bi-cart"></span>
                        <span class="badge position-absolute top-0 start-100 translate-middle p-2 bg-danger"></span>
                        Cart
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>