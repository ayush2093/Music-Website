<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once 'includes/db_connect.php';

// Check if booking_id is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['cancel_error'] = "No booking ID provided.";
    header('Location: mybookings.php');
    exit();
}

// Get booking ID
$booking_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get user ID if logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_email = isset($_GET['email']) ? mysqli_real_escape_string($conn, $_GET['email']) : '';

// Prepare query to fetch the booking details
if ($user_id) {
    // For logged-in users, check user_id
    $booking_query = "SELECT b.*, e.title, e.id as event_id FROM events_booking b 
                      JOIN events e ON b.event_id = e.id 
                      WHERE b.id = $booking_id AND b.user_id = $user_id";
} elseif (!empty($user_email)) {
    // For guests, check email
    $booking_query = "SELECT b.*, e.title, e.id as event_id FROM events_booking b 
                      JOIN events e ON b.event_id = e.id 
                      WHERE b.id = $booking_id AND b.email = '$user_email'";
} else {
    $_SESSION['cancel_error'] = "Authentication required to cancel booking.";
    header('Location: mybookings.php');
    exit();
}

// Execute query
$booking_result = mysqli_query($conn, $booking_query);

// Check if booking exists and belongs to the user
if (!$booking_result || mysqli_num_rows($booking_result) == 0) {
    $_SESSION['cancel_error'] = "Booking not found or you don't have permission to cancel it.";
    header('Location: mybookings.php');
    exit();
}

// Get booking details
$booking = mysqli_fetch_assoc($booking_result);
$event_title = $booking['title'];
$ticket_count = $booking['tickets'];
$event_id = $booking['event_id'];

// Delete the booking from the database
$delete_query = "DELETE FROM events_booking WHERE id = $booking_id";
$delete_result = mysqli_query($conn, $delete_query);

if ($delete_result) {
    // Update available tickets in events table
    $update_tickets_query = "UPDATE events SET available_tickets = available_tickets + $ticket_count WHERE id = $event_id";
    mysqli_query($conn, $update_tickets_query);
    
    // Set success message
    $_SESSION['cancel_success'] = "Booking for '$event_title' has been deleted successfully.";
} else {
    // Set error message
    $_SESSION['cancel_error'] = "Failed to delete booking. Please try again.";
}

// Redirect back to mybookings page
if (!empty($user_email) && empty($user_id)) {
    header('Location: mybookings.php?email=' . urlencode($user_email));
} else {
    header('Location: mybookings.php');
}
exit();
?> 