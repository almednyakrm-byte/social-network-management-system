<?php
// Start the session to handle user authentication
session_start();

// Import the database connection file
require_once 'db.php';

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // If the user is logged in, return a JSON response with their details
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $response = array('status' => 'logged_in', 'user_id' => $user_id, 'username' => $username);
    echo json_encode($response);
    exit;
}

// Check if the user is trying to register
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    // Check if the form data is valid
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        // Sanitize the input data
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

        // Check if the username and email are unique
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$username, $email]);
        $result = $stmt->fetch();
        if ($result) {
            // If the username or email is already taken, return an error response
            $response = array('status' => 'error', 'message' => 'Username or email already taken');
            echo json_encode($response);
            exit;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$username, $email, $hashed_password]);

        // Return a success response
        $response = array('status' => 'success', 'message' => 'User created successfully');
        echo json_encode($response);
        exit;
    } else {
        // If the form data is invalid, return an error response
        $response = array('status' => 'error', 'message' => 'Invalid form data');
        echo json_encode($response);
        exit;
    }
}

// Check if the user is trying to login
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    // Check if the form data is valid
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Sanitize the input data
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

        // Check if the username and password are valid
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$username]);
        $result = $stmt->fetch();
        if ($result) {
            // Hash the input password and verify it with the stored password
            if (password_verify($password, $result['password'])) {
                // If the password is correct, log the user in
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['username'] = $username;
                $response = array('status' => 'logged_in', 'user_id' => $result['id'], 'username' => $username);
                echo json_encode($response);
                exit;
            } else {
                // If the password is incorrect, return an error response
                $response = array('status' => 'error', 'message' => 'Invalid username or password');
                echo json_encode($response);
                exit;
            }
        } else {
            // If the username is invalid, return an error response
            $response = array('status' => 'error', 'message' => 'Invalid username or password');
            echo json_encode($response);
            exit;
        }
    } else {
        // If the form data is invalid, return an error response
        $response = array('status' => 'error', 'message' => 'Invalid form data');
        echo json_encode($response);
        exit;
    }
}

// Check if the user is trying to logout
if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    // Destroy the session to log the user out
    session_destroy();
    $response = array('status' => 'logged_out');
    echo json_encode($response);
    exit;
}


This PHP file handles user registration, login, logout, and checking the current session user status. It uses prepared statements to prevent SQL injection and hashes passwords using `password_hash()` and verifies them using `password_verify()`. It also checks input fields securely using `filter_var()` and returns JSON responses for AJAX calls.