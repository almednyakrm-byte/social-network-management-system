<?php

require_once 'db.php';

// Get user role and id from session
$userRole = $_SESSION['userRole'];
$userID = $_SESSION['userID'];

// Get input data from JSON or POST
$inputData = json_decode(file_get_contents('php://input'), true);
if (empty($inputData)) {
    $inputData = $_POST;
}

// Validate and sanitize input data
if (empty($inputData)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input data']);
    exit;
}

// Define table name and columns
$tableName = 'المحادثات';
$columns = ['id', 'title', 'content', 'created_at', 'updated_at'];

// GET all conversations
if (isset($inputData['action']) && $inputData['action'] == 'get_all') {
    try {
        // Check user role for admin-only access
        if ($userRole !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }

        // Prepare and execute query
        $stmt = $pdo->prepare("SELECT * FROM $tableName");
        $stmt->execute();
        $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output conversations
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($conversations);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

// GET conversation by ID
elseif (isset($inputData['action']) && $inputData['action'] == 'get_by_id') {
    try {
        // Check user role for admin-only access
        if ($userRole !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }

        // Validate and sanitize ID
        if (!isset($inputData['id']) || !is_numeric($inputData['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid ID']);
            exit;
        }

        // Prepare and execute query
        $stmt = $pdo->prepare("SELECT * FROM $tableName WHERE id = :id");
        $stmt->bindParam(':id', $inputData['id']);
        $stmt->execute();
        $conversation = $stmt->fetch(PDO::FETCH_ASSOC);

        // Output conversation
        if ($conversation) {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($conversation);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Conversation not found']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

// POST new conversation
elseif (isset($inputData['action']) && $inputData['action'] == 'create') {
    try {
        // Validate and sanitize input data
        if (!isset($inputData['title']) || !isset($inputData['content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input data']);
            exit;
        }

        // Prepare and execute query
        $stmt = $pdo->prepare("INSERT INTO $tableName (title, content, created_at, updated_at) VALUES (:title, :content, NOW(), NOW())");
        $stmt->bindParam(':title', $inputData['title']);
        $stmt->bindParam(':content', $inputData['content']);
        $stmt->execute();

        // Output new conversation ID
        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode(['id' => $pdo->lastInsertId()]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

// PUT update conversation
elseif (isset($inputData['action']) && $inputData['action'] == 'update') {
    try {
        // Check user role for admin-only access
        if ($userRole !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }

        // Validate and sanitize ID and input data
        if (!isset($inputData['id']) || !is_numeric($inputData['id']) || !isset($inputData['title']) || !isset($inputData['content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input data']);
            exit;
        }

        // Prepare and execute query
        $stmt = $pdo->prepare("UPDATE $tableName SET title = :title, content = :content, updated_at = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $inputData['id']);
        $stmt->bindParam(':title', $inputData['title']);
        $stmt->bindParam(':content', $inputData['content']);
        $stmt->execute();

        // Output success message
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Conversation updated successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

// DELETE conversation
elseif (isset($inputData['action']) && $inputData['action'] == 'delete') {
    try {
        // Check user role for admin-only access
        if ($userRole !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }

        // Validate and sanitize ID
        if (!isset($inputData['id']) || !is_numeric($inputData['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid ID']);
            exit;
        }

        // Prepare and execute query
        $stmt = $pdo->prepare("DELETE FROM $tableName WHERE id = :id");
        $stmt->bindParam(':id', $inputData['id']);
        $stmt->execute();

        // Output success message
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Conversation deleted successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
    }
}

// Default response
else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}