// Music Player JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
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
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    // Audio Element
    const audio = new Audio();
    
    // Player State
    let isPlaying = false;
    let isShuffle = false;
    let isRepeat = false;
    let currentSongIndex = 0;
    
    // Get songs from musicData
    const playlist = musicData.songs.map(song => ({
        id: song.id,
        title: song.title,
        artist: song.artist,
        album: song.album,
        duration: song.duration,
        cover: song.cover,
        audio: song.audio,
        genre: song.genre
    }));
    
    // Initialize player
    function initPlayer() {
        // Check if there's a stored song index in localStorage (from library page)
        const storedIndex = localStorage.getItem('currentSongIndex');
        if (storedIndex !== null) {
            currentSongIndex = parseInt(storedIndex);
            // Clear the stored index after using it
            localStorage.removeItem('currentSongIndex');
        }
        
        loadSong(currentSongIndex);
        updateQueueUI();
        
        // Set up event listeners
        playButton.addEventListener('click', togglePlay);
        
        // Find the prev and next buttons in the player interface
        const prevButtonElement = document.querySelector('button:has(svg path[d*="M11 19l-7-7 7-7m8 14l-7-7 7-7"])');
        const nextButtonElement = document.querySelector('button:has(svg path[d*="M13 5l7 7-7 7M5 5l7 7-7 7"])');
        
        if (prevButtonElement) prevButtonElement.addEventListener('click', prevSong);
        if (nextButtonElement) nextButtonElement.addEventListener('click', nextSong);
        
        // Use the class selectors if available
        if (prevButton) prevButton.addEventListener('click', prevSong);
        if (nextButton) nextButton.addEventListener('click', nextSong);
        
        if (shuffleButton) shuffleButton.addEventListener('click', toggleShuffle);
        if (repeatButton) repeatButton.addEventListener('click', toggleRepeat);
        if (volumeSlider) volumeSlider.addEventListener('input', setVolume);
        
        // Progress bar events
        progressBar.addEventListener('click', seek);
        progressBarHandle.addEventListener('mousedown', startDrag);
        
        // Audio events
        audio.addEventListener('timeupdate', updateProgress);
        audio.addEventListener('ended', handleSongEnd);
        audio.addEventListener('canplay', updateTotalTime);
        
        // Mobile menu toggle
        mobileMenuButton.addEventListener('click', toggleMobileMenu);
    }
    
    // Load song
    function loadSong(index) {
        const song = playlist[index];
        audio.src = song.audio;
        // Set song ID as data attribute
        audio.setAttribute('data-song-id', song.id);
        audio.load();
        
        // Update UI
        document.querySelector('h1').textContent = song.title;
        document.querySelector('p.text-xl').textContent = song.artist;
        document.querySelector('p.text-gray-400').textContent = `Album: ${song.album}`;
        document.querySelector('.neon-border img').src = song.cover;
        
        // Reset progress
        progressBarFill.style.width = '0%';
        progressBarHandle.style.left = '0%';
        currentTimeEl.textContent = '0:00';
        
        // Highlight current song in queue
        const queueItems = document.querySelectorAll('.queue-item');
        queueItems.forEach((item, i) => {
            if (i === index) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
        
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
        isPlaying = true;
        audio.play();
        
        // Update UI
        playButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-dark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        `;
        
        // Show vinyl and start animation
        vinylRecord.style.opacity = '1';
        
        // Start visualizer animation
        startVisualizer();
    }
    
    // Pause song
    function pauseSong() {
        isPlaying = false;
        audio.pause();
        
        // Update UI
        playButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-dark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
            </svg>
        `;
        
        // Hide vinyl
        vinylRecord.style.opacity = '0';
        
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
        shuffleButton.classList.toggle('text-accent-green', isShuffle);
        shuffleButton.classList.toggle('text-gray-400', !isShuffle);
    }
    
    // Toggle repeat
    function toggleRepeat() {
        isRepeat = !isRepeat;
        repeatButton.classList.toggle('text-accent-green', isRepeat);
        repeatButton.classList.toggle('text-gray-400', !isRepeat);
    }
    
    // Set volume
    function setVolume() {
        audio.volume = volumeSlider.value / 100;
    }
    
    // Update progress bar
    function updateProgress() {
        const { currentTime, duration } = audio;
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
        totalTimeEl.textContent = formatTime(audio.duration);
    }
    
    // Format time in MM:SS
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }
    
    // Seek in the song
    function seek(e) {
        const progressBarWidth = progressBar.clientWidth;
        const clickPosition = e.offsetX;
        const seekTime = (clickPosition / progressBarWidth) * audio.duration;
        
        audio.currentTime = seekTime;
    }
    
    // Handle drag on progress bar
    function startDrag(e) {
        e.preventDefault();
        
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', stopDrag);
    }
    
    function drag(e) {
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
        audio.currentTime = (percent / 100) * audio.duration;
    }
    
    function stopDrag() {
        document.removeEventListener('mousemove', drag);
        document.removeEventListener('mouseup', stopDrag);
    }
    
    // Handle song end
    function handleSongEnd() {
        if (isRepeat) {
            audio.currentTime = 0;
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
    
    // Update queue UI
    function updateQueueUI() {
        const queueContainer = document.querySelector('.space-y-2');
        if (!queueContainer) return;
        
        queueContainer.innerHTML = '';
        
        playlist.forEach((song, index) => {
            const queueItem = document.createElement('div');
            queueItem.classList.add('queue-item', 'flex', 'items-center', 'p-3', 'rounded-xl');
            if (index === currentSongIndex) {
                queueItem.classList.add('active');
            }
            
            // Create a gradient background based on song genre
            let gradientClass = 'from-accent-pink to-accent-blue';
            if (song.genre === 'Electronic') gradientClass = 'from-blue-500 to-accent-green';
            if (song.genre === 'Lo-Fi') gradientClass = 'from-indigo-500 to-purple-600';
            if (song.genre === 'Synthwave') gradientClass = 'from-pink-500 to-purple-500';
            if (song.genre === 'Pop') gradientClass = 'from-yellow-400 to-orange-500';
            if (song.genre === 'Jazz') gradientClass = 'from-red-500 to-pink-600';
            if (song.genre === 'Hip Hop') gradientClass = 'from-blue-600 to-indigo-800';
            if (song.genre === 'Acoustic') gradientClass = 'from-green-500 to-teal-400';
            
            queueItem.innerHTML = `
                <div class="w-10 h-10 rounded bg-gradient-to-br ${gradientClass} mr-3 flex-shrink-0"></div>
                <div class="flex-grow min-w-0">
                    <h4 class="font-medium text-sm truncate">${song.title}</h4>
                    <p class="text-gray-400 text-xs truncate">${song.artist}</p>
                </div>
                <div class="text-xs text-gray-400 ml-3">${formatTime(song.duration)}</div>
            `;
            
            queueItem.addEventListener('click', () => {
                currentSongIndex = index;
                loadSong(currentSongIndex);
                playSong();
            });
            
            queueContainer.appendChild(queueItem);
        });
    }
    
    // Visualizer animation
    function startVisualizer() {
        if (!window.visualizerInterval) {
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
        }
    }
    
    // Toggle mobile menu
    function toggleMobileMenu() {
        mobileMenu.classList.toggle('hidden');
    }
    
    // Initialize the player
    initPlayer();
});