<?php

$errors = $_SESSION['login_errors'] ?? '';
unset($_SESSION['login_errors']);

include_once 'partials/header.php';
include_once 'partials/navbar.php';
include_once 'partials/cartview.php';
?>

<div class="row f-flex justify-content-center align-content-center" style="min-height: 75%;">
    <div class="col-sm-12 col-md-9 col-lg-4 p-2">
        <h2 class="text-white drop-shadow mb-2">Sign in</h2>
        <hr class="text-white">
        <form action="api/signin.php" method="POST" id="signinForm">
            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error) : ?>
                        <p class="text-center"><?= $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="form-group mb-2">
                <input class="form-control w-100 border border-0"  
                name="email" type="email" placeholder="Email" required autocomplete="off">
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control border border-0 w-100" 
                name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn btn-primary w-100 fs-5">Submit</button>
            <p class="mt-3 text-white">Don't have an account?  
                <a class="text-warning fw-bolder" id="signup" href="index.php?page=signup">Sign up</a>
            </p>
        </form>
    </div>
</div>



<?php include_once 'partials/footer.php'; ?>