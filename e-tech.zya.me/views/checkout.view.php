<?php

$user   = $_SESSION['user'] ?? [];
$cart   = $_SESSION['cart'] ?? [];
$errors = $_SESSION['checkout_errors'] ?? '';

unset($_SESSION['checkout_errors']);

if(empty($user)){
    header("Location: index.php?page=signin");
    exit;
}

if(empty($cart)){
    header("Location: index.php?page=index");
    exit;
}


function cartTotal($cart){
    if(empty($cart)){
        return 0;
    }

    $total = 0;
    foreach($cart as $item){
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

include_once 'partials/header.php';
include_once 'partials/navbar.php';
include_once 'partials/cartview.php';
?>


        <div class="row justify-content-center align-content-center" style="min-height: 75%;">
            <div class="col-lg-4">
                <!-- Shipping Details Form -->
                <h3 class="text-white drop-shadow mb-2">Shipping Details</h3>
                <hr class="text-white">
                <form action="api/checkout.php" method="POST">
                    <?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($errors as $error) : ?>
                                <p class="text-center"><?= $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-2">
                        <input type="text" class="form-control" value = "<?= $user['name']; ?>" name="fullName" required disabled>
                    </div>
                    <div class="mb-2">
                        <input type="email" class="form-control" value = "<?= $user['email']; ?>" name="email" required disabled>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="mobile" required placeholder="Mobile" autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control" name="address" required placeholder="Address"></textarea>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="city" required placeholder="City" autocomplete="off">
                    </div>
                    <p><i class="bi bi-check-circle text-warning"></i><span class="text-white fst-italic"> Payment on delivary</span></p>
                    <button type="submit" class="btn btn-primary w-100">Order</button>
                </form>
            </div>
            <div class="col-lg-5">
                <!-- Cart Summary -->
                <h3 class="text-white drop-shadow mb-2">Cart Summary</h3>
                <hr class="text-white">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-6 fw-bold">Product</div>
                            <div class="col-3 fw-bold">Quantity</div>
                            <div class="col-3 fw-bold">Price</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Cart items will be dynamically generated here -->
                        <?php if(!empty($cart)):?>
                            <?php foreach ($cart as $item):?>
                                <div class="row mb-3">
                                    <div class="col-6 card-"><?= $item['name']; ?></div>
                                    <div class="col-3 text-center"><?= $item['quantity']; ?></div>
                                    <div class="col-3">$<?= $item['price']; ?></div>
                                </div>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-9">
                                <b>Cart Total:</b>
                            </div>
                            <div class="col-3">
                                <b>$<?= cartTotal($cart); ?></b>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    

<?php include_once 'partials/footer.php'; ?>