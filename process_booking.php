<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once 'includes/db_connect.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $tickets = intval($_POST['tickets']);
    $price = floatval($_POST['price']);
    $total_price = $tickets * $price;
    
    // Get user ID if logged in
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    // Use logged-in user data if available
    if ($user_id && isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
        $name = mysqli_real_escape_string($conn, $_SESSION['user_name']);
        $email = mysqli_real_escape_string($conn, $_SESSION['user_email']);
        // Use default phone value if not in form submission
        $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '123-456-7890';
    } else {
        // For non-logged in users, use form data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    }
    
    // Check if event exists and has enough tickets
    $event_query = "SELECT available_tickets FROM events WHERE id = $event_id";
    $event_result = mysqli_query($conn, $event_query);
    
    if ($event_result && mysqli_num_rows($event_result) > 0) {
        $event = mysqli_fetch_assoc($event_result);
        
        if ($event['available_tickets'] >= $tickets) {
            // Insert booking into database
            $booking_query = "INSERT INTO events_booking (event_id, user_id, name, email, phone, tickets, total_price, booking_date, status) 
                            VALUES ($event_id, " . ($user_id ? $user_id : "NULL") . ", '$name', '$email', '$phone', $tickets, $total_price, NOW(), 'confirmed')";
            
            if (mysqli_query($conn, $booking_query)) {
                // Update available tickets
                $update_query = "UPDATE events SET available_tickets = available_tickets - $tickets WHERE id = $event_id";
                mysqli_query($conn, $update_query);
                
                // Set success session variables
                $_SESSION['booking_success'] = true;
                $_SESSION['booking_details'] = [
                    'name' => $name,
                    'email' => $email,
                    'tickets' => $tickets,
                    'total_price' => $total_price
                ];
                
                // Redirect to success page
                header('Location: booking_success.php');
                exit();
            } else {
                $_SESSION['booking_error'] = "Error processing your booking. Please try again.";
                header('Location: events.php');
                exit();
            }
        } else {
            $_SESSION['booking_error'] = "Not enough tickets available for this event.";
            header('Location: events.php');
            exit();
        }
    } else {
        $_SESSION['booking_error'] = "Event not found.";
        header('Location: events.php');
        exit();
    }
} else {
    // If not POST request, redirect to events page
    header('Location: events.php');
    exit();
}
?> 