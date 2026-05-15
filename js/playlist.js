document.addEventListener('DOMContentLoaded', function() {
    // Get add to playlist buttons
    const playlistButtons = document.querySelectorAll('.playlist-button');
    
    // Add click event to all playlist buttons
    playlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get the current song ID
            const songId = getCurrentSongId();
            
            if (!songId) {
                console.error('No song ID found');
                showNotification('Please play a song first', 'error');
                return;
            }
            
            // Add directly to MyPlaylist (instead of showing the modal)
            addToMyPlaylist(songId);
        });
    });
    
    // Function to get current song ID - same as in like-song.js
    function getCurrentSongId() {
        // If using data attributes on the audio player
        const audioPlayer = document.getElementById('audio-player');
        if (audioPlayer && audioPlayer.getAttribute('data-song-id')) {
            return audioPlayer.getAttribute('data-song-id');
        }
        
        // Try to get from the active song in the queue
        const activeSong = document.querySelector('.queue-item.active');
        if (activeSong && activeSong.getAttribute('data-song-id')) {
            return activeSong.getAttribute('data-song-id');
        }
        
        // If you're storing current song info in a global variable
        if (typeof currentSongIndex !== 'undefined' && window.playlist) {
            return window.playlist[currentSongIndex].id;
        }
        
        return null;
    }
    
    // Add song directly to MyPlaylist
    function addToMyPlaylist(songId) {
        // First check if "My Playlist" exists, if not create it
        const formData = new FormData();
        formData.append('song_id', songId);
        formData.append('action', 'list');
        
        fetch('add_to_playlist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Check if "My Playlist" exists
                const myPlaylist = data.playlists.find(playlist => playlist.name === 'My Playlist');
                
                if (myPlaylist) {
                    // Add to existing My Playlist
                    addToPlaylist(songId, myPlaylist.id);
                } else {
                    // Create My Playlist and add song
                    createPlaylist('My Playlist', songId);
                }
            } else {
                showNotification('Error checking playlists', 'error');
            }
        })
        .catch(error => {
            console.error('Error checking playlists:', error);
            showNotification('An error occurred', 'error');
        });
    }
    
    // Show playlist modal
    function showPlaylistModal(songId) {
        // Create modal if it doesn't exist yet
        let playlistModal = document.getElementById('playlist-modal');
        
        if (!playlistModal) {
            playlistModal = document.createElement('div');
            playlistModal.id = 'playlist-modal';
            playlistModal.className = 'fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center';
            playlistModal.innerHTML = `
                <div class="bg-dark-300 rounded-lg p-6 max-w-md w-full mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold text-white">Add to Playlist</h2>
                        <button id="close-playlist-modal" class="text-gray-400 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div id="playlists-container" class="max-h-60 overflow-y-auto mb-4">
                        <p class="text-white text-center py-3">Loading playlists...</p>
                    </div>
                    
                    <div class="border-t border-gray-700 pt-4">
                        <p class="text-white mb-2">Create New Playlist</p>
                        <div class="flex">
                            <input type="text" id="new-playlist-name" class="flex-grow bg-dark-100 text-white rounded-l-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-accent-green" placeholder="Playlist name">
                            <button id="create-playlist-btn" class="bg-accent-green hover:bg-opacity-80 text-white font-medium rounded-r-md px-4 transition-all">Create</button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(playlistModal);
            
            // Add event listeners
            const closeButton = document.getElementById('close-playlist-modal');
            closeButton.addEventListener('click', () => {
                playlistModal.classList.add('hidden');
            });
            
            // Close when clicking outside
            playlistModal.addEventListener('click', (e) => {
                if (e.target === playlistModal) {
                    playlistModal.classList.add('hidden');
                }
            });
            
            // Create playlist button
            const createPlaylistBtn = document.getElementById('create-playlist-btn');
            createPlaylistBtn.addEventListener('click', () => {
                const playlistName = document.getElementById('new-playlist-name').value;
                createPlaylist(playlistName, songId);
            });
        }
        
        // Show modal
        playlistModal.classList.remove('hidden');
        
        // Load user playlists
        loadPlaylists(songId);
    }
    
    // Load user playlists
    function loadPlaylists(songId) {
        const formData = new FormData();
        formData.append('song_id', songId);
        formData.append('action', 'list');
        
        fetch('add_to_playlist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const playlistsContainer = document.getElementById('playlists-container');
            
            if (data.success && data.playlists && data.playlists.length > 0) {
                let html = '<ul class="space-y-2">';
                
                data.playlists.forEach(playlist => {
                    html += `
                        <li class="group">
                            <button 
                                class="add-to-playlist-btn w-full flex justify-between items-center bg-dark-200 hover:bg-dark-100 p-3 rounded transition-colors" 
                                data-playlist-id="${playlist.id}"
                            >
                                <span class="text-white">${playlist.name}</span>
                                <span class="text-accent-green opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>
                        </li>
                    `;
                });
                
                html += '</ul>';
                playlistsContainer.innerHTML = html;
                
                // Add event listeners to playlist buttons
                const addToPlaylistButtons = document.querySelectorAll('.add-to-playlist-btn');
                addToPlaylistButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const playlistId = button.getAttribute('data-playlist-id');
                        addToPlaylist(songId, playlistId);
                    });
                });
            } else {
                playlistsContainer.innerHTML = '<p class="text-white text-center py-3">No playlists found. Create a new one below.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading playlists:', error);
            const playlistsContainer = document.getElementById('playlists-container');
            playlistsContainer.innerHTML = '<p class="text-red-500 text-center py-3">Error loading playlists</p>';
        });
    }
    
    // Add song to playlist
    function addToPlaylist(songId, playlistId) {
        const formData = new FormData();
        formData.append('song_id', songId);
        formData.append('action', 'add');
        formData.append('playlist_id', playlistId);
        
        fetch('add_to_playlist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.action === 'added') {
                    showNotification('Song added to playlist', 'success');
                } else if (data.action === 'none') {
                    showNotification('Song already in playlist', 'info');
                }
                
                // Close modal
                const playlistModal = document.getElementById('playlist-modal');
                if (playlistModal) {
                    playlistModal.classList.add('hidden');
                }
            } else {
                showNotification(data.message || 'Failed to add song to playlist', 'error');
            }
        })
        .catch(error => {
            console.error('Error adding to playlist:', error);
            showNotification('An error occurred', 'error');
        });
    }
    
    // Create new playlist
    function createPlaylist(playlistName, songId) {
        if (!playlistName) {
            showNotification('Please enter a playlist name', 'warning');
            return;
        }
        
        const formData = new FormData();
        formData.append('song_id', songId);
        formData.append('action', 'create');
        formData.append('playlist_name', playlistName);
        
        fetch('add_to_playlist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Song added to ' + playlistName, 'success');
                
                // Clear input
                const playlistNameInput = document.getElementById('new-playlist-name');
                if (playlistNameInput) {
                    playlistNameInput.value = '';
                }
                
                // Reload playlists
                loadPlaylists(songId);
            } else {
                showNotification(data.message || 'Failed to create playlist', 'error');
            }
        })
        .catch(error => {
            console.error('Error creating playlist:', error);
            showNotification('An error occurred', 'error');
        });
    }
    
    // Simple notification function - reused from like-song.js
    function showNotification(message, type = 'info') {
        // Check if notification container exists, create if it doesn't
        let notificationContainer = document.getElementById('notification-container');
        if (!notificationContainer) {
            notificationContainer = document.createElement('div');
            notificationContainer.id = 'notification-container';
            notificationContainer.style.position = 'fixed';
            notificationContainer.style.bottom = '20px';
            notificationContainer.style.right = '20px';
            notificationContainer.style.zIndex = '9999';
            document.body.appendChild(notificationContainer);
        }
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.style.marginTop = '10px';
        notification.style.padding = '10px 15px';
        notification.style.borderRadius = '4px';
        notification.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
        notification.style.transition = 'all 0.3s ease';
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(20px)';
        
        // Set color based on type
        switch(type) {
            case 'success':
                notification.style.backgroundColor = '#1DB954';
                break;
            case 'error':
                notification.style.backgroundColor = '#FF5252';
                break;
            case 'warning':
                notification.style.backgroundColor = '#FFC107';
                break;
            default:
                notification.style.backgroundColor = '#2196F3';
        }
        
        notification.style.color = 'white';
        notification.textContent = message;
        
        // Add to container
        notificationContainer.appendChild(notification);
        
        // Trigger animation
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                notificationContainer.removeChild(notification);
            }, 300);
        }, 3000);
    }
}); 