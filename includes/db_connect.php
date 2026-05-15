<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'music';

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8mb4
mysqli_set_charset($conn, "utf8mb4");

// Function to safely escape strings
function escape($str) {
    global $conn;
    return mysqli_real_escape_string($conn, $str);
}

// Function to execute query and return result
function query($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    return $result;
}

// Function to fetch single row
function fetch($sql) {
    $result = query($sql);
    return mysqli_fetch_assoc($result);
}

// Function to fetch all rows
function fetchAll($sql) {
    $result = query($sql);
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Function to get last inserted ID
function lastId() {
    global $conn;
    return mysqli_insert_id($conn);
}

// Function to count rows
function countRows($sql) {
    $result = query($sql);
    return mysqli_num_rows($result);
}

// Format duration from seconds to MM:SS
function formatDuration($seconds) {
    $minutes = floor($seconds / 60);
    $seconds = $seconds % 60;
    return sprintf('%d:%02d', $minutes, $seconds);
}
?> 
 