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

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

// Process only POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = escape($_POST['title']);
    $artist = escape($_POST['artist']);
    $album = escape($_POST['album'] ?? '');
    $genre = escape($_POST['genre']);
    $duration = isset($_POST['duration']) && !empty($_POST['duration']) ? (int)$_POST['duration'] : 0;
    $user_id = $_SESSION['user_id']; // Get current user's ID
    
    // Validate form data
    if (empty($title) || empty($artist) || empty($genre)) {
        $response['message'] = 'Please fill in all required fields';
    } else {
        // Handle audio file upload
        $audioFile = $_FILES['audio_file'];
        $coverFile = $_FILES['cover_image'];
        
        // Check if files were uploaded
        if ($audioFile['error'] === UPLOAD_ERR_OK && $coverFile['error'] === UPLOAD_ERR_OK) {
            // Create directory for artist if it doesn't exist
            $artistDir = 'Music/' . strtolower(str_replace(' ', '_', $artist));
            if (!file_exists($artistDir)) {
                if (!mkdir($artistDir, 0777, true)) {
                    $response['message'] = 'Error creating artist directory. Please check folder permissions.';
                    goto send_response;
                }
            }
            
            // Generate unique filenames
            $audioFileName = $artistDir . '/' . $title . ' - ' . $artist . '.' . pathinfo($audioFile['name'], PATHINFO_EXTENSION);
            
            // Create covers directory if it doesn't exist
            $coversDir = 'images/covers/';
            if (!file_exists($coversDir)) {
                if (!mkdir($coversDir, 0777, true)) {
                    $response['message'] = 'Error creating covers directory. Please check folder permissions.';
                    goto send_response;
                }
            }
            
            $coverFileName = $coversDir . $title . '_' . $artist . '.' . pathinfo($coverFile['name'], PATHINFO_EXTENSION);
            
            // Validate file types
            $allowedAudioTypes = ['audio/mpeg', 'audio/wav', 'audio/x-m4a', 'audio/mp3'];
            $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            
            if (!in_array($audioFile['type'], $allowedAudioTypes)) {
                $response['message'] = 'Invalid audio file type. Please upload MP3, WAV, or M4A files.';
                goto send_response;
            }
            
            if (!in_array($coverFile['type'], $allowedImageTypes)) {
                $response['message'] = 'Invalid cover image type. Please upload JPG, JPEG, or PNG files.';
                goto send_response;
            }
            
            // Check file sizes
            if ($audioFile['size'] > 20 * 1024 * 1024) { // 20MB max
                $response['message'] = 'Audio file is too large. Maximum size is 20MB.';
                goto send_response;
            }
            
            if ($coverFile['size'] > 5 * 1024 * 1024) { // 5MB max
                $response['message'] = 'Cover image is too large. Maximum size is 5MB.';
                goto send_response;
            }
            
            // Move uploaded files to their destinations
            if (move_uploaded_file($audioFile['tmp_name'], $audioFileName) && 
                move_uploaded_file($coverFile['tmp_name'], $coverFileName)) {
                
                // If duration is not provided, try to get it from the audio file
                if ($duration === 0) {
                    // Try to use getID3 library if available
                    if (file_exists('includes/getid3/getid3.php')) {
                        require_once('includes/getid3/getid3.php');
                        $getID3 = new getID3;
                        $fileInfo = $getID3->analyze($audioFileName);
                        if (isset($fileInfo['playtime_seconds'])) {
                            $duration = round($fileInfo['playtime_seconds']);
                        }
                    } else {
                        // Fallback: Set a default duration
                        $duration = 180; // 3 minutes default
                    }
                }
                
                // Insert song information into database with user_id
                $sql = "INSERT INTO songs (title, artist, album, duration, cover, audio, genre, created_at, user_id) 
                        VALUES ('$title', '$artist', '$album', $duration, '$coverFileName', '$audioFileName', '$genre', NOW(), $user_id)";
                
                if (query($sql)) {
                    $response['success'] = true;
                    $response['message'] = 'Song uploaded successfully!';
                    $response['redirect'] = 'my_songs.php';
                } else {
                    $response['message'] = 'Error inserting song into database';
                }
            } else {
                $response['message'] = 'Error moving uploaded files';
            }
        } else {
            // Determine specific upload error
            if ($audioFile['error'] !== UPLOAD_ERR_OK) {
                $response['message'] = getUploadErrorMessage($audioFile['error'], 'audio file');
            } else {
                $response['message'] = getUploadErrorMessage($coverFile['error'], 'cover image');
            }
        }
    }
    
    // Label for error handling
    send_response:
    
    // Return JSON response for AJAX requests
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    // For non-AJAX requests, redirect with message
    if ($response['success'] && !empty($response['redirect'])) {
        header('Location: ' . $response['redirect']);
    } else {
        // Redirect back to upload form with error
        header('Location: upload_song.php?error=' . urlencode($response['message']));
    }
    exit;
}

// Helper function to get upload error messages
function getUploadErrorMessage($errorCode, $fileType) {
    switch ($errorCode) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            return "The $fileType is too large.";
        case UPLOAD_ERR_PARTIAL:
            return "The $fileType was only partially uploaded.";
        case UPLOAD_ERR_NO_FILE:
            return "No $fileType was uploaded.";
        case UPLOAD_ERR_NO_TMP_DIR:
            return "Missing temporary folder for $fileType.";
        case UPLOAD_ERR_CANT_WRITE:
            return "Failed to write $fileType to disk.";
        case UPLOAD_ERR_EXTENSION:
            return "A PHP extension stopped the $fileType upload.";
        default:
            return "Unknown error uploading $fileType.";
    }
}

// If not a POST request, redirect to upload form
header('Location: upload_song.php');
exit;
?>
