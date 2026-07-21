<?php

require_once 'db.php';

// Get the user data from the request body
$userData = json_decode(file_get_contents('php://input'), true);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Prepare the SQL query to select all users
        $stmt = $pdo->prepare('SELECT * FROM users');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return the users in JSON format
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($users);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate the user data
        if (!isset($userData['name']) || !isset($userData['email']) || !isset($userData['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            exit;
        }
        
        // Sanitize the user data
        $name = filter_var($userData['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($userData['email'], FILTER_SANITIZE_EMAIL);
        $password = password_hash($userData['password'], PASSWORD_DEFAULT);
        
        // Prepare the SQL query to insert a new user
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        // Return the newly inserted user in JSON format
        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'User created successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
}

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    try {
        // Validate the user data
        if (!isset($userData['id']) || !isset($userData['name']) || !isset($userData['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            exit;
        }
        
        // Sanitize the user data
        $id = filter_var($userData['id'], FILTER_SANITIZE_NUMBER_INT);
        $name = filter_var($userData['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($userData['email'], FILTER_SANITIZE_EMAIL);
        
        // Prepare the SQL query to update a user
        $stmt = $pdo->prepare('UPDATE users SET name = :name, email = :email WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Return a success message in JSON format
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'User updated successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
}

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        // Validate the user data
        if (!isset($userData['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            exit;
        }
        
        // Sanitize the user data
        $id = filter_var($userData['id'], FILTER_SANITIZE_NUMBER_INT);
        
        // Prepare the SQL query to delete a user
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Return a success message in JSON format
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'User deleted successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
}

?>