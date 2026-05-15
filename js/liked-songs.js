document.addEventListener('DOMContentLoaded', function() {
    // DOM elements
    const likedSongsContainer = document.getElementById('liked-songs');
    const likedCountElement = document.getElementById('liked-count');
    const loadingSpinner = document.getElementById('loading-spinner');
    const emptyLikedMessage = document.getElementById('empty-liked');
    const playAllButton = document.getElementById('play-all-button');

    // Fetch user's liked songs from the server
    fetchLikedSongs();

    function fetchLikedSongs() {
        fetch('api/get_liked_songs.php')
            .then(response => response.json())
            .then(data => {
                // Hide loading spinner
                loadingSpinner.classList.add('hidden');
                
                if (data.success) {
                    const songs = data.songs;
                    
                    // Update liked count
                    likedCountElement.textContent = `${songs.length} songs`;
                    
                    if (songs.length === 0) {
                        // Show empty message if no liked songs
                        emptyLikedMessage.classList.remove('hidden');
                        playAllButton.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        // Render liked songs
                        renderLikedSongs(songs);
                        
                        // Enable play all button
                        playAllButton.addEventListener('click', () => playAllLikedSongs(songs));
                    }
                } else {
                    // Show error message
                    likedCountElement.textContent = 'Error loading songs';
                    console.error(data.message);
                }
            })
            .catch(error => {
                loadingSpinner.classList.add('hidden');
                likedCountElement.textContent = 'Error loading songs';
                console.error('Error fetching liked songs:', error);
            });
    }

    function renderLikedSongs(songs) {
        likedSongsContainer.innerHTML = '';
        
        songs.forEach((song, index) => {
            // Format duration
            const minutes = Math.floor(song.duration / 60);
            const seconds = song.duration % 60;
            const formattedDuration = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            
            // Format date
            const dateAdded = new Date(song.liked_at);
            const formattedDate = dateAdded.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            
            // Create song element
            const songElement = document.createElement('div');
            songElement.classList.add('flex', 'items-center', 'hover:bg-dark-100', 'rounded-md', 'p-2', 'group', 'transition-all');
            songElement.dataset.songId = song.id;
            
            songElement.innerHTML = `
                <div class="w-8 mr-4 text-gray-400 flex justify-center">${index + 1}</div>
                <div class="flex items-center flex-grow overflow-hidden">
                    <div class="w-12 h-12 mr-3 rounded-md overflow-hidden flex-shrink-0">
                        <img src="${song.cover}" alt="${song.title}" class="w-full h-full object-cover">
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-white truncate">${song.title}</p>
                        <p class="text-gray-400 text-sm truncate">${song.artist}</p>
                    </div>
                </div>
                <div class="w-1/5 px-4 hidden md:block">
                    <p class="text-gray-400 text-sm truncate">${song.album}</p>
                </div>
                <div class="w-1/6 hidden md:block">
                    <p class="text-gray-400 text-sm">${formattedDate}</p>
                </div>
                <div class="w-16 text-right text-gray-400 text-sm">${formattedDuration}</div>
                <div class="w-10 text-right">
                    <button class="unlike-button opacity-0 group-hover:opacity-100 text-gray-400 hover:text-white transition-opacity"
                            data-song-id="${song.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;
            
            likedSongsContainer.appendChild(songElement);
            
            // Add event listener to play song on click
            songElement.addEventListener('click', (e) => {
                // Don't play if clicked on unlike button
                if (!e.target.closest('.unlike-button')) {
                    playSong(song);
                }
            });
            
            // Add event listener to unlike button
            const unlikeButton = songElement.querySelector('.unlike-button');
            unlikeButton.addEventListener('click', (e) => {
                e.stopPropagation();
                unlikeSong(song.id, songElement);
            });
        });
    }

    function playSong(song) {
        // You can implement this to integrate with your music player
        console.log('Playing song:', song.title);
        
        // Send to parent window or localStorage for the player to pick up
        localStorage.setItem('currentSong', JSON.stringify(song));
        
        // Dispatch a custom event that the player can listen for
        const event = new CustomEvent('playSong', { detail: song });
        window.dispatchEvent(event);
    }

    function playAllLikedSongs(songs) {
        if (songs.length > 0) {
            // Store the playlist in localStorage
            localStorage.setItem('currentPlaylist', JSON.stringify(songs));
            
            // Play the first song
            playSong(songs[0]);
            
            // Dispatch a custom event for the player
            const event = new CustomEvent('playPlaylist', { detail: songs });
            window.dispatchEvent(event);
        }
    }

    function unlikeSong(songId, songElement) {
        // Send request to unlike the song
        const formData = new FormData();
        formData.append('song_id', songId);
        formData.append('action', 'remove');
        
        fetch('like_song.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove song from UI with animation
                songElement.style.opacity = '0';
                setTimeout(() => {
                    songElement.remove();
                    
                    // Update count
                    const currentCount = parseInt(likedCountElement.textContent);
                    const newCount = currentCount - 1;
                    likedCountElement.textContent = `${newCount} songs`;
                    
                    // Show empty message if no songs left
                    if (newCount === 0) {
                        emptyLikedMessage.classList.remove('hidden');
                        playAllButton.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }, 300);
            } else {
                console.error('Failed to unlike song:', data.message);
            }
        })
        .catch(error => {
            console.error('Error unliking song:', error);
        });
    }
}); 