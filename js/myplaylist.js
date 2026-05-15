document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const playlistSongsContainer = document.getElementById('playlist-songs');
    const loadingSpinner = document.getElementById('loading-spinner');
    const emptyPlaylist = document.getElementById('empty-playlist');
    const playlistCount = document.getElementById('playlist-count');
    const playAllButton = document.getElementById('play-all-button');
    
    // Player State
    let playlistSongs = [];
    let currentSongIndex = 0;
    
    // Load user's playlist songs
    loadPlaylistSongs();
    
    // Play All button click handler
    playAllButton.addEventListener('click', function() {
        if (playlistSongs.length > 0) {
            // Set the first song as current
            currentSongIndex = 0;
            
            // Create global playlist for player.js to use
            window.playlist = playlistSongs;
            
            // Save to localStorage
            localStorage.setItem('currentSongIndex', 0);
            
            // Redirect to player page
            window.location.href = 'player.php';
        }
    });
    
    // Function to load playlist songs
    function loadPlaylistSongs() {
        const formData = new FormData();
        formData.append('action', 'list');
        
        // Show loading spinner
        loadingSpinner.classList.remove('hidden');
        emptyPlaylist.classList.add('hidden');
        playlistSongsContainer.innerHTML = '';
        
        fetch('add_to_myplaylist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Hide loading spinner
            loadingSpinner.classList.add('hidden');
            
            if (data.success && data.songs && data.songs.length > 0) {
                // Store songs in variable
                playlistSongs = data.songs.map(song => ({
                    id: song.id,
                    title: song.title,
                    artist: song.artist,
                    album: song.album,
                    duration: song.duration,
                    cover: song.cover,
                    audio: song.audio,
                    genre: song.genre
                }));
                
                // Update song count
                playlistCount.textContent = `${playlistSongs.length} song${playlistSongs.length > 1 ? 's' : ''} in your playlist`;
                
                // Render songs
                renderSongs(data.songs);
            } else {
                // Show empty playlist message
                emptyPlaylist.classList.remove('hidden');
                playlistCount.textContent = 'No songs in your playlist';
                
                // Disable Play All button
                playAllButton.disabled = true;
                playAllButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        })
        .catch(error => {
            console.error('Error loading playlist:', error);
            loadingSpinner.classList.add('hidden');
            playlistSongsContainer.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-500 mb-2">Failed to load your playlist</p>
                    <button id="retry-button" class="bg-dark-100 hover:bg-dark-200 text-white py-2 px-4 rounded">
                        Retry
                    </button>
                </div>
            `;
            
            // Add retry button event listener
            document.getElementById('retry-button').addEventListener('click', loadPlaylistSongs);
        });
    }
    
    // Function to render songs
    function renderSongs(songs) {
        let html = '';
        
        songs.forEach((song, index) => {
            // Format duration
            const minutes = Math.floor(song.duration / 60);
            const seconds = song.duration % 60;
            const formattedDuration = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            
            // Format date
            const addedDate = new Date(song.added_at);
            const formattedDate = addedDate.toLocaleDateString();
            
            html += `
                <div class="flex items-center bg-dark-200 hover:bg-dark-100 rounded-lg p-3 transition-colors relative group" data-song-id="${song.id}" data-index="${index}">
                    <div class="flex items-center min-w-0 flex-grow">
                        <!-- Track number or play button -->
                        <div class="w-8 h-8 mr-4 flex items-center justify-center">
                            <span class="text-gray-400 group-hover:hidden">${index + 1}</span>
                            <button class="play-song-btn hidden group-hover:block text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Album art -->
                        <div class="w-12 h-12 rounded bg-dark-300 overflow-hidden mr-3 flex-shrink-0">
                            <img src="${song.cover}" alt="${song.title}" class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Song info -->
                        <div class="min-w-0 flex-grow">
                            <h3 class="text-white font-medium text-sm truncate">${song.title}</h3>
                            <p class="text-gray-400 text-xs truncate">${song.artist}</p>
                        </div>
                    </div>
                    
                    <!-- Album name (hide on mobile) -->
                    <div class="hidden md:block w-1/5 px-4">
                        <p class="text-gray-400 text-sm truncate">${song.album}</p>
                    </div>
                    
                    <!-- Date added (hide on mobile) -->
                    <div class="hidden md:block w-1/6 text-gray-400 text-sm">
                        ${formattedDate}
                    </div>
                    
                    <!-- Duration -->
                    <div class="w-16 text-gray-400 text-sm text-right">
                        ${formattedDuration}
                    </div>
                    
                    <!-- Remove button -->
                    <button class="remove-song-btn ml-4 text-gray-500 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity" data-song-id="${song.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            `;
        });
        
        playlistSongsContainer.innerHTML = html;
        
        // Add event listeners to play buttons
        const playButtons = document.querySelectorAll('.play-song-btn');
        playButtons.forEach(button => {
            button.addEventListener('click', function() {
                const songItem = this.closest('[data-song-id]');
                const songId = songItem.getAttribute('data-song-id');
                const index = parseInt(songItem.getAttribute('data-index'));
                
                // Set current song index
                currentSongIndex = index;
                
                // Create global playlist for player.js to use
                window.playlist = playlistSongs;
                
                // Save to localStorage
                localStorage.setItem('currentSongIndex', index);
                
                // Redirect to player page
                window.location.href = 'player.php';
            });
        });
        
        // Add event listeners to remove buttons
        const removeButtons = document.querySelectorAll('.remove-song-btn');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const songId = this.getAttribute('data-song-id');
                removeSongFromPlaylist(songId);
            });
        });
    }
    
    // Function to remove song from playlist
    function removeSongFromPlaylist(songId) {
        const formData = new FormData();
        formData.append('song_id', songId);
        formData.append('action', 'remove');
        
        fetch('add_to_myplaylist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Song removed from playlist', 'success');
                
                // Reload playlist
                loadPlaylistSongs();
            } else {
                showNotification(data.message || 'Failed to remove song', 'error');
            }
        })
        .catch(error => {
            console.error('Error removing song:', error);
            showNotification('An error occurred', 'error');
        });
    }
    
    // Simple notification function
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