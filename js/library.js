// Library Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const trackContainer = document.querySelector('.track-container');
    const filterButtons = document.querySelectorAll('.filter-button');
    const searchInput = document.querySelector('input[placeholder="Search..."]');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    // Player DOM Elements
    const playButton = document.getElementById('play-button');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    const shuffleButton = document.querySelector('.shuffle-button');
    const repeatButton = document.querySelector('.repeat-button');
    const progressBar = document.querySelector('.progress-bar');
    const progressBarFill = document.querySelector('.progress-bar-fill');
    const progressBarHandle = document.querySelector('.progress-bar-handle');
    const currentTimeEl = document.getElementById('current-time');
    const totalTimeEl = document.getElementById('total-time');
    const volumeSlider = document.querySelector('.volume-slider');
    const vinylRecord = document.getElementById('vinyl-record');
    const visualizerBars = document.querySelectorAll('.visualizer-bar');
    const playerTitle = document.getElementById('player-title');
    const playerArtist = document.getElementById('player-artist');
    const playerCover = document.getElementById('player-cover');
    const audioPlayer = document.getElementById('audio-player');
    
    // Player State
    let isPlaying = false;
    let isShuffle = false;
    let isRepeat = false;
    let currentSongIndex = 0;
    let playlist = [];
    
    // Initialize library
    function initLibrary() {
        // Set playlist to all songs
        playlist = musicData.songs;
        
        // Display all songs initially
        displaySongs(musicData.songs);
        
        // Set up event listeners
        filterButtons.forEach(button => {
            button.addEventListener('click', handleFilterClick);
        });
        
        if (searchInput) {
            searchInput.addEventListener('input', handleSearch);
        }
        
        // Mobile menu toggle
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', toggleMobileMenu);
        }
        
        // Player event listeners
        initPlayer();
    }
    
    // Display songs in the track container
    function displaySongs(songs) {
        if (!trackContainer) return;
        
        trackContainer.innerHTML = '';
        
        songs.forEach(song => {
            const trackCard = document.createElement('div');
            trackCard.classList.add('track-card', 'bg-dark-200', 'rounded-xl', 'overflow-hidden', 'hover-scale');
            
            // Create a gradient background based on artist
            let gradientClass = 'from-accent-pink to-accent-blue';
            if (song.artist === 'Ed Sheeran') gradientClass = 'from-blue-500 to-accent-green';
            if (song.artist === 'Arijit Singh') gradientClass = 'from-indigo-500 to-purple-600';
            if (song.artist === 'Atif Aslam') gradientClass = 'from-pink-500 to-purple-500';
            if (song.artist === 'King') gradientClass = 'from-yellow-400 to-orange-500';
            
            trackCard.innerHTML = `
                <div class="relative">
                    <img src="${song.cover}" alt="${song.title}" class="w-full aspect-square object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <button class="play-button absolute bottom-4 right-4 bg-accent-green rounded-full p-3 shadow-lg hover:bg-opacity-80 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium truncate">${song.title}</h3>
                        <span class="text-xs text-gray-400">${formatTime(song.duration)}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-400 truncate">${song.artist}</p>
                        <span class="text-xs px-2 py-1 rounded-full bg-dark-100 text-gray-300">${song.genre}</span>
                    </div>
                </div>
            `;
            
            // Add event listener to play button
            const playButton = trackCard.querySelector('.play-button');
            playButton.addEventListener('click', () => {
                // Find the index of this song in the current playlist
                const songIndex = playlist.findIndex(s => s.id === song.id);
                if (songIndex !== -1) {
                    currentSongIndex = songIndex;
                    loadSong(currentSongIndex);
                    playSong();
                }
            });
            
            trackContainer.appendChild(trackCard);
        });
    }
    
    // Handle filter button click
    function handleFilterClick(e) {
        // Remove active class from all buttons
        filterButtons.forEach(button => {
            button.classList.remove('active');
        });
        
        // Add active class to clicked button
        e.target.classList.add('active');
        
        const selectedArtist = e.target.textContent.trim();
        
        // Filter songs by artist
        if (selectedArtist === 'All Artists') {
            playlist = musicData.songs;
            displaySongs(playlist);
        } else {
            playlist = musicData.songs.filter(song => song.artist === selectedArtist);
            displaySongs(playlist);
        }
    }
    
    // Handle search input
    function handleSearch(e) {
        const searchTerm = e.target.value.toLowerCase();
        
        if (searchTerm === '') {
            // If search is empty, show all songs or respect current artist filter
            const activeFilter = document.querySelector('.filter-button.active');
            const selectedArtist = activeFilter ? activeFilter.textContent.trim() : 'All Artists';
            
            if (selectedArtist === 'All Artists') {
                playlist = musicData.songs;
                displaySongs(playlist);
            } else {
                playlist = musicData.songs.filter(song => song.artist === selectedArtist);
                displaySongs(playlist);
            }
        } else {
            // Filter songs by search term (title, artist, or album)
            playlist = musicData.songs.filter(song => 
                song.title.toLowerCase().includes(searchTerm) ||
                song.artist.toLowerCase().includes(searchTerm) ||
                song.album.toLowerCase().includes(searchTerm)
            );
            
            displaySongs(playlist);
        }
    }
    
    // Player Functions
    
    // Initialize player
    function initPlayer() {
        if (!playButton) return;
        
        // Set up event listeners
        playButton.addEventListener('click', togglePlay);
        
        if (prevButton) prevButton.addEventListener('click', prevSong);
        if (nextButton) nextButton.addEventListener('click', nextSong);
        if (shuffleButton) shuffleButton.addEventListener('click', toggleShuffle);
        if (repeatButton) repeatButton.addEventListener('click', toggleRepeat);
        if (volumeSlider) volumeSlider.addEventListener('input', setVolume);
        
        // Progress bar events
        if (progressBar) {
            progressBar.addEventListener('click', seek);
            
            if (progressBarHandle) {
                progressBarHandle.addEventListener('mousedown', startDrag);
            }
        }
        
        // Audio events
        if (audioPlayer) {
            audioPlayer.addEventListener('timeupdate', updateProgress);
            audioPlayer.addEventListener('ended', handleSongEnd);
            audioPlayer.addEventListener('canplay', updateTotalTime);
            
            // Set initial volume
            if (volumeSlider) {
                audioPlayer.volume = volumeSlider.value / 100;
            }
        }
    }
    
    // Load song
    function loadSong(index) {
        if (!audioPlayer || !playerTitle || !playerArtist || !playerCover || !playlist[index]) return;
        
        const song = playlist[index];
        audioPlayer.src = song.audio;
        // Set song ID as data attribute
        audioPlayer.setAttribute('data-song-id', song.id);
        audioPlayer.load();
        
        // Update UI
        playerTitle.textContent = song.title;
        playerArtist.textContent = song.artist;
        playerCover.src = song.cover;
        
        // Reset progress
        if (progressBarFill) progressBarFill.style.width = '0%';
        if (progressBarHandle) progressBarHandle.style.left = '0%';
        if (currentTimeEl) currentTimeEl.textContent = '0:00';
        
        // Dispatch song changed event for the like button
        const songChangedEvent = new CustomEvent('songChanged', { 
            detail: { songId: song.id } 
        });
        document.dispatchEvent(songChangedEvent);
    }
    
    // Toggle play/pause
    function togglePlay() {
        if (isPlaying) {
            pauseSong();
        } else {
            playSong();
        }
    }
    
    // Play song
    function playSong() {
        if (!audioPlayer) return;
        
        isPlaying = true;
        audioPlayer.play();
        
        // Update UI
        if (playButton) {
            playButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-dark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            `;
        }
        
        // Show vinyl and start animation
        if (vinylRecord) vinylRecord.style.opacity = '1';
        
        // Start visualizer animation
        startVisualizer();
    }
    
    // Pause song
    function pauseSong() {
        if (!audioPlayer) return;
        
        isPlaying = false;
        audioPlayer.pause();
        
        // Update UI
        if (playButton) {
            playButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-dark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                </svg>
            `;
        }
        
        // Hide vinyl
        if (vinylRecord) vinylRecord.style.opacity = '0';
        
        // Stop visualizer animation
        stopVisualizer();
    }
    
    // Previous song
    function prevSong() {
        currentSongIndex--;
        if (currentSongIndex < 0) {
            currentSongIndex = playlist.length - 1;
        }
        loadSong(currentSongIndex);
        if (isPlaying) {
            playSong();
        }
    }
    
    // Next song
    function nextSong() {
        currentSongIndex++;
        if (currentSongIndex >= playlist.length) {
            currentSongIndex = 0;
        }
        loadSong(currentSongIndex);
        if (isPlaying) {
            playSong();
        }
    }
    
    // Toggle shuffle
    function toggleShuffle() {
        isShuffle = !isShuffle;
        if (shuffleButton) {
            shuffleButton.classList.toggle('text-accent-green', isShuffle);
            shuffleButton.classList.toggle('text-gray-400', !isShuffle);
        }
    }
    
    // Toggle repeat
    function toggleRepeat() {
        isRepeat = !isRepeat;
        if (repeatButton) {
            repeatButton.classList.toggle('text-accent-green', isRepeat);
            repeatButton.classList.toggle('text-gray-400', !isRepeat);
        }
    }
    
    // Set volume
    function setVolume() {
        if (!audioPlayer || !volumeSlider) return;
        audioPlayer.volume = volumeSlider.value / 100;
    }
    
    // Update progress bar
    function updateProgress() {
        if (!audioPlayer || !progressBarFill || !progressBarHandle || !currentTimeEl) return;
        
        const { currentTime, duration } = audioPlayer;
        if (duration) {
            const progressPercent = (currentTime / duration) * 100;
            progressBarFill.style.width = `${progressPercent}%`;
            progressBarHandle.style.left = `${progressPercent}%`;
            
            // Update current time display
            currentTimeEl.textContent = formatTime(currentTime);
        }
    }
    
    // Update total time display
    function updateTotalTime() {
        if (!audioPlayer || !totalTimeEl) return;
        totalTimeEl.textContent = formatTime(audioPlayer.duration);
    }
    
    // Format time in MM:SS
    function formatTime(seconds) {
        if (!seconds) return '0:00';
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }
    
    // Seek in the song
    function seek(e) {
        if (!audioPlayer || !progressBar) return;
        
        const progressBarWidth = progressBar.clientWidth;
        const clickPosition = e.offsetX;
        const seekTime = (clickPosition / progressBarWidth) * audioPlayer.duration;
        
        audioPlayer.currentTime = seekTime;
    }
    
    // Handle drag on progress bar
    function startDrag(e) {
        e.preventDefault();
        
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', stopDrag);
    }
    
    function drag(e) {
        if (!audioPlayer || !progressBar || !progressBarFill || !progressBarHandle) return;
        
        const progressBarRect = progressBar.getBoundingClientRect();
        const clickPosition = e.clientX - progressBarRect.left;
        const progressBarWidth = progressBarRect.width;
        
        // Calculate percentage
        let percent = (clickPosition / progressBarWidth) * 100;
        percent = Math.max(0, Math.min(100, percent));
        
        // Update UI
        progressBarFill.style.width = `${percent}%`;
        progressBarHandle.style.left = `${percent}%`;
        
        // Update audio time
        audioPlayer.currentTime = (percent / 100) * audioPlayer.duration;
    }
    
    function stopDrag() {
        document.removeEventListener('mousemove', drag);
        document.removeEventListener('mouseup', stopDrag);
    }
    
    // Handle song end
    function handleSongEnd() {
        if (isRepeat) {
            audioPlayer.currentTime = 0;
            playSong();
        } else if (isShuffle) {
            const randomIndex = Math.floor(Math.random() * playlist.length);
            currentSongIndex = randomIndex;
            loadSong(currentSongIndex);
            playSong();
        } else {
            nextSong();
        }
    }
    
    // Visualizer animation
    function startVisualizer() {
        if (!window.visualizerInterval && visualizerBars.length > 0) {
            window.visualizerInterval = setInterval(() => {
                visualizerBars.forEach(bar => {
                    // Create more dynamic heights based on audio frequency (simulated here)
                    const height = Math.floor(Math.random() * 40) + 5;
                    bar.style.height = `${height}px`;
                    
                    // Add color transitions
                    const hue = Math.floor(Math.random() * 60) + 120; // Green to blue range
                    bar.style.background = `linear-gradient(to top, #1DB954, hsl(${hue}, 100%, 50%))`;
                });
            }, 100);
        }
    }
    
    function stopVisualizer() {
        if (window.visualizerInterval) {
            clearInterval(window.visualizerInterval);
            window.visualizerInterval = null;
            
            // Reset visualizer bars
            if (visualizerBars.length > 0) {
                visualizerBars.forEach(bar => {
                    bar.style.height = '1px';
                    bar.style.background = '#1DB954';
                });
            }
        }
    }
    
    // Toggle mobile menu
    function toggleMobileMenu() {
        if (mobileMenu) {
            mobileMenu.classList.toggle('hidden');
        }
    }
    
    // Initialize the library
    initLibrary();
});