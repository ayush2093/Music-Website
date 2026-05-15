<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signUpLogin/login.html');
    exit;
}

// Include database connection
include 'includes/db_connect.php';

// Get user's uploaded songs
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM songs WHERE user_id = $user_id ORDER BY created_at DESC";
$songs = fetchAll($sql);

// Get user information if available
$userInfo = [];
if (isset($_SESSION['user_id'])) {
    $userSql = "SELECT * FROM users WHERE id = " . $_SESSION['user_id'];
    $userInfo = fetch($userSql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Songs - MusicWave</title>
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
            height: 30px;
            gap: 2px;
        }
        
        .music-wave span {
            width: 4px;
            background: linear-gradient(to top, #1DB954, #00BFFF);
            border-radius: 2px;
            animation: wave 1.2s infinite;
        }
        
        .music-wave span:nth-child(2) { animation-delay: 0.1s; }
        .music-wave span:nth-child(3) { animation-delay: 0.2s; }
        .music-wave span:nth-child(4) { animation-delay: 0.3s; }
        .music-wave span:nth-child(5) { animation-delay: 0.4s; }
        
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
        
        .song-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .song-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .song-card .play-button {
            opacity: 0;
            transform: translateY(10px) scale(0.9);
            transition: all 0.3s ease;
        }
        
        .song-card:hover .play-button {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        
        .song-card .cover-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        
        .song-card:hover .cover-overlay {
            opacity: 1;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Include Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Main Content -->
    <main class="pt-24 pb-20">
        <!-- Hero Section -->
        <section class="relative">
            <!-- Animated Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-dark-300 via-dark-200 to-dark-300 z-0 overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1/2 bg-gradient-to-b from-accent-green/5 to-transparent z-0"></div>
                
                <!-- Animated Equalizer Bars -->
                <div class="absolute left-0 bottom-0 w-full h-32 flex items-end justify-center gap-1 opacity-10 overflow-hidden">
                    <div class="w-1 bg-accent-green rounded-t-full animate-[wave_1.3s_ease-in-out_infinite]" style="height: 60%; animation-delay: 0.1s"></div>
                    <div class="w-1 bg-accent-green rounded-t-full animate-[wave_1.7s_ease-in-out_infinite]" style="height: 30%; animation-delay: 0.2s"></div>
                    <div class="w-1 bg-accent-blue rounded-t-full animate-[wave_1.5s_ease-in-out_infinite]" style="height: 80%; animation-delay: 0.3s"></div>
                    <div class="w-1 bg-accent-blue rounded-t-full animate-[wave_1.8s_ease-in-out_infinite]" style="height: 70%; animation-delay: 0.4s"></div>
                    <div class="w-1 bg-accent-pink rounded-t-full animate-[wave_1.4s_ease-in-out_infinite]" style="height: 50%; animation-delay: 0.5s"></div>
                    <div class="w-1 bg-accent-green rounded-t-full animate-[wave_1.6s_ease-in-out_infinite]" style="height: 90%; animation-delay: 0.6s"></div>
                    <div class="w-1 bg-accent-pink rounded-t-full animate-[wave_1.5s_ease-in-out_infinite]" style="height: 40%; animation-delay: 0.7s"></div>
                </div>
            </div>
            
            <div class="container mx-auto px-4 py-12 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="flex space-x-1 mr-3">
                                <div class="w-2 h-2 rounded-full bg-accent-green"></div>
                                <div class="w-2 h-2 rounded-full bg-accent-blue"></div>
                                <div class="w-2 h-2 rounded-full bg-accent-pink"></div>
                            </div>
                            <span class="text-xs font-medium text-gray-400 tracking-wider uppercase">Your Music Collection</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold mb-1">My Uploaded Songs</h1>
                        <p class="text-gray-400">Manage and enjoy your personal music collection</p>
                    </div>
                    
                    <a href="upload_song.php" class="mt-4 md:mt-0 group relative inline-flex items-center justify-center px-6 py-3 font-medium text-white transition-all duration-300 ease-in-out rounded-full overflow-hidden border-2 border-accent-green bg-black">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-br from-accent-green to-teal-500 group-hover:opacity-100 opacity-0 transition-opacity duration-300 ease-in-out"></span>
                        <span class="relative flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Upload New Song
                        </span>
                    </a>
                </div>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <!-- Total Songs -->
                    <div class="glass-card rounded-xl p-5 flex items-center hover:shadow-lg hover:shadow-accent-green/10 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-green to-teal-500 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Total Songs</p>
                            <h3 class="font-bold text-2xl"><?php echo count($songs); ?></h3>
                        </div>
                    </div>
                    
                    <!-- Latest Upload -->
                    <div class="glass-card rounded-xl p-5 flex items-center hover:shadow-lg hover:shadow-accent-blue/10 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-blue to-blue-500 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Latest Upload</p>
                            <h3 class="font-bold text-lg">
                                <?php echo !empty($songs) ? htmlspecialchars($songs[0]['title']) : 'None'; ?>
                            </h3>
                        </div>
                    </div>
                    
                    <!-- Total Duration -->
                    <div class="glass-card rounded-xl p-5 flex items-center hover:shadow-lg hover:shadow-accent-pink/10 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-pink to-purple-500 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Total Duration</p>
                            <h3 class="font-bold text-2xl">
                                <?php
                                $totalDuration = 0;
                                foreach ($songs as $song) {
                                    $totalDuration += $song['duration'];
                                }
                                echo formatDuration($totalDuration);
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
                
        <!-- Songs Section -->
        <section class="container mx-auto px-4">
            <?php if (empty($songs)): ?>
                <div class="glass-card rounded-xl p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                    <p class="text-2xl text-gray-300 mb-6">You haven't uploaded any songs yet.</p>
                    <p class="text-gray-400 mb-8 max-w-md mx-auto">Start sharing your music with the world by uploading your first song to MusicWave.</p>
                    <a href="upload_song.php" class="group relative inline-flex items-center justify-center px-8 py-4 font-medium text-white transition-all duration-300 ease-in-out rounded-full overflow-hidden border-2 border-accent-green bg-black">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-br from-accent-green to-teal-500 group-hover:opacity-100 opacity-0 transition-opacity duration-300 ease-in-out"></span>
                        <span class="relative flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Upload Your First Song
                        </span>
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($songs as $song): ?>
                        <div class="song-card glass-card rounded-xl overflow-hidden">
                            <div class="relative">
                                <img src="<?php echo htmlspecialchars($song['cover']); ?>" alt="<?php echo htmlspecialchars($song['title']); ?>" class="w-full h-48 object-cover">
                                <div class="cover-overlay absolute inset-0 flex flex-col justify-end p-4">
                                    <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($song['title']); ?></h3>
                                    <p class="text-gray-300"><?php echo htmlspecialchars($song['artist']); ?></p>
                                </div>
                                <a href="player.php?id=<?php echo $song['id']; ?>" class="play-button absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-14 h-14 rounded-full bg-accent-green flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="px-3 py-1 bg-dark-100 rounded-full text-xs text-gray-300"><?php echo htmlspecialchars($song['genre']); ?></span>
                                    <span class="text-sm text-gray-400"><?php echo formatDuration($song['duration']); ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="music-wave scale-75 opacity-70">
                                        <span class="h-6"></span>
                                        <span class="h-3"></span>
                                        <span class="h-5"></span>
                                        <span class="h-2"></span>
                                        <span class="h-4"></span>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        <?php echo date('M d, Y', strtotime($song['created_at'])); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Quick Controls for All Songs -->
                <div class="glass-card rounded-xl p-6 mt-12">
                    <h3 class="text-xl font-bold mb-6">Quick Actions</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="player.php?playlist=my_songs" class="inline-flex items-center px-5 py-3 bg-accent-green/10 hover:bg-accent-green/20 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-accent-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Play All
                        </a>
                        <a href="upload_song.php" class="inline-flex items-center px-5 py-3 bg-accent-blue/10 hover:bg-accent-blue/20 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-accent-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Upload New
                        </a>
                        <a href="library.php" class="inline-flex items-center px-5 py-3 bg-accent-pink/10 hover:bg-accent-pink/20 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-accent-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            Music Library
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Include Profile Modal -->
    <?php include 'includes/profile-modal.php'; ?>
    
    <!-- Scripts -->
    <script src="js/script.js"></script>
    <script>
        // Add hover effects or other interactions if needed
        document.addEventListener('DOMContentLoaded', function() {
            // You could add custom JS here if needed
        });
    </script>
</body>
</html> 