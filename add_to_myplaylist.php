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
        // Check if song is already in myplaylist
        $stmt = $conn->prepare("SELECT id FROM myplaylist WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Song already in playlist
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Song already in My Playlist', 'action' => 'none']);
            $stmt->close();
            $conn->close();
            exit;
        }
        
        // Add song to myplaylist
        $stmt = $conn->prepare("INSERT INTO myplaylist (user_id, song_id, added_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $user_id, $song_id);
        
        if ($stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Song added to My Playlist', 'action' => 'added']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Failed to add song to My Playlist']);
        }
        $stmt->close();
    } else if ($action === 'remove') {
        // Remove song from myplaylist
        $stmt = $conn->prepare("DELETE FROM myplaylist WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        
        if ($stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Song removed from My Playlist', 'action' => 'removed']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Failed to remove song from My Playlist']);
        }
        $stmt->close();
    } else if ($action === 'check') {
        // Check if song is in myplaylist
        $stmt = $conn->prepare("SELECT id FROM myplaylist WHERE user_id = ? AND song_id = ?");
        $stmt->bind_param("ii", $user_id, $song_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $isInPlaylist = $result->num_rows > 0;
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'inPlaylist' => $isInPlaylist]);
        $stmt->close();
    } else if ($action === 'list') {
        // Get all songs in user's myplaylist
        $stmt = $conn->prepare("
            SELECT s.id, s.title, s.artist, s.album, s.duration, s.cover, s.audio, s.genre, m.added_at 
            FROM myplaylist m
            JOIN songs s ON m.song_id = s.id
            WHERE m.user_id = ?
            ORDER BY m.added_at DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $songs = [];
        while ($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'songs' => $songs]);
        $stmt->close();
    } else {
        // Invalid action
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
    $conn->close();
} else {
    // Invalid request
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?> 