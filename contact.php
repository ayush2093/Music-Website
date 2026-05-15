<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - MusicWave</title>
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
        
        .glass-card {
            background: rgba(30, 30, 30, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .contact-form input, .contact-form textarea, .contact-form select {
            background-color: rgba(42, 42, 42, 0.8);
            color: white;
            border: 1px solid rgba(58, 58, 58, 0.5);
            transition: all 0.3s ease;
        }
        
        .contact-form input:focus, .contact-form textarea:focus, .contact-form select:focus {
            border-color: #1ed760;
            outline: none;
            box-shadow: 0 0 15px rgba(30, 215, 96, 0.3);
            transform: translateY(-2px);
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
        
        <!-- Content -->
        <div class="container mx-auto px-4 py-32 relative z-10">
            <div class="max-w-4xl mx-auto">
                <!-- Title with gradient text -->
                <div class="text-center mb-12">
                    <div class="flex items-center justify-center mb-4">
                        <div class="flex space-x-1 mr-3">
                            <div class="w-3 h-3 rounded-full bg-accent-green"></div>
                            <div class="w-3 h-3 rounded-full bg-accent-blue"></div>
                            <div class="w-3 h-3 rounded-full bg-accent-pink"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-400 tracking-wider uppercase">Get in touch</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">
                        Connect with <span class="relative">
                            <span class="relative z-10 bg-clip-text text-transparent bg-gradient-to-r from-accent-blue to-accent-green">MusicWave</span>
                            <span class="absolute -inset-1 bg-accent-blue/10 blur-xl"></span>
                        </span>
                    </h1>
                    <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                        We're here to help with any questions, feedback, or music suggestions you might have.
                    </p>
                </div>
                
                <div class="glass-card rounded-xl p-8 shadow-lg mb-12">
                    <?php
                    // Check if form was submitted and display success message
                    if (isset($_GET['success']) && $_GET['success'] == 1) {
                        echo '<div class="bg-accent-green bg-opacity-20 border border-accent-green text-accent-green px-6 py-4 rounded-lg mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Your message has been sent successfully! We\'ll get back to you soon.
                        </div>';
                    } else if (isset($_GET['error'])) {
                        $errorMsg = "An error occurred. Please try again.";
                        if ($_GET['error'] == 1) {
                            $errorMsg = "Please fill in all fields.";
                        } else if ($_GET['error'] == 2) {
                            $errorMsg = "Please enter a valid email address.";
                        }
                        
                        echo '<div class="bg-accent-pink bg-opacity-20 border border-accent-pink text-accent-pink px-6 py-4 rounded-lg mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            '.$errorMsg.'
                        </div>';
                    }
                    ?>
                    
                    <form action="submit_contact.php" method="POST" class="contact-form space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="block text-gray-300 font-medium">Your Name</label>
                                <input type="text" id="name" name="name" required 
                                    class="w-full px-4 py-3 rounded-lg focus:ring-2 focus:ring-accent-green">
                            </div>
                            
                            <div class="space-y-2">
                                <label for="email" class="block text-gray-300 font-medium">Email Address</label>
                                <input type="email" id="email" name="email" required 
                                    class="w-full px-4 py-3 rounded-lg focus:ring-2 focus:ring-accent-green">
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="subject" class="block text-gray-300 font-medium">Subject</label>
                            <select id="subject" name="subject" required 
                                class="w-full px-4 py-3 rounded-lg focus:ring-2 focus:ring-accent-green">
                                <option value="">Select a subject</option>
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="Feedback">Feedback</option>
                                <option value="Music Suggestion">Music Suggestion</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="message" class="block text-gray-300 font-medium">Your Message</label>
                            <textarea id="message" name="message" rows="6" required
                                class="w-full px-4 py-3 rounded-lg focus:ring-2 focus:ring-accent-green"></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" 
                                class="bg-gradient-to-r from-accent-green to-emerald-400 hover:from-emerald-400 hover:to-accent-green text-white font-medium rounded-full px-10 py-4 transition-all hover-scale shadow-lg hover:shadow-accent-green/30">
                                <div class="flex items-center">
                                    <span>Send Message</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div class="glass-card p-8 rounded-xl hover-scale">
                        <div class="inline-block p-4 rounded-full bg-dark-100 mb-4 neon-border">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Email Us</h3>
                        <p class="text-gray-400">support@musicwave.com</p>
                    </div>
                    
                    <div class="glass-card p-8 rounded-xl hover-scale">
                        <div class="inline-block p-4 rounded-full bg-dark-100 mb-4 neon-border">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Call Us</h3>
                        <p class="text-gray-400">+1 (555) 123-4567</p>
                    </div>
                    
                    <div class="glass-card p-8 rounded-xl hover-scale">
                        <div class="inline-block p-4 rounded-full bg-dark-100 mb-4 neon-border">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Location</h3>
                        <p class="text-gray-400">123 Music Street, Audio City</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html> 