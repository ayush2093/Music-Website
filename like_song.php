<?php
// Start session to get user information
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Return error if not logged in
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Check if request is POST and has song_id
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['song_id'])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "music";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    // Get data
    $user_id = $_SESSION['user_id'];
    $song_id = $_POST['song_id'];
    $action = isset($_POST['action']) ? $_POST['action'] : 'add'; // Default to add
    
    if ($action === 'add') {
        // Check if like already exists
        $stmt = $conn->prepare("SELECT id FROM liked_songs WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Like already exists
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Song already liked', 'action' => 'none']);
            $stmt->close();
            $conn->close();
            exit;
        }
        
        // Insert new like
        $stmt = $conn->prepare("INSERT INTO liked_songs (user_id, song_id, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $user_id, $song_id);
        
        if ($stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Song liked successfully', 'action' => 'added']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Failed to like song']);
        }
        $stmt->close();
    } else if ($action === 'remove') {
        // Remove like
        $stmt = $conn->prepare("DELETE FROM liked_songs WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        
        if ($stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Song unliked successfully', 'action' => 'removed']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Failed to unlike song']);
        }
        $stmt->close();
    } else {
        // Check if song is liked
        $stmt = $conn->prepare("SELECT id FROM liked_songs WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $isLiked = $result->num_rows > 0;
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'liked' => $isLiked]);
        $stmt->close();
    }
    
    $conn->close();
} else {
    // Invalid request
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?> 