<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicWave - Feel the Beat. Stream the Sound.</title>
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
                        },
                        spin: {
                            from: { transform: 'translate(-50%, -50%) translateZ(10px) rotate(0deg)' },
                            to: { transform: 'translate(-50%, -50%) translateZ(10px) rotate(360deg)' },
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
        
        /* 3D Perspective */
        .perspective-500 {
            perspective: 500px;
        }
        
        /* 3D Transforms */
        .rotate-y-35 {
            transform: rotateY(35deg);
        }
        
        .rotate-y-30 {
            transform: rotateY(30deg);
        }
        
        .rotate-z-10 {
            transform: rotateZ(10deg);
        }
        
        .translate-z-10 {
            transform: translateZ(10px);
        }
        
        .translate-z-15 {
            transform: translateZ(15px);
        }
        
        .translate-z-20 {
            transform: translateZ(20px);
        }
        
        .translate-z-25 {
            transform: translateZ(25px);
        }
        
        .translate-z-30 {
            transform: translateZ(30px);
        }
        
        /* Vinyl Record Animation */
        .rotate-spin {
            animation: spin 20s linear infinite;
        }
        
        @keyframes spin {
            from { transform: translate(-50%, -50%) translateZ(10px) rotate(0deg); }
            to { transform: translate(-50%, -50%) translateZ(10px) rotate(360deg); }
        }
        
        /* Floating Music Notes Animation */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Include Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section with 3D/Gradient Effect -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Animated Background Gradient -->
        <div class="absolute inset-0 bg-black z-0">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-900/30 via-dark-300 to-black z-0"></div>
            <div class="absolute top-0 left-0 right-0 h-1/2 bg-gradient-to-b from-accent-green/5 to-transparent z-0"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-accent-blue/5 to-transparent z-0"></div>
            
            <!-- Animated Equalizer Bars -->
            <div class="absolute left-0 bottom-0 w-full h-96 flex items-end justify-center gap-1 opacity-20 overflow-hidden">
                <div class="w-2 bg-accent-green rounded-t-full animate-[wave_1.3s_ease-in-out_infinite]" style="height: 60%; animation-delay: 0.1s"></div>
                <div class="w-2 bg-accent-green rounded-t-full animate-[wave_1.7s_ease-in-out_infinite]" style="height: 30%; animation-delay: 0.2s"></div>
                <div class="w-2 bg-accent-blue rounded-t-full animate-[wave_1.5s_ease-in-out_infinite]" style="height: 80%; animation-delay: 0.3s"></div>
                <div class="w-2 bg-accent-blue rounded-t-full animate-[wave_1.8s_ease-in-out_infinite]" style="height: 70%; animation-delay: 0.4s"></div>
                <div class="w-2 bg-accent-pink rounded-t-full animate-[wave_1.4s_ease-in-out_infinite]" style="height: 50%; animation-delay: 0.5s"></div>
                <div class="w-2 bg-accent-green rounded-t-full animate-[wave_1.6s_ease-in-out_infinite]" style="height: 90%; animation-delay: 0.6s"></div>
                <div class="w-2 bg-accent-pink rounded-t-full animate-[wave_1.5s_ease-in-out_infinite]" style="height: 40%; animation-delay: 0.7s"></div>
                <div class="w-2 bg-accent-blue rounded-t-full animate-[wave_1.4s_ease-in-out_infinite]" style="height: 60%; animation-delay: 0.8s"></div>
                <div class="w-2 bg-accent-green rounded-t-full animate-[wave_1.7s_ease-in-out_infinite]" style="height: 80%; animation-delay: 0.9s"></div>
                <div class="w-2 bg-accent-pink rounded-t-full animate-[wave_1.3s_ease-in-out_infinite]" style="height: 50%; animation-delay: 1.0s"></div>
                <div class="w-2 bg-accent-blue rounded-t-full animate-[wave_1.6s_ease-in-out_infinite]" style="height: 70%; animation-delay: 1.1s"></div>
                <div class="w-2 bg-accent-green rounded-t-full animate-[wave_1.5s_ease-in-out_infinite]" style="height: 60%; animation-delay: 1.2s"></div>
                <div class="w-2 bg-accent-blue rounded-t-full animate-[wave_1.8s_ease-in-out_infinite]" style="height: 40%; animation-delay: 1.3s"></div>
                <div class="w-2 bg-accent-pink rounded-t-full animate-[wave_1.4s_ease-in-out_infinite]" style="height: 80%; animation-delay: 1.4s"></div>
                <div class="w-2 bg-accent-green rounded-t-full animate-[wave_1.7s_ease-in-out_infinite]" style="height: 50%; animation-delay: 1.5s"></div>
                <div class="w-2 bg-accent-blue rounded-t-full animate-[wave_1.5s_ease-in-out_infinite]" style="height: 60%; animation-delay: 1.6s"></div>
                <div class="w-2 bg-accent-pink rounded-t-full animate-[wave_1.8s_ease-in-out_infinite]" style="height: 70%; animation-delay: 1.7s"></div>
                <div class="w-2 bg-accent-green rounded-t-full animate-[wave_1.6s_ease-in-out_infinite]" style="height: 40%; animation-delay: 1.8s"></div>
                <div class="w-2 bg-accent-blue rounded-t-full animate-[wave_1.3s_ease-in-out_infinite]" style="height: 80%; animation-delay: 1.9s"></div>
            </div>
            
            <!-- Floating Music Notes -->
            <div class="absolute top-1/4 left-1/4 text-4xl text-accent-pink/20 animate-float" style="animation-duration: 8s">♪</div>
            <div class="absolute top-1/3 right-1/4 text-5xl text-accent-green/20 animate-float" style="animation-duration: 10s; animation-delay: 1s">♫</div>
            <div class="absolute bottom-1/3 left-1/3 text-6xl text-accent-blue/20 animate-float" style="animation-duration: 12s; animation-delay: 2s">♩</div>
            <div class="absolute bottom-1/4 right-1/3 text-4xl text-accent-pink/20 animate-float" style="animation-duration: 9s; animation-delay: 3s">♬</div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-6 relative z-10 py-20 md:py-0">
            <div class="flex flex-col md:flex-row items-center justify-between md:gap-12">
                <!-- Text Content -->
                <div class="mb-12 md:mb-0 max-w-xl text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start mb-4">
                        <div class="flex space-x-1 mr-3">
                            <div class="w-3 h-3 rounded-full bg-accent-green"></div>
                            <div class="w-3 h-3 rounded-full bg-accent-blue"></div>
                            <div class="w-3 h-3 rounded-full bg-accent-pink"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-400 tracking-wider uppercase">Premium Music Experience</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight leading-tight">
                        Feel the <span class="relative">
                            <span class="relative z-10 bg-clip-text text-transparent bg-gradient-to-r from-accent-green to-emerald-400">Beat.</span>
                            <span class="absolute -inset-1 bg-accent-green/10 blur-xl"></span>
                        </span>
                        <br>
                        Stream the <span class="relative">
                            <span class="relative z-10 bg-clip-text text-transparent bg-gradient-to-r from-accent-blue to-cyan-400">Sound.</span>
                            <span class="absolute -inset-1 bg-accent-blue/10 blur-xl"></span>
                        </span>
                    </h1>
                    
                    <p class="text-xl text-gray-300 mb-10 leading-relaxed">
                        Discover millions of songs, create your perfect playlists, and enjoy music like never before with our immersive streaming experience.
                    </p>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-5">
                        <a href="library.html" class="group relative inline-flex items-center justify-center px-8 py-4 font-medium text-white transition-all duration-300 ease-in-out rounded-full overflow-hidden border-2 border-accent-green bg-black">
                            <span class="absolute inset-0 w-full h-full bg-gradient-to-br from-accent-green to-teal-500 group-hover:opacity-100 opacity-0 transition-opacity duration-300 ease-in-out"></span>
                            <span class="relative flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            Explore Music
                            </span>
                        </a>
                        
                        <a href="#" class="relative inline-flex items-center justify-center px-8 py-4 font-medium text-white transition-all duration-300 bg-transparent backdrop-blur-sm border-2 border-white/20 hover:border-accent-pink/50 rounded-full overflow-hidden group">
                            <span class="absolute inset-0 w-full h-full bg-accent-pink/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out"></span>
                            <span class="relative flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            Join Now
                            </span>
                        </a>
                    </div>
                </div>
                
                <!-- 3D Album Art Display -->
                <div class="w-full md:w-1/2 relative perspective-500">
                    <div class="relative w-full max-w-sm mx-auto aspect-square transform rotate-y-35 rotate-z-10 hover:rotate-y-30 transition-transform duration-700">
                        <!-- Album Covers Stack -->
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-accent-pink rounded-lg shadow-2xl transform translate-z-25 hover:translate-z-30 transition-transform duration-500"></div>
                        <div class="absolute inset-0 bg-gradient-to-br from-accent-blue to-cyan-500 rounded-lg shadow-2xl transform translate-z-20 translate-x-4 -translate-y-4 hover:translate-z-25 transition-transform duration-500"></div>
                        <div class="absolute inset-0 bg-gradient-to-br from-accent-green to-emerald-500 rounded-lg shadow-2xl transform translate-z-15 translate-x-8 -translate-y-8 hover:translate-z-20 transition-transform duration-500"></div>
                        
                        <!-- Main Album -->
                        <div class="absolute inset-0 rounded-lg overflow-hidden shadow-2xl transform translate-x-12 -translate-y-12 hover:translate-z-15 transition-transform duration-500 group">
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-dark-300"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                                <div class="music-wave scale-[2] opacity-80">
                                    <span class="h-12 bg-accent-green"></span>
                                    <span class="h-8 bg-accent-green"></span>
                                    <span class="h-16 bg-accent-blue"></span>
                                    <span class="h-10 bg-accent-blue"></span>
                                    <span class="h-14 bg-accent-pink"></span>
                                    <span class="h-6 bg-accent-pink"></span>
                                    <span class="h-12 bg-accent-green"></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Vinyl Record -->
                        <div class="absolute top-1/2 left-1/2 w-1/2 h-1/2 rounded-full bg-gradient-to-br from-gray-900 to-gray-800 transform -translate-x-1/2 -translate-y-1/2 translate-z-10 rotate-spin shadow-inner border border-gray-700">
                            <div class="absolute top-1/2 left-1/2 w-1/4 h-1/4 rounded-full bg-accent-green transform -translate-x-1/2 -translate-y-1/2"></div>
                            <div class="absolute top-1/2 left-1/2 w-3/4 h-3/4 rounded-full border-t border-white/10 transform -translate-x-1/2 -translate-y-1/2"></div>
                            <div class="absolute top-1/2 left-1/2 w-2/3 h-2/3 rounded-full border-t border-white/5 transform -translate-x-1/2 -translate-y-1/2"></div>
                            <div class="absolute top-1/2 left-1/2 w-1/2 h-1/2 rounded-full border-t border-white/5 transform -translate-x-1/2 -translate-y-1/2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Features Section -->
    <section class="py-20 bg-gradient-to-b from-dark-200 to-dark-300">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Premium Features</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Experience music like never before with our premium features designed for the ultimate listening experience.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card rounded-2xl p-8 hover:shadow-lg hover:shadow-accent-green/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-green to-teal-500 flex items-center justify-center mb-6 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-3">High Definition Audio</h3>
                    <p class="text-gray-400 text-center">Experience crystal clear sound with our high-definition audio streaming technology.</p>
                    </div>
                    
                <!-- Feature 2 -->
                <div class="glass-card rounded-2xl p-8 hover:shadow-lg hover:shadow-accent-blue/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-blue to-blue-500 flex items-center justify-center mb-6 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-3">Offline Listening</h3>
                    <p class="text-gray-400 text-center">Download your favorite tracks and playlists to listen offline, anywhere and anytime.</p>
                    </div>
                    
                <!-- Feature 3 -->
                <div class="glass-card rounded-2xl p-8 hover:shadow-lg hover:shadow-accent-pink/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-pink to-purple-500 flex items-center justify-center mb-6 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-3">Personalized Recommendations</h3>
                    <p class="text-gray-400 text-center">Get tailored music suggestions based on your listening habits and preferences.</p>
                    </div>
                    
                <!-- Feature 4 -->
                <div class="glass-card rounded-2xl p-8 hover:shadow-lg hover:shadow-yellow-500/10 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center mb-6 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-3">Ad-Free Experience</h3>
                    <p class="text-gray-400 text-center">Enjoy uninterrupted music streaming without any advertisements or distractions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Artist Highlights -->
    <section class="py-12 px-4">
        <div class="container mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold mb-8">Artist Highlights</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Artist 1 -->
                <div class="glass-card rounded-2xl p-6 hover-scale">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-accent-pink to-accent-blue mr-4"></div>
                        <div>
                            <h3 class="font-bold text-lg">Aria Luna</h3>
                            <p class="text-gray-400">Electronic • Pop</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4">"MusicWave has transformed how I connect with fans. The platform's immersive experience brings my music to life."</p>
                    <div class="flex justify-between items-center">
                        <span class="text-accent-green text-sm">2.4M monthly listeners</span>
                        <button class="text-white bg-dark-100 hover:bg-dark-200 rounded-full px-4 py-2 text-sm transition-colors">
                            View Artist
                        </button>
                    </div>
                </div>
                
                <!-- Artist 2 -->
                <div class="glass-card rounded-2xl p-6 hover-scale">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 mr-4"></div>
                        <div>
                            <h3 class="font-bold text-lg">Rhythm Collective</h3>
                            <p class="text-gray-400">Jazz • Funk</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4">"The sound quality and user experience on MusicWave is unmatched. It's where our music truly shines."</p>
                    <div class="flex justify-between items-center">
                        <span class="text-accent-green text-sm">1.8M monthly listeners</span>
                        <button class="text-white bg-dark-100 hover:bg-dark-200 rounded-full px-4 py-2 text-sm transition-colors">
                            View Artist
                        </button>
                    </div>
                </div>
                
                <!-- Artist 3 -->
                <div class="glass-card rounded-2xl p-6 hover-scale">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-accent-green to-teal-400 mr-4"></div>
                        <div>
                            <h3 class="font-bold text-lg">Echo Wave</h3>
                            <p class="text-gray-400">Indie • Alternative</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4">"MusicWave's platform has helped us reach new audiences globally. The interface is intuitive and visually stunning."</p>
                    <div class="flex justify-between items-center">
                        <span class="text-accent-green text-sm">3.1M monthly listeners</span>
                        <button class="text-white bg-dark-100 hover:bg-dark-200 rounded-full px-4 py-2 text-sm transition-colors">
                            View Artist
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile App Section -->
    <section class="py-20 bg-gradient-to-r from-dark-300 to-black relative overflow-hidden">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 left-0 w-full h-full bg-pattern bg-repeat opacity-5"></div>
        </div>
        
        <div class="container mx-auto px-6 relative">
            <div class="flex flex-col md:flex-row items-center">
                <!-- Content -->
                <div class="md:w-1/2 md:pr-12 mb-12 md:mb-0">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Take Your Music Everywhere</h2>
                    <p class="text-gray-300 text-lg mb-8">Download our mobile app and enjoy your favorite tracks on the go. Available for iOS and Android devices with seamless synchronization.</p>
                    
                    <div class="flex flex-wrap gap-4">
                        <!-- App Store -->
                        <a href="#" class="bg-dark-100 hover:bg-dark-200 transition-colors rounded-xl p-3 flex items-center">
                            <div class="mr-3 text-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16.984 0.984c-1.453-0.234-3.047 0.797-3.891 2.109-0.797 1.219-1.313 2.859-0.703 4.641 1.5 0.094 3.047-0.75 3.891-2.016 0.844-1.266 1.172-2.953 0.703-4.734zM12 9.516c-0.844 0-2.109 0.469-3.469 0.469-1.781 0-3.375-1.031-4.5-1.031-1.406 0-2.859 0.984-3.984 2.719-1.969 3.047-1.688 8.578 1.547 13.312 0.938 1.359 2.109 2.906 3.609 2.953 1.266 0.047 1.734-0.516 3.234-0.516s2.016 0.516 3.328 0.516c1.5 0 2.484-1.359 3.422-2.719 0.656-0.984 1.219-2.109 1.688-3.375-4.219-1.641-4.875-7.5-0.938-9.938-1.5-1.969-3.703-2.391-3.938-2.391z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400">Download on the</div>
                                <div class="text-base font-semibold">App Store</div>
                            </div>
                        </a>
                        
                        <!-- Google Play -->
                        <a href="#" class="bg-dark-100 hover:bg-dark-200 transition-colors rounded-xl p-3 flex items-center">
                            <div class="mr-3 text-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3.609 1.266c-0.563 0.188-1.172 0.797-1.172 1.875v17.719c0 1.078 0.609 1.688 1.172 1.875l10.781-10.734zM14.484 12l3.516-3.516-11.484-6.609 7.969 10.125zM17.016 8.391l1.875-1.875c0.609-0.609 0.141-1.594-0.469-1.969l-13.219 7.594 4.031 4.031zM6.891 18.656l11.484-6.609-3.516-3.516z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400">Get it on</div>
                                <div class="text-base font-semibold">Google Play</div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="mt-8 flex items-center space-x-6">
                        <div class="flex items-center">
                            <div class="flex -space-x-2">
                                <img src="https://randomuser.me/api/portraits/women/32.jpg" class="w-8 h-8 rounded-full border-2 border-dark-300" alt="User">
                                <img src="https://randomuser.me/api/portraits/men/54.jpg" class="w-8 h-8 rounded-full border-2 border-dark-300" alt="User">
                                <img src="https://randomuser.me/api/portraits/women/61.jpg" class="w-8 h-8 rounded-full border-2 border-dark-300" alt="User">
                            </div>
                            <span class="ml-3 text-sm text-gray-400">Join 2M+ users</span>
                        </div>
                        
                <div class="flex items-center">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <span class="ml-1 text-sm text-gray-400">4.9/5</span>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gradient-to-b from-dark-200 to-dark-300">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">What Our Users Say</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Join millions of music lovers who have discovered their perfect soundtrack with MusicWave.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="glass-card rounded-2xl p-8 relative">
                    <div class="absolute -top-5 -left-5 text-5xl text-accent-green opacity-20">"</div>
                    <div class="absolute -bottom-5 -right-5 text-5xl text-accent-green opacity-20">"</div>
                    
                    <p class="text-gray-300 mb-8 relative z-10">MusicWave completely changed how I discover new music. The personalized recommendations are so accurate that it feels like the app knows my taste better than I do!</p>
                    
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-accent-pink mr-4"></div>
                        <div>
                            <h4 class="font-bold">Sarah Johnson</h4>
                            <p class="text-gray-400 text-sm">Premium Member</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="glass-card rounded-2xl p-8 relative">
                    <div class="absolute -top-5 -left-5 text-5xl text-accent-blue opacity-20">"</div>
                    <div class="absolute -bottom-5 -right-5 text-5xl text-accent-blue opacity-20">"</div>
                    
                    <p class="text-gray-300 mb-8 relative z-10">The sound quality is incredible! I can hear details in my favorite songs that I never noticed before. Plus, the offline mode is perfect for my daily commute through areas with spotty reception.</p>
                    
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-blue to-blue-600 mr-4"></div>
                        <div>
                            <h4 class="font-bold">Michael Chen</h4>
                            <p class="text-gray-400 text-sm">Music Producer</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="glass-card rounded-2xl p-8 relative">
                    <div class="absolute -top-5 -left-5 text-5xl text-accent-pink opacity-20">"</div>
                    <div class="absolute -bottom-5 -right-5 text-5xl text-accent-pink opacity-20">"</div>
                    
                    <p class="text-gray-300 mb-8 relative z-10">I love how easy it is to create and share playlists with friends. MusicWave has become our go-to platform for parties. The user interface is so intuitive and visually appealing!</p>
                    
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-green to-teal-500 mr-4"></div>
                        <div>
                            <h4 class="font-bold">Alex Rodriguez</h4>
                            <p class="text-gray-400 text-sm">DJ & Enthusiast</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-20 bg-gradient-to-r from-dark-300 to-black relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="music-wave opacity-10 scale-[5] absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                <span class="h-20"></span>
                <span class="h-12"></span>
                <span class="h-32"></span>
                <span class="h-16"></span>
                <span class="h-28"></span>
                <span class="h-16"></span>
                <span class="h-24"></span>
            </div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Stay Tuned with the Latest Updates</h2>
                <p class="text-gray-300 text-lg mb-8">Subscribe to our newsletter to get weekly playlists, new release notifications, and exclusive content straight to your inbox.</p>
                
                <form class="flex flex-col md:flex-row gap-4 max-w-xl mx-auto">
                    <input type="email" placeholder="Your email address" class="flex-grow bg-dark-100 text-white rounded-full py-4 px-6 focus:outline-none focus:ring-2 focus:ring-accent-green">
                    <button type="submit" class="bg-gradient-to-r from-accent-green to-emerald-500 hover:from-accent-green hover:to-teal-500 text-white font-medium rounded-full px-8 py-4 transition-all shadow-lg hover:shadow-accent-green/20">
                        Subscribe
                    </button>
                </form>
                
                <p class="text-gray-500 text-sm mt-4">By subscribing, you agree to our Privacy Policy and consent to receive updates from MusicWave.</p>
                
                <div class="flex flex-wrap justify-center gap-8 mt-12">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-dark-100 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold">Weekly Updates</h4>
                            <p class="text-gray-400 text-sm">Fresh content every week</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-dark-100 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold">Exclusive Access</h4>
                            <p class="text-gray-400 text-sm">Early feature releases</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-dark-100 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold">Special Offers</h4>
                            <p class="text-gray-400 text-sm">Discounts for subscribers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-300 pt-16 pb-8 px-4">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="music-wave h-8 mr-2">
                            <span class="h-4"></span>
                            <span class="h-6"></span>
                            <span class="h-8"></span>
                            <span class="h-4"></span>
                            <span class="h-6"></span>
                        </div>
                        <h3 class="text-2xl font-bold">MusicWave</h3>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">Experience the future of music streaming with our cutting-edge platform designed for audiophiles and casual listeners alike.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-dark-100 flex items-center justify-center hover:bg-accent-green transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-dark-100 flex items-center justify-center hover:bg-accent-blue transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.695-4.219 2.391-1.266.705-1.668 1.944-1.008 3.049.588.96 1.56.912 2.52.336 3.48-1.128 1.92-3.24 2.52-4.8 1.32-1.44-1.2-2.16-3.36-1.44-4.8 1.56-2.4 4.8-2.4 6.72.72 1.92 1.92-1.2 4.8 1.2 6.72 3.36 1.92 4.8-1.2 6.72-3.36 1.92-4.8-1.2-1.2-3.36 1.2-4.8 3.36z" />
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-dark-100 flex items-center justify-center hover:bg-accent-pink transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.259-.012 3.668-.07 4.948-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-dark-100 flex items-center justify-center hover:bg-red-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Home</a></li>
                        <li><a href="library.html" class="text-gray-400 hover:text-accent-green transition-colors">Library</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Playlists</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">New Releases</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Charts</a></li>
                    </ul>
                </div>
                
                <!-- Company -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Press</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Support</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Community</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition-colors">Cookie Settings</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-500 text-sm mb-4 md:mb-0">&copy; 2023 MusicWave. All rights reserved.</p>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-500 text-sm">Language:</span>
                        <select class="bg-dark-100 text-gray-400 text-sm rounded-md px-2 py-1 border border-gray-700 focus:outline-none focus:ring-1 focus:ring-accent-green">
                            <option>English</option>
                            <option>Spanish</option>
                            <option>French</option>
                            <option>German</option>
                            <option>Japanese</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Include Profile Modal -->
    <?php include 'includes/profile-modal.php'; ?>
</body>
</html>