<?php
// Start the session if not already started
session_start();

// Get the action parameter from the request or set it to an empty string
$action = $_REQUEST['action'] ?? '';

// Process the action
switch ($action) {
    case 'add':
        addToCart();
        break;
    case 'remove':
        removeItem();
        break;
    case 'clear':
        clearCart();
        break;
    case 'show':
        showCart();
        break;
    default:
        // Handle invalid action
        echo json_encode(['message' => 'Invalid action']);
        break;
}

// Function to add item to cart
function addToCart() {
    // Sanitize input data
    $pid = htmlspecialchars($_POST['pid']);
    $product = htmlspecialchars($_POST['product']);
    $price = htmlspecialchars($_POST['price']);
    $quantity = htmlspecialchars($_POST['quantity']);

    $cartItem = [
        'pid'       => $pid,
        'name'      => $product,
        'price'     => $price,
        'quantity'  => $quantity,
    ];

    // Initialize session cart array if it doesn't exist
    $_SESSION['cart'] = $_SESSION['cart'] ?? [];

    // Check if the session cart array is not empty
    if (!empty($_SESSION['cart'])) {
        $found = false;

        // Check if the cart item already exists in the session cart array
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['pid'] === $cartItem['pid']) {
                // Update item quantity
                $item['quantity'] += $cartItem['quantity'];
                $found = true;
                break;
            }
        }

        // If item not found, add it to the cart
        if (!$found) {
            $_SESSION['cart'][] = $cartItem;
        }
    } else {
        // If the cart is empty, add the item directly
        $_SESSION['cart'][] = $cartItem;
    }

    // Return cart data as JSON response
    echo json_encode($_SESSION['cart']);
}

// Function to remove item from cart
function removeItem() {
    // Sanitize input data
    $pid = htmlspecialchars($_POST['pid']);

    // Loop through the cart to find the item with the specified product ID
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['pid'] === $pid) {
            // Remove the item from the cart if found
            unset($_SESSION['cart'][$index]);
            break; // Stop searching once the item is removed
        }
    }

    // Return the updated cart as JSON response
    echo json_encode($_SESSION['cart']);
}

// Function to clear cart
function clearCart() {
    unset($_SESSION['cart']);
    echo json_encode([]);
}

// Function to show cart
function showCart() {
    $cart = $_SESSION['cart'] ?? [];
    echo json_encode($cart);
}