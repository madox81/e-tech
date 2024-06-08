<?php
// Include the database configuration file
require_once 'includes/database.php';

try {
    // Query to select featured products
    $sql = 'SELECT * FROM products';
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

<!-- Cards -->
<div class="row my-5 justify-content-center ">
    <h2 class="text-white text-center drop-shadow mb-4">Our Products</h2>
    <hr class="text-white"> 
    <?php foreach ($products as $product): ?>
    <div class="col-md-4">
        <div class="card mb-4 shadow-lg drop-shadow rounded-5 d-flex justify-content-center align-items-center flex-column overflow-hidden">
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