document.addEventListener('DOMContentLoaded', function() {
    // Get like buttons
    const likeButtons = document.querySelectorAll('.like-button');
    
    // Add click event to all like buttons
    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get the current song ID from the data attribute
            const songId = getCurrentSongId();
            
            if (!songId) {
                console.error('No song ID found');
                showNotification('Please play a song first', 'error');
                return;
            }
            
            // Check if the button is already active
            const isActive = button.classList.contains('text-red-500');
            const action = isActive ? 'remove' : 'add';
            
            // Send request to like_song.php
            const formData = new FormData();
            formData.append('song_id', songId);
            formData.append('action', action);
            
            fetch('like_song.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI based on the action
                    if (data.action === 'added' || (action === 'add' && data.action !== 'none')) {
                        // Mark button as active
                        likeButtons.forEach(btn => {
                            btn.classList.remove('text-gray-400');
                            btn.classList.add('text-red-500');
                            // Change the SVG fill for better visualization
                            const svg = btn.querySelector('svg');
                            if (svg) {
                                svg.setAttribute('fill', 'currentColor');
                            }
                        });
                        showNotification('Song added to your liked songs', 'success');
                    } else if (data.action === 'removed') {
                        // Mark button as inactive
                        likeButtons.forEach(btn => {
                            btn.classList.remove('text-red-500');
                            btn.classList.add('text-gray-400');
                            // Reset the SVG fill
                            const svg = btn.querySelector('svg');
                            if (svg) {
                                svg.setAttribute('fill', 'none');
                            }
                        });
                        showNotification('Song removed from your liked songs', 'info');
                    }
                } else {
                    // Show error message
                    console.error('Error:', data.message);
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred', 'error');
            });
        });
    });
    
    // Function to get current song ID - modify this to match your app's structure
    function getCurrentSongId() {
        // If using data attributes on the audio player or a current song variable
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
    
    // Check if current song is liked when a new song plays
    function checkIfSongIsLiked(songId) {
        if (!songId) return;
        
        const formData = new FormData();
        formData.append('song_id', songId);
        formData.append('action', 'check');
        
        fetch('like_song.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI based on like status
                likeButtons.forEach(btn => {
                    if (data.liked) {
                        btn.classList.remove('text-gray-400');
                        btn.classList.add('text-red-500');
                        // Change the SVG fill
                        const svg = btn.querySelector('svg');
                        if (svg) {
                            svg.setAttribute('fill', 'currentColor');
                        }
                    } else {
                        btn.classList.remove('text-red-500');
                        btn.classList.add('text-gray-400');
                        // Reset the SVG fill
                        const svg = btn.querySelector('svg');
                        if (svg) {
                            svg.setAttribute('fill', 'none');
                        }
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error checking like status:', error);
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
    
    // Listen for song change events to update like button status
    document.addEventListener('songChanged', function(e) {
        const songId = e.detail.songId;
        checkIfSongIsLiked(songId);
    });
    
    // If you're using a custom function to play songs, you can integrate this
    // For example, add this to your loadSong or playSong function:
    // 
    // const songChangedEvent = new CustomEvent('songChanged', { 
    //   detail: { songId: song.id } 
    // });
    // document.dispatchEvent(songChangedEvent);
}); 