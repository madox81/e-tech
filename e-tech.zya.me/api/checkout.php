<?php

session_start();

$cart = $_SESSION['cart'] ?? '';
$user = $_SESSION['user'] ?? '';

if(empty($user)){
	headre('Location: ../index.php?page=signin');
	exit;
}

if(empty($cart)){
	headre('Location: ../index.php?page=index');
	exit;
}

// Include the database configuration file
require_once '../includes/database.php';
// Include helper functions
require_once '../includes/helpers.php';

// Initilize validation errors array
$errors = [];

// Get and sanitize form data
$city = sanitize($_POST['city']) ?? '';
$mobile = sanitize($_POST['mobile']) ?? '';
$address = sanitize($_POST['address']) ?? '';

// Perform validation for each field
if(empty($city)){
	$errors[] = 'City is required';
}

if(empty($mobile)){
	$errors[] = 'Mobile is required';
}

if(empty($address)){
	$errors[] = 'Address is required';
}

// If no validation errors, proceed with signup process
if(empty($errors)){
	try{

		// Start transaction
        $pdo->beginTransaction();

		// Prepare SQL statement to insert user data into the database
		$sql = 'INSERT INTO orders (user_id, address, city, mobile) 
				VALUES	(:user_id, :address, :city, :mobile)';
		
		$stmt = $pdo->prepare($sql);

		// Bind parameters and execute the statement
		$stmt->execute([
			'user_id' => $user['uid'],
			'address' => $address,
			'city'    => $city,
			'mobile'  => $mobile	
		]);

		$order_id = $pdo->lastInsertId();

		if(!empty($order_id)){
			$sql = 'INSERT INTO orders_detail (order_id, product_id, product_qty, product_price) 
					VALUES	(:order_id, :product, :qty, :price)';
			
			$stmt = $pdo->prepare($sql);
			foreach($cart as $item){
				$stmt->execute([
					'order_id'  =>  $order_id,
					'product'    =>  $item['pid'],
					'qty'    	 =>	 $item['quantity'],
					'price'      =>  $item['price']
				]);
			}
		}

		// Commit transaction
        $pdo->commit();


		unset($_SESSION['cart']);
		header('Location: ../index.php?page=completed');
		exit;

	}catch(PDOException	$e){

		// Rollback transaction on error
        $pdo->rollBack();

		// Log the error and display a generic message to the user
        error_log('Database Error: ' . $e->getMessage(), 0);
        $errors[] = "An error occurred while processing your request. Please try again later.";
	}
}


if(!empty($errors)){
	$_SESSION['checkout_errors'] = $errors;
	header('Location: ../index.php?page=checkout');
	exit;
}