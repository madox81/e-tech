<?php

// Start the session if not already started
session_start();

// Include the database configuration file
require_once '../includes/database.php';
// Include helper functions
require_once '../includes/helpers.php';

$errors = []; // To store validation errors


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Get and sanitize input
	$fname = sanitize($_POST['fname'] ?? '');
	$lname = sanitize($_POST['lname'] ?? '');
	$email = sanitize($_POST['email'] ?? '');
    $password = sanitize($_POST['password'] ?? '');
    $confirm = sanitize($_POST['confirm'] ?? '');


	// Perform validation for each field
    if (empty($fname)) {
        $errors[] = "First Name is required";
    }

    if (empty($lname)) {
        $errors[] = "Last Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        $errors[] = "Password must be at least 8 characters long and contain at least one uppercase letter and one digit";
    }

    if ($password !== $confirm) {
        $errors[] = "Password and Confirm Password do not match";
    }

    // If no validation errors, proceed with signup process
    if (empty($errors)) {
        try {

            // Check for email duplicate
            $sql = 'SELECT id FROM users WHERE email = :email';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' =>  $email]);
            $existing_user = $stmt->fetch();

            if($existing_user){
                $errors[] = 'Email already exists.';
                header('Location: ../index.php?page=signup');
                $_SESSION['signup_errors'] = $errors;
                exit;
            }


            // Prepare SQL statement to insert user data into the database
            $sql = "INSERT INTO users (fname, lname, email, password) VALUES (:fname, :lname, :email, :password)";
            $stmt = $pdo->prepare($sql);

            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Bind parameters and execute the statement
            $stmt->execute([
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email,
                'password' => $hashed_password
            ]);

            // Redirect the user to the login page upon successful signup
            header("Location: ../index.php?page=signin");
            exit;
        } catch(PDOException $e) {
            // Log the error and display a generic message to the user
            error_log('Database Error: ' . $e->getMessage(), 0);
            $errors[] = "An error occurred while processing your request. Please try again later.";
        }
    } 
}

// If errors array is not empty
if(!empty($errors)){
    $_SESSION['signup_errors'] = $errors;
    header("Location: ../index.php?page=signup");
    exit;
}