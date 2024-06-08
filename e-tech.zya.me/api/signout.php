<?php

session_start();

// Check if user is logged in
if(isset($_SESSION['user'])){
	// Unset user ID from session
	unset($_SESSION['user']);
	// Redirect to the signin page
	header('Location: ../index.php?page=signin');
	exit;
}