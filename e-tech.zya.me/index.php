<?php

// Start session
session_start();

// Default page
if (empty($_GET) || !isset($_GET['page'])) {
    header("Location: index.php?page=index");
    exit;
}

// Get page
$page = isset($_GET['page']) ? $_GET['page'] : 'index';


// Define the directory for view templates
$viewsDirectory = __DIR__ . '/views/';

// Determine the path to the requested view file
$viewFile = $viewsDirectory . basename($page) . '.view.php';

// Set page title
$pageTitle = $page !== 'index' ? $page : 'home';



// Check if the view file exists
if (file_exists($viewFile)) {
    // Include the view file
    require_once $viewFile;
} else {
    // If the requested view file doesn't exist, display the 404 error page
    http_response_code(404);
    include_once $viewsDirectory . '404.view.php';
}