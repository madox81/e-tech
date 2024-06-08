<?php
// Include the database configuration file
require_once 'includes/database.php';

try {
    // Query to select featured products
    $sql = 'SELECT * FROM products WHERE is_featured = 1';
    // Prepare and execute the SQL query
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    // Fetch all rows as an associative array
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    // Log the error and display a generic message to the user
    error_log('Database Error: ' . $e->getMessage(), 0);
    echo 'An error occurred while fetching featured products. Please try again later.';
}

include_once 'partials/header.php';
include_once 'partials/navbar.php';
include_once 'partials/cartview.php';
?>

<!-- Jumbotron -->
<div class="row mt-5">
    <div class="col-12 col-md-7 text-center text-md-left d-flex flex-column justify-content-center align-items-center">
        <h1 class="display-3 text-white drop-shadow">High Tech & Accessories</h1>
        <p class="lead">Innovate your life.</p>
        <h2 class="drop-shadow">Our Message</h2>
        <p class="fs-4 fst-italic drop-shadow">At <span class="fw-bold">e-Tech</span>, we're not just about technology; we're about transforming the way you experience it. With a passion for innovation and a commitment to excellence, we're here to make your digital journey seamless, exciting, and simply extraordinary.</p>
    </div>
    <div class="col-12 col-md-5">
        <img src="./public/images/banners/laptop.png" alt="Dans Meat Yogurt" class="img-fluid">
    </div>
</div>

<div class="row mt-5">
    <div class="col-12 col-md-12 p-5">
        <section class="text-white">
            <h1 class="display-3 text-white drop-shadow text-center">Your Window To Digital Life</h1>
        </section>
    </div>
</div>

<!-- Cards -->
<div class="row mb-5">
    <h2 class="text-white drop-shadow my-4 text-center ">Featured Products</h2>
    <hr class="text-white"> 
    <?php foreach ($products as $product): ?>
    <div class="col-md-4">
        <div class="card mb-4 shadow-lg drop-shadow rounded-5 d-flex justify-content-center align-items-center overflow-hidden">
            <img src="<?= $product['image']; ?>" class="card-img-top" alt="<?= $product['name']; ?>" style="width: 200px; height: 200px;">
            <div class="card-body">
                <h5 class="card-title text-nowrap"><?= $product['name']; ?></h5>
                <p class="card-text"><?= $product['desc']; ?></p>
                <p class="card-text fst-italic fw-bold text-danger">Price: $<?= $product['price']; ?></p>
                <form method="post" action="">
                    <input type="hidden" name="product" value="<?= $product['name']; ?>">
                    <input type="hidden" name="price" value="<?= $product['price']; ?>">
                    <input type="hidden" name="pid" value="<?= $product['id']; ?>">
                    <input type="hidden" name="img" value="<?= $product['image']; ?>">
                    <input type="number" name="quantity" min="1" max="3" value="1" class="form-control mb-2" placeholder="Quantity" required>
                    <button type="submit" class="btn btn-primary btn-block add_to_cart">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include_once 'partials/footer.php'; ?>