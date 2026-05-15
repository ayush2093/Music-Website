<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "music";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data and sanitize
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
$subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '';
$message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

// Validate data
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    // Redirect back with error
    header("Location: contact.php?error=1");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Redirect back with error for invalid email
    header("Location: contact.php?error=2");
    exit();
}

// Insert message into database
$stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    // Success - redirect back with success message
    header("Location: contact.php?success=1");
} else {
    // Error - redirect back with database error
    header("Location: contact.php?error=3");
}

$stmt->close();
$conn->close();
?> 