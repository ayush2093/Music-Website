<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: signUpLogin/login.html');
    exit;
}

// Include database connection
include 'includes/db_connect.php';

$message = '';
$messageType = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = escape($_POST['title']);
    $artist = escape($_POST['artist']);
    $album = escape($_POST['album']);
    $genre = escape($_POST['genre']);
    $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 0;
    
    // Validate form data
    if (empty($title) || empty($artist) || empty($genre)) {
        $message = 'Please fill in all required fields';
        $messageType = 'error';
    } else {
        // Handle audio file upload
        $audioFile = $_FILES['audio_file'];
        $coverFile = $_FILES['cover_image'];
        
        // Check if files were uploaded
        if ($audioFile['error'] === UPLOAD_ERR_OK && $coverFile['error'] === UPLOAD_ERR_OK) {
            // Create directory for artist if it doesn't exist
            $artistDir = 'Music/' . strtolower(str_replace(' ', '_', $artist));
            if (!file_exists($artistDir)) {
                mkdir($artistDir, 0777, true);
            }
            
            // Generate unique filenames
            $audioFileName = $artistDir . '/' . $title . ' - ' . $artist . '.' . pathinfo($audioFile['name'], PATHINFO_EXTENSION);
            
            // Create covers directory if it doesn't exist
            $coversDir = 'images/covers/';
            if (!file_exists($coversDir)) {
                mkdir($coversDir, 0777, true);
            }
            
            $coverFileName = $coversDir . $title . '_' . $artist . '.' . pathinfo($coverFile['name'], PATHINFO_EXTENSION);
            
            // Move uploaded files to their destinations
            if (move_uploaded_file($audioFile['tmp_name'], $audioFileName) && 
                move_uploaded_file($coverFile['tmp_name'], $coverFileName)) {
                
                // Insert song information into database
                $sql = "INSERT INTO songs (title, artist, album, duration, cover, audio, genre, created_at) 
                        VALUES ('$title', '$artist', '$album', $duration, '$coverFileName', '$audioFileName', '$genre', NOW())";
                
                if (query($sql)) {
                    $message = 'Song uploaded successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error inserting song into database';
                    $messageType = 'error';
                }
            } else {
                $message = 'Error moving uploaded files';
                $messageType = 'error';
            }
        } else {
            $message = 'Error uploading files';
            $messageType = 'error';
        }
    }
} else if (isset($_GET['error']) && !empty($_GET['error'])) {
    // Display error message from redirect
    $message = $_GET['error'];
    $messageType = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicWave - Upload Song</title>
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
                        },
                        accent: {
                            green: '#1DB954',
                            pink: '#E91E63',
                            blue: '#00BFFF',
                        }
                    },
                }
            }
        }
    </script>
    
    <!-- Link to our CSS file -->
    <link rel="stylesheet" href="css/styles.css">
    
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #121212;
            color: white;
        }
        
        .glass-card {
            background: rgba(30, 30, 30, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .neon-border {
            box-shadow: 0 0 5px #1DB954, 0 0 10px rgba(29, 185, 84, 0.3);
        }
        
        .file-input-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed rgba(255, 255, 255, 0.2);
            border-radius: 0.5rem;
            padding: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-input-label:hover {
            border-color: #1DB954;
            background-color: rgba(29, 185, 84, 0.05);
        }
        
        .file-input {
            display: none;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Include Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Upload Song Header -->
    <section class="pt-24 pb-6 md:pt-32 px-4">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Upload Song</h1>
                    <p class="text-gray-400">Share your music with the MusicWave community</p>
                </div>
            </div>
            
            <!-- Message Display -->
            <?php if (!empty($message)): ?>
                <div class="mb-6 p-4 rounded-lg <?php echo $messageType === 'success' ? 'bg-green-800/50' : 'bg-red-800/50'; ?>">
                    <p class="<?php echo $messageType === 'success' ? 'text-green-200' : 'text-red-200'; ?>">
                        <?php echo $message; ?>
                    </p>
                </div>
            <?php endif; ?>
            
            <!-- Upload Form -->
            <div class="glass-card rounded-xl p-6 md:p-8 mb-12">
                <form action="process_upload.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Song Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Song Title *</label>
                            <input type="text" id="title" name="title" required 
                                class="w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-accent-green">
                        </div>
                        
                        <!-- Artist -->
                        <div>
                            <label for="artist" class="block text-sm font-medium text-gray-300 mb-2">Artist *</label>
                            <input type="text" id="artist" name="artist" required 
                                class="w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-accent-green">
                        </div>
                        
                        <!-- Album -->
                        <div>
                            <label for="album" class="block text-sm font-medium text-gray-300 mb-2">Album</label>
                            <input type="text" id="album" name="album" 
                                class="w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-accent-green">
                        </div>
                        
                        <!-- Genre -->
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-300 mb-2">Genre *</label>
                            <select id="genre" name="genre" required 
                                class="w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-accent-green">
                                <option value="">Select Genre</option>
                                <option value="Pop">Pop</option>
                                <option value="Rock">Rock</option>
                                <option value="Hip Hop">Hip Hop</option>
                                <option value="R&B">R&B</option>
                                <option value="Electronic">Electronic</option>
                                <option value="Jazz">Jazz</option>
                                <option value="Classical">Classical</option>
                                <option value="Country">Country</option>
                                <option value="Folk">Folk</option>
                                <option value="Indie">Indie</option>
                                <option value="Metal">Metal</option>
                                <option value="Blues">Blues</option>
                                <option value="Reggae">Reggae</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-300 mb-2">Duration (seconds)</label>
                            <input type="number" id="duration" name="duration" min="1" 
                                class="w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-accent-green">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Audio File Upload -->
                        <div>
                            <label for="audio_file" class="block text-sm font-medium text-gray-300 mb-2">Audio File *</label>
                            <label for="audio_file" class="file-input-label">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                <span class="text-gray-300 mb-1">Click to upload audio file</span>
                                <span class="text-gray-500 text-sm">MP3, WAV, M4A (Max 20MB)</span>
                                <input type="file" id="audio_file" name="audio_file" accept=".mp3,.wav,.m4a" required class="file-input">
                            </label>
                            <div id="audio_file_name" class="mt-2 text-sm text-gray-400"></div>
                        </div>
                        
                        <!-- Cover Image Upload -->
                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-gray-300 mb-2">Cover Image *</label>
                            <label for="cover_image" class="file-input-label">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-300 mb-1">Click to upload cover image</span>
                                <span class="text-gray-500 text-sm">JPG, PNG, JPEG (Max 5MB)</span>
                                <input type="file" id="cover_image" name="cover_image" accept=".jpg,.jpeg,.png" required class="file-input">
                            </label>
                            <div id="cover_image_name" class="mt-2 text-sm text-gray-400"></div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-center mt-8">
                        <button type="submit" class="bg-accent-green hover:bg-opacity-80 text-white font-medium rounded-full px-8 py-3 transition-all">
                            Upload Song
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Include Profile Modal -->
    <?php include 'includes/profile-modal.php'; ?>
    
    <!-- Scripts -->
    <script>
        // Display selected file names
        document.getElementById('audio_file').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No file selected';
            document.getElementById('audio_file_name').textContent = 'Selected: ' + fileName;
        });
        
        document.getElementById('cover_image').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No file selected';
            document.getElementById('cover_image_name').textContent = 'Selected: ' + fileName;
        });
    </script>
</body>
</html>