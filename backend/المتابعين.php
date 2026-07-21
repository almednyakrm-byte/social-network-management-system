<?php
require_once 'db.php';

// Get the input data from the request body
$input = json_decode(file_get_contents('php://input'), true);

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    http_response_code(401);
    echo json_encode(array('error' => 'Unauthorized'));
    exit;
}

// Check if the user is an admin
if (isset($input['action']) && in_array($input['action'], array('PUT', 'DELETE'))) {
    if ($_SESSION['role'] != 'admin') {
        http_response_code(403);
        echo json_encode(array('error' => 'Forbidden'));
        exit;
    }
}

// Handle GET request
if (isset($input['action']) && $input['action'] == 'GET') {
    try {
        // Prepare the SQL query
        $stmt = $pdo->prepare('SELECT * FROM متابعين');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return the result as JSON
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array('error' => 'Internal Server Error'));
    }
}

// Handle POST request
if (isset($input['action']) && $input['action'] == 'POST') {
    try {
        // Validate the input data
        if (!isset($input['name']) || !isset($input['email'])) {
            http_response_code(400);
            echo json_encode(array('error' => 'Bad Request'));
            exit;
        }
        
        // Sanitize the input data
        $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
        
        // Prepare the SQL query
        $stmt = $pdo->prepare('INSERT INTO متابعين (name, email) VALUES (:name, :email)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Return the result as JSON
        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode(array('message' => 'Followers created successfully'));
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array('error' => 'Internal Server Error'));
    }
}

// Handle PUT request
if (isset($input['action']) && $input['action'] == 'PUT') {
    try {
        // Validate the input data
        if (!isset($input['id']) || !isset($input['name']) || !isset($input['email'])) {
            http_response_code(400);
            echo json_encode(array('error' => 'Bad Request'));
            exit;
        }
        
        // Sanitize the input data
        $id = filter_var($input['id'], FILTER_SANITIZE_NUMBER_INT);
        $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
        
        // Prepare the SQL query
        $stmt = $pdo->prepare('UPDATE متابعين SET name = :name, email = :email WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Return the result as JSON
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(array('message' => 'Followers updated successfully'));
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array('error' => 'Internal Server Error'));
    }
}

// Handle DELETE request
if (isset($input['action']) && $input['action'] == 'DELETE') {
    try {
        // Validate the input data
        if (!isset($input['id'])) {
            http_response_code(400);
            echo json_encode(array('error' => 'Bad Request'));
            exit;
        }
        
        // Sanitize the input data
        $id = filter_var($input['id'], FILTER_SANITIZE_NUMBER_INT);
        
        // Prepare the SQL query
        $stmt = $pdo->prepare('DELETE FROM متابعين WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Return the result as JSON
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(array('message' => 'Followers deleted successfully'));
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array('error' => 'Internal Server Error'));
    }
}
?>