-- SQL Script to create songs table

-- Create songs table
CREATE TABLE IF NOT EXISTS songs (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  artist VARCHAR(255) NOT NULL,
  album VARCHAR(255) NOT NULL,
  duration INT NOT NULL,
  cover VARCHAR(512) NOT NULL,
  audio VARCHAR(512) NOT NULL,
  genre VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data based on the js/data.js file
INSERT INTO songs (id, title, artist, album, duration, cover, audio, genre) VALUES
(1, '2step (feat. Armaan Malik)', 'Ed Sheeran', 'Ed Sheeran Collection', 180, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLNBs9mZD0rol54lZELj4QqDLtsr3VaCkSEQ&s', 'Music/ad sheeran/2step (feat. Armaan Malik) - Ed Sheeran 320 Kbps.mp3', 'Pop'),
(2, 'Azizam (Looper Performance Live from Old Delhi)', 'Ed Sheeran', 'Live Performances', 210, 'https://i.ytimg.com/vi/lNPJBHUePl0/maxresdefault.jpg', 'Music/ad sheeran/Ed Sheeran - Azizam (Looper Performance Live from Old Delhi) [lNPJBHUePl0].mp3', 'Pop'),
(3, 'Perfect (Official Music Video)', 'Ed Sheeran', '÷ (Divide)', 263, 'https://i.scdn.co/image/ab67616d0000b273ba5db46f4b838ef6027e6f96', 'Music/ad sheeran/Ed Sheeran - Perfect (Official Music Video).m4a', 'Pop'),
(4, 'Photograph', 'Ed Sheeran', 'x (Multiply)', 258, 'https://i.scdn.co/image/ab67616d0000b273407981084d79d283e24d428e', 'Music/ad sheeran/Ed Sheeran - Photograph (Lyrics) [HpphFd_mzXE].mp3', 'Pop'),
(5, 'Shape Of You (Deazy Remix)', 'Ed Sheeran', '÷ (Divide) Remixes', 233, 'https://a10.gaanacdn.com/gn_img/albums/0wrb4qNKLg/wrb4dDxLbL/size_m.webp', 'Music/ad sheeran/Shape Of You (Deazy Remix) by Ed Sheeran - Free Download on Hypeddit.mp3', 'Pop'),
(6, 'Aabaad Barbaad', 'Arijit Singh', 'Bollywood Hits', 240, 'https://i1.sndcdn.com/artworks-EVWUKXuBQxPV6vuD-lLe3yA-t500x500.jpg', 'Music/arijit singh/Aabaad Barbaad 320 Kbps.mp3', 'Bollywood'),
(7, 'Aasan Nahin Yahan', 'Arijit Singh', 'Aashiqui 2', 225, 'https://images.genius.com/e93872dbce13cdc830a2c143b6e232a3.1000x1000x1.png', 'Music/arijit singh/Aasan Nahin Yahan Aashiqui 2 320 Kbps.mp3', 'Bollywood'),
(8, 'Chahun Main Ya Naa', 'Arijit Singh', 'Aashiqui 2', 230, 'https://i1.sndcdn.com/artworks-000076159876-tp39te-t500x500.jpg', 'Music/arijit singh/Chahun Main Ya Naa Aashiqui 2 320 Kbps.mp3', 'Bollywood'),
(9, 'Hardum Humdum', 'Arijit Singh', 'Bollywood Hits', 215, 'https://c.saavncdn.com/249/Hardum-Humdum-From-Ludo--Hindi-2020-20201031121001-500x500.jpg', 'Music/arijit singh/Hardum Humdum 320 Kbps.mp3', 'Bollywood'),
(10, 'Tum Hi Ho', 'Arijit Singh', 'Aashiqui 2', 245, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRelAPnUO39G4Qh3_cGeXORJjGvg7JfGJuS6A&s', 'Music/arijit singh/Tum Hi Ho Aashiqui 2 320 Kbps.mp3', 'Bollywood'),
(11, 'Dekhte Dekhte', 'Atif Aslam', 'Batti Gul Meter Chalu', 235, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRL9BkjLCmo6Z1nwv3GVekqeOsqT-wr4XcJ_g&s', 'Music/atif aslam/Dekhte Dekhte Batti Gul Meter Chalu 320 Kbps.mp3', 'Bollywood'),
(12, 'Dil Diyan Gallan', 'Atif Aslam', 'Tiger Zinda Hai', 250, 'https://www.radioandmusic.com/sites/www.radioandmusic.com/files/images/entertainment/2018/01/15/Dil-Diyan.jpg', 'Music/atif aslam/Dil Diyan Gallan Tiger Zinda Hai 320 Kbps.mp3', 'Bollywood'),
(13, 'Dil Meri Na Sune', 'Atif Aslam', 'Genius', 228, 'https://a10.gaanacdn.com/gn_img/song/oAJbDElKnL/JbDkapplWn/size_m_1532677407.jpg', 'Music/atif aslam/Dil Meri Na Sune Genius 320 Kbps.mp3', 'Bollywood'),
(14, 'Main Rang Sharbaton Ka', 'Atif Aslam', 'Phata Poster Nikhla Hero', 242, 'https://i.scdn.co/image/ab67616d0000b273a08e3ccaf8b8f0be5d0fac88', 'Music/atif aslam/Main Rang Sharbaton Ka Phata Poster Nikhla Hero 320 Kbps.mp3', 'Bollywood'),
(15, 'Pehli Dafa', 'Atif Aslam', 'Singles', 238, 'https://c.saavncdn.com/866/Pehli-Dafa-Hindi-2017-500x500.jpg', 'Music/atif aslam/Pehli Dafa Atif Aslam 320 Kbps.mp3', 'Bollywood'),
(16, 'Shining Star', 'King', 'Singles', 220, 'https://i.scdn.co/image/ab67616d0000b2733fb95269a03376d22043a958', 'Music/king/Shining Star - King (pagalall.com).mp3', 'Pop'),
(17, 'Stay', 'King', 'Singles', 215, 'https://c.saavncdn.com/619/Stay-Hindi-2025-20250307175020-500x500.jpg', 'Music/king/Stay King (pagalall.com).mp3', 'Pop'),
(18, 'Tere Ho Ke', 'King, Bella', 'Collaborations', 225, 'https://images.genius.com/17aa8557b1014c99d33978ff60ab7873.849x849x1.jpg', 'Music/king/Tere Ho Ke - King, Bella (pagalall.com).mp3', 'Pop'),
(19, 'Till The End', 'King ft. Amyra Dastur', 'Singles', 230, 'https://i.scdn.co/image/ab67616d0000b273b6091eea58f2e133bfb1dbda', 'Music/king/Till The End King Ft. Amyra Dastur (pagalall.com).mp3', 'Pop'),
(20, 'Tu Aake Dekhle', 'King', 'Singles', 218, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLJayMeXQykk5sexpHAPpdaxHPW6cR5ypdpg&s', 'Music/king/Tu_Aake_Dekhle_king.mp3', 'Pop');

-- Make sure the liked_songs table exists
CREATE TABLE IF NOT EXISTS liked_songs (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  song_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (song_id) REFERENCES songs(id) ON DELETE CASCADE
); 