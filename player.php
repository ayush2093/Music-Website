<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicWave - Now Playing</title>
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
                        'spin-slow': 'spin 8s linear infinite',
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

        .vinyl-record {
            position: relative;
            border-radius: 50%;
            background: linear-gradient(145deg, #272727, #1a1a1a);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        .vinyl-record::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20%;
            height: 20%;
            background: #121212;
            border-radius: 50%;
            border: 2px solid #333;
        }

        .vinyl-record::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 5%;
            height: 5%;
            background: #1DB954;
            border-radius: 50%;
        }

        .vinyl-grooves {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            overflow: hidden;
        }

        .vinyl-grooves::before {
            content: '';
            position: absolute;
            top: 15%;
            left: 15%;
            right: 15%;
            bottom: 15%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .vinyl-grooves::after {
            content: '';
            position: absolute;
            top: 30%;
            left: 30%;
            right: 30%;
            bottom: 30%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .progress-bar {
            position: relative;
            height: 6px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(to right, #1DB954, #00BFFF);
            border-radius: 3px;
            transition: width 0.1s ease;
        }

        .progress-bar-handle {
            position: absolute;
            top: 50%;
            width: 12px;
            height: 12px;
            background-color: white;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            transition: transform 0.1s ease;
        }

        .progress-bar-handle:hover {
            transform: translate(-50%, -50%) scale(1.2);
        }

        .volume-slider {
            -webkit-appearance: none;
            width: 100%;
            height: 4px;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.1);
            outline: none;
        }

        .volume-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .volume-slider::-webkit-slider-thumb:hover {
            transform: scale(1.2);
        }

        .volume-slider::-moz-range-thumb {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .volume-slider::-moz-range-thumb:hover {
            transform: scale(1.2);
        }

        .queue-item {
            transition: all 0.3s ease;
        }

        .queue-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .queue-item.active {
            background-color: rgba(29, 185, 84, 0.1);
            border-left: 3px solid #1DB954;
        }

        .visualizer-container {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            height: 60px;
            gap: 3px;
        }

        .visualizer-bar {
            width: 4px;
            background: linear-gradient(to top, #1DB954, #00BFFF);
            border-radius: 2px;
            transition: height 0.2s ease;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Include Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Main Player Section -->
    <div class="pt-24 pb-12 md:pt-32 md:pb-20 px-4">
        <div class="container mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Side - Album Art & Vinyl -->
                <div class="lg:w-1/2 flex flex-col items-center">
                    <div class="relative w-full max-w-md aspect-square rounded-2xl overflow-hidden neon-border mb-8">
                        <!-- Album Cover -->
                        <img src="https://via.placeholder.com/500" alt="Album Cover" class="w-full h-full object-cover">
                        
                        <!-- Vinyl Record (Positioned behind the album cover) -->
                        <div class="vinyl-record w-full h-full absolute top-0 left-0 animate-spin-slow opacity-0 transition-opacity duration-500" id="vinyl-record">
                            <div class="vinyl-grooves"></div>
                        </div>
                    </div>
                    
                    <!-- Visualizer -->
                    <div class="visualizer-container w-full max-w-md mb-6">
                        <div class="visualizer-bar h-10"></div>
                        <div class="visualizer-bar h-24"></div>
                        <div class="visualizer-bar h-16"></div>
                        <div class="visualizer-bar h-32"></div>
                        <div class="visualizer-bar h-20"></div>
                        <div class="visualizer-bar h-28"></div>
                        <div class="visualizer-bar h-14"></div>
                        <div class="visualizer-bar h-36"></div>
                        <div class="visualizer-bar h-22"></div>
                        <div class="visualizer-bar h-18"></div>
                        <div class="visualizer-bar h-30"></div>
                        <div class="visualizer-bar h-12"></div>
                        <div class="visualizer-bar h-26"></div>
                        <div class="visualizer-bar h-16"></div>
                        <div class="visualizer-bar h-34"></div>
                    </div>
                </div>
                
                <!-- Right Side - Player Controls & Queue -->
                <div class="lg:w-1/2">
                    <!-- Song Info -->
                    <div class="mb-8">
                        <h1 class="text-3xl md:text-4xl font-bold mb-2">Summer Vibes</h1>
                        <p class="text-xl text-gray-300 mb-1">Electronic Mix</p>
                        <p class="text-gray-400">Album: Summer Collection 2023</p>
                    </div>
                    
                    <!-- Player Controls -->
                    <div class="glass-card rounded-2xl p-6 mb-8">
                        <!-- Progress Bar -->
                        <div class="flex items-center justify-between text-sm text-gray-400 mb-2">
                            <span id="current-time">1:45</span>
                            <span id="total-time">3:30</span>
                        </div>
                        <div class="progress-bar mb-6">
                            <div class="progress-bar-fill" style="width: 50%"></div>
                            <div class="progress-bar-handle" style="left: 50%"></div>
                        </div>
                        
                        <!-- Control Buttons -->
                        <div class="flex justify-between items-center mb-6">
                            <button class="text-gray-400 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m-8 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </button>
                            
                            <button class="text-gray-400 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                                </svg>
                            </button>
                            
                            <button id="play-button" class="bg-white rounded-full p-4 hover:bg-accent-green transition-colors hover-scale">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-dark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                </svg>
                            </button>
                            
                            <button class="text-gray-400 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                </svg>
                            </button>
                            
                            <button class="text-gray-400 hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Additional Controls -->
                        <div class="flex justify-between items-center">
                            <!-- Like Button -->
                            <button class="like-button text-gray-400 hover:text-white transition-colors mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            
                            <!-- Add to Playlist Button -->
                            <button class="playlist-button text-gray-400 hover:text-white transition-colors mr-3" data-song-id="1">
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
                            
                            <button class="text-gray-400 hover:text-white transition-colors ml-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Queue -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Up Next</h2>
                            <button class="text-accent-green hover:text-accent-blue transition-colors text-sm">View Full Queue</button>
                        </div>
                        
                        <div class="space-y-2 max-h-80 overflow-y-auto pr-2">
                            <!-- Current Song -->
                            <div class="queue-item active flex items-center p-3 rounded-xl">
                                <div class="w-10 h-10 rounded bg-gradient-to-br from-accent-pink to-accent-blue mr-3 flex-shrink-0"></div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-medium text-sm truncate">Summer Vibes</h4>
                                    <p class="text-gray-400 text-xs truncate">Electronic Mix</p>
                                </div>
                                <div class="text-xs text-gray-400 ml-3">3:30</div>
                            </div>
                            
                            <!-- Next Songs -->
                            <div class="queue-item flex items-center p-3 rounded-xl">
                                <div class="w-10 h-10 rounded bg-gradient-to-br from-blue-500 to-teal-400 mr-3 flex-shrink-0"></div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-medium text-sm truncate">Electric Sunset</h4>
                                    <p class="text-gray-400 text-xs truncate">Neon Pulse</p>
                                </div>
                                <div class="text-xs text-gray-400 ml-3">4:12</div>
                            </div>
                            
                            <div class="queue-item flex items-center p-3 rounded-xl">
                                <div class="w-10 h-10 rounded bg-gradient-to-br from-yellow-400 to-orange-500 mr-3 flex-shrink-0"></div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-medium text-sm truncate">Coastal Beats</h4>
                                    <p class="text-gray-400 text-xs truncate">Summer Collection</p>
                                </div>
                                <div class="text-xs text-gray-400 ml-3">3:28</div>
                            </div>
                            
                            <div class="queue-item flex items-center p-3 rounded-xl">
                                <div class="w-10 h-10 rounded bg-gradient-to-br from-indigo-500 to-purple-600 mr-3 flex-shrink-0"></div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-medium text-sm truncate">Midnight Jazz</h4>
                                    <p class="text-gray-400 text-xs truncate">Blue Note Ensemble</p>
                                </div>
                                <div class="text-xs text-gray-400 ml-3">5:17</div>
                            </div>
                            
                            <div class="queue-item flex items-center p-3 rounded-xl">
                                <div class="w-10 h-10 rounded bg-gradient-to-br from-red-500 to-pink-600 mr-3 flex-shrink-0"></div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-medium text-sm truncate">Retro Wave</h4>
                                    <p class="text-gray-400 text-xs truncate">Synthwave Riders</p>
                                </div>
                                <div class="text-xs text-gray-400 ml-3">4:05</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Profile Modal -->
    <?php include 'includes/profile-modal.php'; ?>

    <!-- JavaScript -->
    <script src="js/data.js"></script>
    <script src="js/player.js"></script>
    <script src="js/like-song.js"></script>
    <script src="js/direct-playlist.js"></script>
</body>
</html>