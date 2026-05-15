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

// Get the current user ID
$user_id = $_SESSION['user_id'];

// Query for liked songs with song details
$query = "
    SELECT s.*, ls.created_at as liked_at
    FROM liked_songs ls
    JOIN songs s ON ls.song_id = s.id
    WHERE ls.user_id = ?
    ORDER BY ls.created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$songs = [];
while ($row = $result->fetch_assoc()) {
    $songs[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'artist' => $row['artist'],
        'album' => $row['album'],
        'duration' => $row['duration'],
        'cover' => $row['cover'],
        'audio' => $row['audio'],
        'genre' => $row['genre'],
        'liked_at' => $row['liked_at']
    ];
}

// Return songs as JSON
header('Content-Type: application/json');
echo json_encode(['success' => true, 'songs' => $songs]);

// Close database connection
$stmt->close();
$conn->close();
?> 