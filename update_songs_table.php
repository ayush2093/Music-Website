<?php
// Start session
session_start();

// Include database connection
include 'includes/db_connect.php';

// Check if the user_id column exists and modify it
$check_column = query("SHOW COLUMNS FROM songs LIKE 'user_id'");
if (mysqli_num_rows($check_column) > 0) {
    echo "User ID column exists, modifying to ensure it accepts integers properly...<br>";
    
    // Modify the user_id column to INT NOT NULL with a default value
    query("ALTER TABLE songs MODIFY user_id INT NOT NULL DEFAULT 1");
} else {
    echo "User ID column doesn't exist, adding it...<br>";
    
    // Add the user_id column
    query("ALTER TABLE songs ADD user_id INT NOT NULL DEFAULT 1");
}

// Update existing NULL values
query("UPDATE songs SET user_id = 1 WHERE user_id IS NULL");

echo "Table updated successfully!<br>";
echo "<a href='my_songs.php'>Go to My Songs</a>";
?> 