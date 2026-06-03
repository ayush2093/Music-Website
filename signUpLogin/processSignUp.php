<?php
// Start session
session_start();

// Include database connection configuration
require_once __DIR__ . '/../includes/db_connect.php';

// Determine if this is an AJAX request
$isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST["password"]);
    
    // Validate inputs
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    // Server-side password strength validation
    if (empty($password)) {
        $errors[] = "Password is required";
    } else {
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }
        if (!preg_match('/\d/', $password)) {
            $errors[] = "Password must contain at least one number";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = "Password must contain at least one special character";
        }
    }
    
    // If there are validation errors, return early
    if (!empty($errors)) {
        $errorMessage = implode(", ", $errors);
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $errorMessage]);
        } else {
            echo "<script>alert('Registration Error: " . $errorMessage . "');</script>";
            echo "<script>window.location.href = 'signup.html?error=" . urlencode($errorMessage) . "';</script>";
        }
        exit();
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $errors[] = "Email already exists. Please use a different email or login.";
        $errorMessage = implode(", ", $errors);
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $errorMessage]);
        } else {
            echo "<script>alert('Registration Error: " . $errorMessage . "');</script>";
            echo "<script>window.location.href = 'signup.html?error=" . urlencode($errorMessage) . "';</script>";
        }
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user data into database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true, 
                'message' => 'Registration successful! Redirecting to login...', 
                'redirect' => 'login.html?signup=success'
            ]);
        } else {
            echo "<script>alert('Registration successful! Redirecting to login page...');</script>";
            echo "<script>window.location.href = 'login.html?signup=success';</script>";
        }
    } else {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $conn->error]);
        } else {
            echo "<script>alert('Registration failed: " . $conn->error . "');</script>";
            echo "<script>window.location.href = 'signup.html?error=Registration failed';</script>";
        }
    }
    
    $stmt->close();
    $conn->close();
    exit();
} else {
    // Redirect on direct access
    header('Location: signup.html');
    exit();
}
?>