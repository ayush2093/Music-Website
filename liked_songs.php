<?php
session_start();

// Check if user is logged in, redirect to login if not
if (!isset($_SESSION['user_id'])) {
    header("Location: signUpLogin/login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicWave - Liked Songs</title>
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
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Link to our CSS file -->
    <link rel="stylesheet" href="css/styles.css">
    
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
        }
        
        .music-wave {
            display: flex;
            align-items: flex-end;
            height: 50px;
            gap: 3px;
        }
        
        .music-wave span {
            width: 6px;
            background: linear-gradient(to top, #1DB954, #00BFFF);
            border-radius: 3px;
            animation: wave 1.2s infinite;
        }
        
        .music-wave span:nth-child(2) { animation-delay: 0.1s; }
        .music-wave span:nth-child(3) { animation-delay: 0.2s; }
        .music-wave span:nth-child(4) { animation-delay: 0.3s; }
        .music-wave span:nth-child(5) { animation-delay: 0.4s; }
        .music-wave span:nth-child(6) { animation-delay: 0.5s; }
        .music-wave span:nth-child(7) { animation-delay: 0.6s; }
        
        .glass-card {
            background: rgba(30, 30, 30, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
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
    </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-dark-300 to-black">
    <!-- Include Navbar -->
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 pt-24 pb-16">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Liked Songs</h1>
                <p id="liked-count" class="text-gray-400">Loading...</p>
            </div>
            <button id="play-all-button" class="mt-4 md:mt-0 bg-accent-green hover:bg-opacity-80 text-white font-medium rounded-full px-6 py-2.5 flex items-center transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Play All
            </button>
        </div>
        
        <!-- Songs List Header -->
        <div class="hidden md:flex items-center border-b border-gray-800 pb-2 mb-4 text-xs text-gray-500 uppercase font-medium">
            <div class="w-8 mr-4">#</div>
            <div class="flex-grow">Title</div>
            <div class="w-1/5 px-4">Album</div>
            <div class="w-1/6">Date Added</div>
            <div class="w-16 text-right">Duration</div>
            <div class="w-10"></div> <!-- For the remove button -->
        </div>
        
        <!-- Loading Spinner -->
        <div id="loading-spinner" class="flex justify-center items-center py-16">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-accent-green"></div>
        </div>
        
        <!-- Empty Liked Songs Message -->
        <div id="empty-liked" class="hidden text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <h2 class="text-xl font-semibold text-white mb-2">No liked songs yet</h2>
            <p class="text-gray-400 mb-6">Start liking songs to add them to your collection</p>
            <a href="library.php" class="bg-dark-100 hover:bg-dark-200 text-white py-2 px-6 rounded-full transition-colors">
                Browse Library
            </a>
        </div>
        
        <!-- Songs List Container -->
        <div id="liked-songs" class="space-y-2"></div>
    </main>
    
    <!-- Include Profile Modal -->
    <?php include 'includes/profile-modal.php'; ?>
    
    <!-- JavaScript -->
    <script src="js/liked-songs.js"></script>
</body>
</html>