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
    $email = sanitize($_POST['email'] ?? '');
    $password = sanitize($_POST['password'] ?? '');

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Validate password
        if (empty($password)) {
        $errors[] = "Password is required";
    }

    // If no validation errors, proceed with login
    if (empty($errors)) {
        try {
            // Prepare and execute SQL statement to find user by email
            $stmt = $pdo->prepare("SELECT id, fname, lname, email, password FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // If user with the provided email is found
            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Password matches, user is authenticated
                    // Set session variables for user
                    $_SESSION['user'] = [
                        'uid'  => $user['id'],
                        'name' => $user['fname'] . ' ' . $user['lname'],
                        'email'=> $user['email']
                    ];
                    // Redirect the user to the home page up on successful signin
                    header("Location: ../index.php");
                    exit;
                } else {
                    $errors[] = "Invalid email or password";
                }
            } else {
                $errors[] = "User not found";
            }
        } catch (PDOException $e) {
            // Log the error and display a generic message to the user
            error_log('Database Error: ' . $e->getMessage(), 0);
            $errors[] = "An error occurred while processing your request. Please try again later.";
        }
    }
}

if(!empty($errors)){
    $_SESSION['login_errors'] = $errors;
    header("Location: ../index.php?page=signin");
    exit;
}