<?php
// Start session
session_start();

// Include database connection configuration
require_once __DIR__ . '/../includes/db_connect.php';

// Determine if this is an AJAX request
$isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');

// Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST["password"]);
    
    // Validate inputs
    $errors = [];
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // If there are validation errors, return error response
    if (!empty($errors)) {
        $errorMessage = implode(", ", $errors);
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $errorMessage]);
        } else {
            echo "<script>alert('Validation errors: " . $errorMessage . "');</script>";
            echo "<script>window.location.href = 'login.html?error=" . urlencode($errorMessage) . "';</script>";
        }
        exit();
    }
    
    // Check if user exists and verify password using the connection from db_connect.php
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true, 
                    'message' => 'Login successful! Redirecting...', 
                    'redirect' => '../index.php'
                ]);
            } else {
                echo "<script>alert('Login successful! Redirecting...');</script>";
                echo "<script>window.location.href = '../index.php';</script>";
            }
            exit();
        } else {
            // Password is incorrect
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
            } else {
                echo "<script>alert('Invalid password');</script>";
                echo "<script>window.location.href = 'login.html?error=Invalid email or password';</script>";
            }
            exit();
        }
    } else {
        // User does not exist
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        } else {
            echo "<script>alert('Invalid email or password');</script>";
            echo "<script>window.location.href = 'login.html?error=Invalid email or password';</script>";
        }
        exit();
    }
    
    $stmt->close();
    $conn->close();
} else {
    // Redirect if direct access
    header('Location: login.html');
    exit();
}
?>