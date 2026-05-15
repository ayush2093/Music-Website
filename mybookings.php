<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once 'includes/db_connect.php';

// Check if user is logged in (for registered users)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Get user email (for guest bookings)
$user_email = isset($_GET['email']) ? mysqli_real_escape_string($conn, $_GET['email']) : '';

// Prepare query based on login status
if ($user_id) {
    // For logged-in users, get bookings by user_id
    $bookings_query = "SELECT b.*, e.title, e.date, e.time, e.venue, e.image, e.description 
                      FROM events_booking b 
                      JOIN events e ON b.event_id = e.id 
                      WHERE b.user_id = $user_id 
                      ORDER BY b.booking_date DESC";
} elseif (!empty($user_email)) {
    // For guests, search by email
    $bookings_query = "SELECT b.*, e.title, e.date, e.time, e.venue, e.image, e.description 
                      FROM events_booking b 
                      JOIN events e ON b.event_id = e.id 
                      WHERE b.email = '$user_email' 
                      ORDER BY b.booking_date DESC";
} else {
    // Default empty query if no user_id or email
    $bookings_query = "";
}

// Flag to check if query has been executed
$query_executed = false;
$bookings_result = false;

// Execute query if it's not empty
if (!empty($bookings_query)) {
    $bookings_result = mysqli_query($conn, $bookings_query);
    $query_executed = true;
}

// Get cancellation messages
$cancel_success = isset($_SESSION['cancel_success']) ? $_SESSION['cancel_success'] : '';
$cancel_error = isset($_SESSION['cancel_error']) ? $_SESSION['cancel_error'] : '';

