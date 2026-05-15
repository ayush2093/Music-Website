<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicWave - Music Library</title>
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
    
    <!-- JavaScript for Library and Player Functionality -->
    <script src="js/data.js"></script>
    <script src="js/library.js"></script>
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

        .track-card:hover .play-button {
            opacity: 1;
            transform: translateY(0);
        }

        .play-button {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .filter-button.active {
            background-color: #1DB954;
            color: white;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Include Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Library Header -->
    <section class="pt-24 pb-6 md:pt-32 px-4">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Music Library</h1>
                    <p class="text-gray-400">Discover new tracks and create your perfect playlist</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="flex items-center space-x-2">
                        
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="mb-8 overflow-x-auto pb-2">
                <div class="flex space-x-3 min-w-max">
                    <button class="filter-button active px-5 py-2 rounded-full bg-dark-100 text-white text-sm font-medium transition-colors">All Artists</button>
                    <!-- Dynamically generate artist buttons from musicData.genres -->
                    <button class="filter-button px-5 py-2 rounded-full bg-dark-100 text-white text-sm font-medium transition-colors">Ed Sheeran</button>
                    <button class="filter-button px-5 py-2 rounded-full bg-dark-100 text-white text-sm font-medium transition-colors">Arijit Singh</button>
                    <button class="filter-button px-5 py-2 rounded-full bg-dark-100 text-white text-sm font-medium transition-colors">Atif Aslam</button>
                    <button class="filter-button px-5 py-2 rounded-full bg-dark-100 text-white text-sm font-medium transition-colors">King</button>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h2 class="text-xl font-bold">Popular Tracks</h2>
                <div class="mt-2 md:mt-0 flex items-center space-x-4">
                   
                </div>
            </div>
            
            <!-- Track Grid -->
            <div class="track-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-12">                
                <!-- Tracks will be dynamically inserted here by JavaScript -->
            </div>
            
            <!-- Playlists Section -->
            
        </div>
    </section>

    <!-- Music Grid -->
    <section class="pb-24 px-4">
        <div class="container mx-auto">
            <!-- Songs will be dynamically inserted by JavaScript -->
        </div>
    </section>

    <!-- Fixed Music Player -->
    <div id="music-player" class="fixed bottom-0 left-0 right-0 bg-dark-300 border-t border-gray-800 shadow-lg z-50 transform transition-transform duration-300">
        <div class="container mx-auto px-4 py-3">
            <div class="flex flex-col md:flex-row items-center">
                <!-- Song Info -->
                <div class="flex items-center w-full md:w-1/4 mb-3 md:mb-0">
                    <div id="vinyl-record" class="relative w-14 h-14 rounded-full overflow-hidden mr-3 opacity-0 transition-opacity duration-500">
                        <img id="player-cover" src="https://via.placeholder.com/56" alt="Album Cover" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <div class="w-3 h-3 rounded-full bg-dark-300"></div>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <h3 id="player-title" class="font-medium text-sm text-white truncate">Select a song to play</h3>
                        <p id="player-artist" class="text-xs text-gray-400 truncate">-</p>
                    </div>
                </div>

                <!-- Player Controls -->
                <div class="w-full md:w-2/4 flex flex-col items-center">
                    <div class="flex items-center mb-2">
                        <button class="shuffle-button text-gray-400 hover:text-white mx-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </button>
                        <button class="prev-button text-gray-400 hover:text-white mx-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                            </svg>
                        </button>
                        <button id="play-button" class="bg-white rounded-full p-2 mx-3 hover:bg-opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-dark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                        </button>
                        <button class="next-button text-gray-400 hover:text-white mx-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                        </button>
                        <button class="repeat-button text-gray-400 hover:text-white mx-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                    <div class="w-full flex items-center">
                        <span id="current-time" class="text-xs text-gray-400 w-10 text-right">0:00</span>
                        <div class="flex-grow mx-2 progress-bar relative h-1 bg-dark-100 rounded cursor-pointer">
                            <div class="progress-bar-fill absolute left-0 top-0 h-full bg-accent-green rounded" style="width: 0%"></div>
                            <div class="progress-bar-handle absolute top-1/2 transform -translate-y-1/2 w-3 h-3 rounded-full bg-accent-green cursor-pointer" style="left: 0%"></div>
                        </div>
                        <span id="total-time" class="text-xs text-gray-400 w-10">0:00</span>
                    </div>
                </div>

                <!-- Volume and Extras -->
                <div class="w-full md:w-1/4 flex justify-end items-center mt-3 md:mt-0">
                    <!-- Like Button -->
                    <button class="like-button text-gray-400 hover:text-white transition-colors mx-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    
                    <!-- Add to Playlist Button -->
                    <button class="playlist-button text-gray-400 hover:text-white transition-colors mx-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.06-7.072m-2.828 9.9a9 9 0 010-12.728" />
                        </svg>
                        <input type="range" class="volume-slider w-24" min="0" max="100" value="80">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Visualizer -->
        <div class="w-full h-1 flex justify-center gap-1 overflow-hidden">
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
            <div class="visualizer-bar h-1 w-1 bg-accent-green rounded-full"></div>
        </div>
    </div>

    <!-- Audio Element -->
    <audio id="audio-player" style="display: none;"></audio>

    <!-- Include Profile Modal -->
    <?php include 'includes/profile-modal.php'; ?>
    
    <!-- Scripts -->
    <script src="js/like-song.js"></script>
    <script src="js/direct-playlist.js"></script>
</body>
</html>