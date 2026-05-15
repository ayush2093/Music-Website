<?php
// Start session
session_start();

// Include database connection
include 'includes/db_connect.php';

echo "<h2>Session Test</h2>";

// Display all session data
echo "<h3>Current Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Check specific user_id
echo "<h3>User ID Check:</h3>";
if (isset($_SESSION['user_id'])) {
    echo "user_id in session: " . $_SESSION['user_id'] . " (type: " . gettype($_SESSION['user_id']) . ")<br>";
    
    // Cast to integer and check
    $user_id = (int)$_SESSION['user_id'];
    echo "user_id after casting to int: " . $user_id . " (type: " . gettype($user_id) . ")<br>";
} else {
    echo "No user_id in session<br>";
}

// Test database connection
echo "<h3>Database Connection Test:</h3>";
try {
    $test_query = mysqli_query($conn, "SELECT 1");
    if ($test_query) {
        echo "Database connection working<br>";
    } else {
        echo "Database connection failed: " . mysqli_error($conn) . "<br>";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "<br>";
}

// Insert test record with user_id
echo "<h3>Test Insert:</h3>";
if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] > 0) {
    $user_id = (int)$_SESSION['user_id'];
    $test_title = "Test Song " . time();
    
    // Use prepared statement
    try {
        $stmt = mysqli_prepare($conn, "INSERT INTO songs (title, artist, album, duration, cover, audio, genre, created_at, user_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
                
        if ($stmt) {
            $artist = "Test Artist";
            $album = "Test Album";
            $duration = 180;
            $cover = "images/covers/test.jpg";
            $audio = "Music/test/test.mp3";
            $genre = "Test";
            
            mysqli_stmt_bind_param($stmt, "sssisssi", $test_title, $artist, $album, $duration, $cover, $audio, $genre, $user_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "Test record inserted successfully with user_id: $user_id<br>";
                $last_id = mysqli_insert_id($conn);
                echo "Last inserted ID: $last_id<br>";
                
                // Verify the inserted record
                $verify_query = mysqli_query($conn, "SELECT * FROM songs WHERE id = $last_id");
                $verify_row = mysqli_fetch_assoc($verify_query);
                echo "<pre>";
                print_r($verify_row);
                echo "</pre>";
                
                // Clean up test data
                mysqli_query($conn, "DELETE FROM songs WHERE id = $last_id");
                echo "Test record cleaned up<br>";
            } else {
                echo "Failed to execute statement: " . mysqli_stmt_error($stmt) . "<br>";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo "Failed to prepare statement: " . mysqli_error($conn) . "<br>";
        }
    } catch (Exception $e) {
        echo "Exception during test insert: " . $e->getMessage() . "<br>";
    }
} else {
    echo "No valid user_id in session for test insert<br>";
}

// Check table structure
echo "<h3>Table Structure:</h3>";
$result = mysqli_query($conn, "DESCRIBE songs");
echo "<table border='1'>";
echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    foreach ($row as $key => $value) {
        echo "<td>" . ($value === null ? "NULL" : htmlspecialchars($value)) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

echo "<p><a href='index.php'>Back to Home</a></p>";
?> 