<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once 'includes/db_connect.php';

// Fetch events from database
$events_query = "SELECT * FROM events ORDER BY date ASC";
$events_result = mysqli_query($conn, $events_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - MusicWave</title>
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
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'wave': 'wave 1.5s infinite',
                    },
                    keyframes: {
                        wave: {
                            '0%, 100%': { transform: 'scaleY(1)' },
                            '50%': { transform: 'scaleY(0.5)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0) rotate(0deg)' },
                            '25%': { transform: 'translateY(-15px) rotate(5deg)' },
                            '50%': { transform: 'translateY(0) rotate(0deg)' },
                            '75%': { transform: 'translateY(15px) rotate(-5deg)' },
                        },
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
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .neon-border {
            box-shadow: 0 0 5px #1DB954, 0 0 10px rgba(29, 185, 84, 0.3);
        }
        
        .hover-scale {
            transition: all 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        .event-card {
            transition: all 0.3s ease;
        }
        
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        
        .booking-form input, .booking-form select {
            background-color: rgba(42, 42, 42, 0.8);
            color: white;
            border: 1px solid rgba(58, 58, 58, 0.5);
            transition: all 0.3s ease;
        }
        
        .booking-form input:focus, .booking-form select:focus {
            border-color: #1ed760;
            outline: none;
            box-shadow: 0 0 15px rgba(30, 215, 96, 0.3);
            transform: translateY(-2px);
        }
    </style>
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
            
            <!-- Floating Music Notes -->
            <div class="absolute top-1/4 left-1/4 text-4xl text-accent-pink/20 animate-float" style="animation-duration: 8s">♪</div>
            <div class="absolute top-1/3 right-1/4 text-5xl text-accent-green/20 animate-float" style="animation-duration: 10s; animation-delay: 1s">♫</div>
            <div class="absolute bottom-1/3 left-1/3 text-6xl text-accent-blue/20 animate-float" style="animation-duration: 12s; animation-delay: 2s">♩</div>
            <div class="absolute bottom-1/4 right-1/3 text-4xl text-accent-pink/20 animate-float" style="animation-duration: 9s; animation-delay: 3s">♬</div>
        </div>
        
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
        
        <!-- Content -->
        <div class="container mx-auto px-4 py-16 relative z-10">
            <!-- Title with gradient text -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-4">
                    <div class="flex space-x-1 mr-3">
                        <div class="w-3 h-3 rounded-full bg-accent-green"></div>
                        <div class="w-3 h-3 rounded-full bg-accent-blue"></div>
                        <div class="w-3 h-3 rounded-full bg-accent-pink"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-400 tracking-wider uppercase">Upcoming Events</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">
                    Music <span class="relative">
                        <span class="relative z-10 bg-clip-text text-transparent bg-gradient-to-r from-accent-blue to-accent-green">Events</span>
                        <span class="absolute -inset-1 bg-accent-blue/10 blur-xl"></span>
                    </span>
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Experience the magic of live music with our upcoming events
                </p>
            </div>
            
            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <?php while ($event = mysqli_fetch_assoc($events_result)): ?>
                    <?php 
                        // Extract genre from event title or description for image selection
                        $genre = '';
                        $title_lower = strtolower($event['title']);
                        $desc_lower = strtolower($event['description']);
                        
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
                    <div class="glass-card rounded-xl overflow-hidden event-card">
                        <div class="relative h-48">
                            <?php if (!empty($event['image']) && file_exists('images/events/' . $event['image'])): ?>
                                <img src="images/events/<?php echo htmlspecialchars($event['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <img src="#" 
                                     data-genre="<?php echo $genre; ?>"
                                     alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                     class="w-full h-full object-cover event-placeholder-image">
                            <?php endif; ?>
                            <div class="absolute top-4 right-4 bg-accent-green/90 text-white px-3 py-1 rounded-full text-sm">
                                $<?php echo number_format($event['price'], 2); ?>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($event['title']); ?></h3>
                            <p class="text-gray-400 mb-4"><?php echo htmlspecialchars($event['description']); ?></p>
                            
                            <div class="flex items-center text-sm text-gray-400 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-accent-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <?php echo date('F j, Y', strtotime($event['date'])); ?> at <?php echo date('g:i A', strtotime($event['time'])); ?>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-400 mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-accent-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <?php echo htmlspecialchars($event['venue']); ?>
                            </div>
                            
                            <button onclick="directBookNow(<?php echo $event['id']; ?>, '<?php echo htmlspecialchars($event['title']); ?>', <?php echo $event['price']; ?>)"
                                    class="w-full bg-gradient-to-r from-accent-green to-emerald-400 hover:from-emerald-400 hover:to-accent-green text-white font-medium rounded-full px-6 py-3 transition-all hover-scale">
                                Book Now
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    
    <script>
        // New direct booking function without showing a form
        function directBookNow(eventId, eventTitle, eventPrice) {
            if (confirm(`Book one ticket for ${eventTitle} for $${eventPrice.toFixed(2)}?`)) {
                // Create a form and submit it programmatically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'process_booking.php';
                
                // Add only necessary fields - our backend will handle user details if logged in
                const fields = {
                    'event_id': eventId,
                    'tickets': 1, // Default to 1 ticket
                    'price': eventPrice,
                    // Include these fields for fallback if user is not logged in
                    'name': 'Guest User',
                    'email': 'guest@example.com',
                    'phone': '123-456-7890'
                };
                
                // Create and append hidden form fields
                for (const [name, value] of Object.entries(fields)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = name;
                    input.value = value;
                    form.appendChild(input);
                }
                
                // Append form to body, submit it, then remove it
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
        }
        
        // Set placeholder images based on genre after page loads
        document.addEventListener('DOMContentLoaded', function() {
            const placeholderImages = document.querySelectorAll('.event-placeholder-image');
            
            placeholderImages.forEach(img => {
                const genre = img.getAttribute('data-genre');
                img.src = getRandomGenreImage(genre);
            });
        });
    </script>
</body>
</html> 