// Clear session messages after reading
unset($_SESSION['cancel_success']);
unset($_SESSION['cancel_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - MusicWave</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: {
                            100: '#272727',
                            200: '#1E1E1E',
                            300: '#121212',
                            400: '#0A0A0A'
                        },
                        accent: {
                            green: '#1DB954',
                            pink: '#E91E63',
                            blue: '#00BFFF',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
        }
        
        .glass-card {
            background: rgba(30, 30, 30, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .booking-card {
            transition: all 0.3s ease;
        }
        
        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        /* Alert styles */
        .alert {
            animation: fadeOut 0.5s ease 5s forwards;
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; visibility: hidden; }
        }
    </style>
    
    <!-- Define placeholder/fallback image URLs by music genre -->
    <script>
        // Genre-based image placeholders for events
        const genreImages = {
            "rock": [
                "https://images.unsplash.com/photo-1429962714451-bb934ecdc4ec?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1505628346881-b72b27e84530?w=800&auto=format&fit=crop"
            ],
            "pop": [
                "https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1501386761578-eac5c94b800a?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800&auto=format&fit=crop"
            ],
            "jazz": [
                "https://images.unsplash.com/photo-1415201364774-f6f0bb35f28f?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1511192336575-5a79af67a629?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=800&auto=format&fit=crop"
            ],
            "classical": [
                "https://images.unsplash.com/photo-1507838153414-b4b713384a76?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1558584673-c834fb1cc3ca?w=800&auto=format&fit=crop"
            ],
            "electronic": [
                "https://images.unsplash.com/photo-1571266028243-8508246562d5?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1481886756534-97af88ccb438?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=800&auto=format&fit=crop"
            ],
            "hip-hop": [
                "https://images.unsplash.com/photo-1547355253-ff0740f6e8c1?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1578873375969-d60aad647bb9?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1619597361832-a568b1e0555f?w=800&auto=format&fit=crop"
            ],
            "default": [
                "https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800&auto=format&fit=crop",
                "https://images.unsplash.com/photo-1549213783-8284d0336c4f?w=800&auto=format&fit=crop"
            ]
        };
        
        // Function to get a random image for a genre
        function getRandomGenreImage(genre) {
            const genreKey = genre && genre.toLowerCase() in genreImages ? genre.toLowerCase() : 'default';
            const images = genreImages[genreKey];
            const randomIndex = Math.floor(Math.random() * images.length);
            return images[randomIndex];
        }
    </script>
</head>
<body class="bg-dark-400 text-white min-h-screen">
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Animated Background with Music Theme -->
    <div class="relative min-h-screen overflow-hidden">
        <!-- Animated Background Gradient -->
        <div class="absolute inset-0 bg-black z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-900/30 via-dark-300 to-black z-0"></div>
            <div class="absolute top-0 left-0 right-0 h-1/2 bg-gradient-to-b from-accent-green/5 to-transparent z-0"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-accent-blue/5 to-transparent z-0"></div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 py-16 relative z-10 mt-16">
            <!-- Title with gradient text -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">
                    My <span class="relative">
                        <span class="relative z-10 bg-clip-text text-transparent bg-gradient-to-r from-accent-blue to-accent-green">Bookings</span>
                        <span class="absolute -inset-1 bg-accent-blue/10 blur-xl"></span>
                    </span>
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    View and manage your event bookings
                </p>
            </div>
            
            <!-- Success or Error Messages -->
            <?php if (!empty($cancel_success)): ?>
                <div id="successAlert" class="mx-auto max-w-xl mb-8 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded alert">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p><?php echo htmlspecialchars($cancel_success); ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($cancel_error)): ?>
                <div id="errorAlert" class="mx-auto max-w-xl mb-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded alert">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p><?php echo htmlspecialchars($cancel_error); ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!$user_id && !$query_executed): ?>
            <!-- Email Search Form for Guest Users -->
            <div class="max-w-md mx-auto mb-12 glass-card rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-4">Find your bookings</h2>
                <form action="mybookings.php" method="GET" class="space-y-4">
                    <div>
                        <label for="email" class="block text-gray-300 mb-2">Enter your email</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-4 py-3 rounded-lg bg-dark-100 border border-gray-700 focus:ring-2 focus:ring-accent-green text-white">
                    </div>
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-accent-green to-emerald-400 hover:from-emerald-400 hover:to-accent-green text-white font-medium rounded-full px-6 py-3 transition-all hover:scale-105">
                        Find Bookings
                    </button>
                </form>
            </div>
            <?php endif; ?>
            
            <?php if ($query_executed): ?>
                <?php if ($bookings_result && mysqli_num_rows($bookings_result) > 0): ?>
                    <!-- Bookings Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php while ($booking = mysqli_fetch_assoc($bookings_result)): ?>
                            <?php 
                                // Extract genre from event title or description for image selection
                                $genre = '';
                                $title_lower = strtolower($booking['title']);
                                $desc_lower = isset($booking['description']) ? strtolower($booking['description']) : '';
                                
                                // Try to determine genre from title or description
                                if (strpos($title_lower, 'rock') !== false || strpos($desc_lower, 'rock') !== false) {
                                    $genre = 'rock';
                                } elseif (strpos($title_lower, 'pop') !== false || strpos($desc_lower, 'pop') !== false) {
                                    $genre = 'pop';
                                } elseif (strpos($title_lower, 'jazz') !== false || strpos($desc_lower, 'jazz') !== false) {
                                    $genre = 'jazz';
                                } elseif (strpos($title_lower, 'classic') !== false || strpos($desc_lower, 'classic') !== false) {
                                    $genre = 'classical';
                                } elseif (strpos($title_lower, 'electro') !== false || strpos($desc_lower, 'electro') !== false) {
                                    $genre = 'electronic';
                                } elseif (strpos($title_lower, 'hip') !== false || strpos($desc_lower, 'hip') !== false || 
                                         strpos($title_lower, 'rap') !== false || strpos($desc_lower, 'rap') !== false) {
                                    $genre = 'hip-hop';
                                } else {
                                    $genre = 'default';
                                }
                            ?>
                            <div class="glass-card rounded-xl overflow-hidden booking-card">
                                <div class="relative h-40">
                                    <?php if (!empty($booking['image']) && file_exists('images/events/' . $booking['image'])): ?>
                                        <img src="images/events/<?php echo htmlspecialchars($booking['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($booking['title']); ?>" 
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <img src="#" 
                                             data-genre="<?php echo $genre; ?>"
                                             alt="<?php echo htmlspecialchars($booking['title']); ?>" 
                                             class="w-full h-full object-cover booking-placeholder-image">
                                    <?php endif; ?>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <div class="text-sm text-white/80"><?php echo date('F j, Y', strtotime($booking['date'])); ?> at <?php echo date('g:i A', strtotime($booking['time'])); ?></div>
                                        <h3 class="text-xl font-semibold text-white"><?php echo htmlspecialchars($booking['title']); ?></h3>
                                    </div>
                                </div>
                                
                                <div class="p-5">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-gray-400">Booking ID:</span>
                                        <span class="font-medium">#<?php echo $booking['id']; ?></span>
                                    </div>
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-gray-400">Status:</span>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            <?php 
                                            if ($booking['status'] === 'confirmed') {
                                                echo 'bg-green-500/20 text-green-400';
                                            } elseif ($booking['status'] === 'cancelled') {
                                                echo 'bg-red-500/20 text-red-400';
                                            } else {
                                                echo 'bg-yellow-500/20 text-yellow-400';
                                            }
                                            ?>">
                                            <?php echo ucfirst($booking['status']); ?>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-gray-400">Tickets:</span>
                                        <span class="font-medium"><?php echo $booking['tickets']; ?></span>
                                    </div>
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-gray-400">Total Paid:</span>
                                        <span class="font-medium">$<?php echo number_format($booking['total_price'], 2); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-gray-400">Booked on:</span>
                                        <span class="font-medium"><?php echo date('M j, Y', strtotime($booking['booking_date'])); ?></span>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-center">
                                        <a href="javascript:void(0)" 
                                           onclick="confirmCancel(<?php echo $booking['id']; ?>, '<?php echo htmlspecialchars($booking['title']); ?>', '<?php echo (!empty($user_email) ? htmlspecialchars($user_email) : ''); ?>')" 
                                           class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg px-6 py-3 text-center transition-all">
                                            Cancel Booking
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <!-- No Bookings Found -->
                    <div class="glass-card rounded-xl p-8 text-center max-w-lg mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-2xl font-semibold mb-2">No Bookings Found</h3>
                        <p class="text-gray-400 mb-6">You haven't made any bookings yet.</p>
                        <a href="events.php" class="inline-block bg-accent-green hover:bg-opacity-80 text-white font-medium rounded-full px-6 py-3 transition-all">
                            Explore Events
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="glass-card rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-semibold mb-2">Confirm Deletion</h3>
            <p class="text-gray-300 mb-6" id="confirmationText">Are you sure you want to delete this booking?</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelButton" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    No, Keep It
                </button>
                <a id="confirmButton" href="#" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    Yes, Delete Booking
                </a>
            </div>
        </div>
    </div>
    
    <!-- Script to load placeholder images and handle cancellation -->
    <script>
        // Set placeholder images based on genre after page loads
        document.addEventListener('DOMContentLoaded', function() {
            const placeholderImages = document.querySelectorAll('.booking-placeholder-image');
            
            placeholderImages.forEach(img => {
                const genre = img.getAttribute('data-genre');
                img.src = getRandomGenreImage(genre);
            });
            
            // Close alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.display = 'none';
                });
            }, 5000);
        });
        
        // Cancel booking confirmation
        function confirmCancel(bookingId, eventTitle, userEmail) {
            // Get modal elements
            const modal = document.getElementById('confirmationModal');
            const confirmText = document.getElementById('confirmationText');
            const confirmBtn = document.getElementById('confirmButton');
            const cancelBtn = document.getElementById('cancelButton');
            
            // Set confirmation text
            confirmText.textContent = `Are you sure you want to cancel your booking for "${eventTitle}"?`;
            
            // Set confirm button link
            let cancelUrl = `cancel_booking.php?id=${bookingId}`;
            if (userEmail) {
                cancelUrl += `&email=${encodeURIComponent(userEmail)}`;
            }
            confirmBtn.href = cancelUrl;
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Close modal when clicking cancel button
            cancelBtn.onclick = function() {
                modal.classList.add('hidden');
            };
            
            // Close modal when clicking outside
            modal.onclick = function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            };
        }
    </script>
</body>
</html> 