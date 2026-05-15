document.addEventListener('DOMContentLoaded', function() {
    // Get all playlist buttons
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
            
            // Add directly to MyPlaylist
            addToMyPlaylist(songId);
        });
    });
    
    // Function to get current song ID
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
        const formData = new FormData();
        formData.append('song_id', songId);
        formData.append('action', 'add');
        
        fetch('add_to_myplaylist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.action === 'added') {
                    showNotification('Song added to My Playlist', 'success');
                    
                    // Change button color to indicate the song is in playlist
                    updateButtonStyle(true);
                } else if (data.action === 'none') {
                    showNotification('Song already in My Playlist', 'info');
                }
            } else {
                showNotification(data.message || 'Failed to add song to My Playlist', 'error');
            }
        })
        .catch(error => {
            console.error('Error adding to My Playlist:', error);
            showNotification('An error occurred', 'error');
        });
    }
    
    // Update the button style based on whether the song is in the playlist
    function updateButtonStyle(isInPlaylist) {
        playlistButtons.forEach(button => {
            if (isInPlaylist) {
                button.classList.remove('text-gray-400');
                button.classList.add('text-accent-green');
            } else {
                button.classList.remove('text-accent-green');
                button.classList.add('text-gray-400');
            }
        });
    }
    
    // Check if current song is in MyPlaylist when it changes
    document.addEventListener('songChanged', function(e) {
        const songId = e.detail.songId;
        checkIfSongInPlaylist(songId);
    });
    
    // Check if a song is in the user's MyPlaylist
    function checkIfSongInPlaylist(songId) {
        if (!songId) return;
        
        const formData = new FormData();
        formData.append('song_id', songId);
        formData.append('action', 'check');
        
        fetch('add_to_myplaylist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateButtonStyle(data.inPlaylist);
            }
        })
        .catch(error => {
            console.error('Error checking playlist status:', error);
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
    
    // Check status of current song on page load
    const initialSongId = getCurrentSongId();
    if (initialSongId) {
        checkIfSongInPlaylist(initialSongId);
    }
}); 