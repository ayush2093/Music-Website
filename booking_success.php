<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if there's a successful booking
if (!isset($_SESSION['booking_success']) || !$_SESSION['booking_success']) {
    header('Location: events.php');
    exit();
}

// Get booking details
$booking_details = $_SESSION['booking_details'];

// Clear the session variables
unset($_SESSION['booking_success']);
unset($_SESSION['booking_details']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Music Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
        }
        .success-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .checkmark {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #4CAF50;
            stroke-miterlimit: 10;
            box-shadow: inset 0px 0px 0px #4CAF50;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        }
        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #4CAF50;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }
        @keyframes stroke {
            100% { stroke-dashoffset: 0; }
        }
        @keyframes scale {
            0%, 100% { transform: none; }
            50% { transform: scale3d(1.1, 1.1, 1); }
        }
        @keyframes fill {
            100% { box-shadow: inset 0px 0px 0px 30px #4CAF50; }
        }
    </style>
</head>
<body class="text-white">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto success-card rounded-lg p-8 shadow-lg">
            <div class="text-center mb-8">
                <svg class="checkmark mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
                <h1 class="text-3xl font-bold mt-6">Booking Confirmed!</h1>
                <p class="text-gray-300 mt-2">Thank you for your booking. Here are your details:</p>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center border-b border-gray-700 py-3">
                    <span class="text-gray-400">Name:</span>
                    <span class="font-medium"><?php echo htmlspecialchars($booking_details['name']); ?></span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-700 py-3">
                    <span class="text-gray-400">Email:</span>
                    <span class="font-medium"><?php echo htmlspecialchars($booking_details['email']); ?></span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-700 py-3">
                    <span class="text-gray-400">Number of Tickets:</span>
                    <span class="font-medium"><?php echo $booking_details['tickets']; ?></span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-700 py-3">
                    <span class="text-gray-400">Total Price:</span>
                    <span class="font-medium">$<?php echo number_format($booking_details['total_price'], 2); ?></span>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-gray-300 mb-4">A confirmation email has been sent to your registered email address.</p>
                <a href="events.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                    Back to Events
                </a>
            </div>
        </div>
    </div>
</body>
</html> 