<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Navbar -->
<nav class="fixed top-0 w-full z-50 bg-dark-300 bg-opacity-95 backdrop-blur-md shadow-lg">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="music-wave h-6">
                    <span class="h-4"></span>
                    <span class="h-3"></span>
                    <span class="h-6"></span>
                    <span class="h-2"></span>
                    <span class="h-5"></span>
                </div>
                <a href="index.php" class="text-2xl font-bold text-white">MusicWave</a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="text-white hover:text-accent-green transition-colors">Home</a>
                <a href="library.php" class="text-white hover:text-accent-green transition-colors">Library</a>
                <a href="events.php" class="text-white hover:text-accent-green transition-colors">Events</a>
                <a href="mybookings.php" class="text-white hover:text-accent-green transition-colors">My Bookings</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                <a href="upload_song.php" class="text-white hover:text-accent-green transition-colors">Upload Song</a>
                <?php endif; ?>
                <a href="contact.php" class="text-white hover:text-accent-green transition-colors">Contact</a>
                <!-- <div class="relative">
                    <input type="text" placeholder="Search..." class="bg-dark-100 text-white rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-accent-green w-40 transition-all focus:w-52">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div> -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <button id="profileBtn" class="flex items-center space-x-2 text-white hover:text-accent-green transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </button>
                <?php else: ?>
                    <a href="signUpLogin/login.html" class="bg-accent-green hover:bg-opacity-80 text-white font-medium rounded-full px-5 py-2 transition-all">Sign In</a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden pt-4 pb-2 transition-all duration-300 ease-in-out">
            <a href="index.php" class="block py-2 text-white hover:text-accent-green">Home</a>
            <a href="library.php" class="block py-2 text-white hover:text-accent-green">Library</a>
            <a href="events.php" class="block py-2 text-white hover:text-accent-green">Events</a>
            <a href="mybookings.php" class="block py-2 text-white hover:text-accent-green">My Bookings</a>
            <a href="liked_songs.php" class="block py-2 text-white hover:text-accent-green">Liked Songs</a>
            <a href="myplaylist.php" class="block py-2 text-white hover:text-accent-green">Playlists</a>
            <?php if(isset($_SESSION['user_id'])): ?>
            <a href="upload_song.php" class="block py-2 text-white hover:text-accent-green">Upload Song</a>
            <?php endif; ?>
            <a href="contact.php" class="block py-2 text-white hover:text-accent-green">Contact</a>
            <div class="relative mt-2 mb-3">
                <input type="text" placeholder="Search..." class="w-full bg-dark-100 text-white rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-accent-green">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <?php if(isset($_SESSION['user_id'])): ?>
                <button id="mobile-profile-btn" class="flex items-center space-x-2 text-white hover:text-accent-green transition-colors py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </button>
            <?php else: ?>
                <a href="signUpLogin/login.html" class="block text-center bg-accent-green hover:bg-opacity-80 text-white font-medium rounded-full px-5 py-2 transition-all">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="glass-card rounded-xl p-8 max-w-md w-full mx-4 relative">
        <!-- Close button -->
        <button id="closeProfileModal" class="absolute top-4 right-4 text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="text-center mb-6">
                <div class="h-24 w-24 rounded-full bg-gradient-to-r from-accent-blue to-accent-green p-1 mx-auto">
                    <div class="h-full w-full rounded-full bg-dark-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold mt-4"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h3>
                <p class="text-gray-400"><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'User'); ?></p>
            </div>
            
            <div class="border-t border-gray-700 my-4"></div>
            
            <div class="space-y-3">
                <a href="mybookings.php" class="flex items-center py-3 px-4 hover:bg-dark-100 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-accent-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>My Bookings</span>
                </a>
                <a href="my_songs.php" class="flex items-center py-3 px-4 hover:bg-dark-100 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-accent-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                    <span>My Songs</span>
                </a>
                <a href="./signUpLogin/logout.php" class="flex items-center py-3 px-4 hover:bg-dark-100 rounded-lg transition-colors text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        <?php else: ?>
            <div class="text-center mb-6">
                <div class="h-24 w-24 rounded-full bg-gradient-to-r from-accent-blue to-accent-green p-1 mx-auto">
                    <div class="h-full w-full rounded-full bg-dark-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold mt-4">Guest User</h3>
                <p class="text-gray-400">Sign in to access your account</p>
            </div>
            
            <div class="space-y-4 mt-6">
                <a href="signUpLogin/login.html" class="block w-full bg-gradient-to-r from-accent-green to-emerald-400 hover:from-emerald-400 hover:to-accent-green text-white font-medium rounded-full px-6 py-3 text-center transition-all">
                    Sign In
                </a>
                <a href="signUpLogin/register.html" class="block w-full bg-dark-100 hover:bg-dark-200 text-white font-medium rounded-full px-6 py-3 text-center transition-all">
                    Create Account
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Navbar JavaScript -->
<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
    
    // Profile modal
    const profileModal = document.getElementById('profileModal');
    const profileBtn = document.getElementById('profileBtn');
    const mobileProfileBtn = document.getElementById('mobile-profile-btn');
    const closeProfileModal = document.getElementById('closeProfileModal');
    
    // Open modal when clicking profile button (desktop)
    if (profileBtn) {
        profileBtn.addEventListener('click', function() {
            profileModal.classList.remove('hidden');
        });
    }
    
    // Open modal when clicking profile button (mobile)
    if (mobileProfileBtn) {
        mobileProfileBtn.addEventListener('click', function() {
            profileModal.classList.remove('hidden');
            document.getElementById('mobile-menu').classList.add('hidden');
        });
    }
    
    // Close modal when clicking close button
    if (closeProfileModal) {
        closeProfileModal.addEventListener('click', function() {
            profileModal.classList.add('hidden');
        });
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === profileModal) {
            profileModal.classList.add('hidden');
        }
    });
</script>