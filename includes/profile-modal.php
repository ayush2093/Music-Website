<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-dark-300 rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-white">Profile</h2>
            <button id="closeProfileModal" class="text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="space-y-4">
            <?php if(isset($_SESSION['user_id'])): ?>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full bg-accent-green flex items-center justify-center">
                    <span class="text-2xl font-bold text-white"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h3>
                    <p class="text-gray-400"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                </div>
            </div>
            <div class="pt-4 border-t border-gray-700">
                <a href="signUpLogin/logout.php" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-medium rounded-full px-5 py-2 transition-all">Logout</a>
            </div>
            <?php else: ?>
            <div class="text-center py-4">
                <p class="text-white mb-4">You are not logged in</p>
                <a href="signUpLogin/login.html" class="block w-full text-center bg-accent-green hover:bg-opacity-80 text-white font-medium rounded-full px-5 py-2 transition-all">Sign In</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Profile Modal functionality
    document.addEventListener('DOMContentLoaded', function() {
        const profileBtn = document.getElementById('profileBtn');
        const mobileProfileBtn = document.getElementById('mobile-profile-btn');
        const profileModal = document.getElementById('profileModal');
        const closeProfileModal = document.getElementById('closeProfileModal');

        if (profileBtn) {
            profileBtn.addEventListener('click', () => {
                profileModal.classList.remove('hidden');
            });
        }

        if (mobileProfileBtn) {
            mobileProfileBtn.addEventListener('click', () => {
                profileModal.classList.remove('hidden');
            });
        }

        if (closeProfileModal) {
            closeProfileModal.addEventListener('click', () => {
                profileModal.classList.add('hidden');
            });
        }

        // Close modal when clicking outside
        if (profileModal) {
            profileModal.addEventListener('click', (e) => {
                if (e.target === profileModal) {
                    profileModal.classList.add('hidden');
                }
            });
        }
    });
</script> 