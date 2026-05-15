// Music data for the player

const musicData = {
    songs: [
        // Ed Sheeran songs
        {
            id: 1,
            title: "2step (feat. Armaan Malik)",
            artist: "Ed Sheeran",
            album: "Ed Sheeran Collection",
            duration: 180, // estimated duration
            cover: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLNBs9mZD0rol54lZELj4QqDLtsr3VaCkSEQ&s",
            audio: "Music/ad sheeran/2step (feat. Armaan Malik) - Ed Sheeran 320 Kbps.mp3",
            genre: "Pop"
        },
        {
            id: 2,
            title: "Azizam (Looper Performance Live from Old Delhi)",
            artist: "Ed Sheeran",
            album: "Live Performances",
            duration: 210,
            cover: "https://i.ytimg.com/vi/lNPJBHUePl0/maxresdefault.jpg",
            audio: "Music/ad sheeran/Ed Sheeran - Azizam (Looper Performance Live from Old Delhi) [lNPJBHUePl0].mp3",
            genre: "Pop"
        },
        {
            id: 3,
            title: "Perfect (Official Music Video)",
            artist: "Ed Sheeran",
            album: "÷ (Divide)",
            duration: 263,
            cover: "https://i.scdn.co/image/ab67616d0000b273ba5db46f4b838ef6027e6f96",
            audio: "Music/ad sheeran/Ed Sheeran - Perfect (Official Music Video).m4a",
            genre: "Pop"
        },
        {
            id: 4,
            title: "Photograph",
            artist: "Ed Sheeran",
            album: "x (Multiply)",
            duration: 258,
            cover: "https://i.scdn.co/image/ab67616d0000b273407981084d79d283e24d428e",
            audio: "Music/ad sheeran/Ed Sheeran - Photograph (Lyrics) [HpphFd_mzXE].mp3",
            genre: "Pop"
        },
        {
            id: 5,
            title: "Shape Of You (Deazy Remix)",
            artist: "Ed Sheeran",
            album: "÷ (Divide) Remixes",
            duration: 233,
            cover: "https://a10.gaanacdn.com/gn_img/albums/0wrb4qNKLg/wrb4dDxLbL/size_m.webp",
            audio: "Music/ad sheeran/Shape Of You (Deazy Remix) by Ed Sheeran - Free Download on Hypeddit.mp3",
            genre: "Pop"
        },
        
        // Arijit Singh songs
        {
            id: 6,
            title: "Aabaad Barbaad",
            artist: "Arijit Singh",
            album: "Bollywood Hits",
            duration: 240,
            cover: "https://i1.sndcdn.com/artworks-EVWUKXuBQxPV6vuD-lLe3yA-t500x500.jpg",
            audio: "Music/arijit singh/Aabaad Barbaad 320 Kbps.mp3",
            genre: "Bollywood"
        },
        {
            id: 7,
            title: "Aasan Nahin Yahan",
            artist: "Arijit Singh",
            album: "Aashiqui 2",
            duration: 225,
            cover: "https://images.genius.com/e93872dbce13cdc830a2c143b6e232a3.1000x1000x1.png",
            audio: "Music/arijit singh/Aasan Nahin Yahan Aashiqui 2 320 Kbps.mp3",
            genre: "Bollywood"
        },
        {
            id: 8,
            title: "Chahun Main Ya Naa",
            artist: "Arijit Singh",
            album: "Aashiqui 2",
            duration: 230,
            cover: "https://i1.sndcdn.com/artworks-000076159876-tp39te-t500x500.jpg",
            audio: "Music/arijit singh/Chahun Main Ya Naa Aashiqui 2 320 Kbps.mp3",
            genre: "Bollywood"
        },
        {
            id: 9,
            title: "Hardum Humdum",
            artist: "Arijit Singh",
            album: "Bollywood Hits",
            duration: 215,
            cover: "https://c.saavncdn.com/249/Hardum-Humdum-From-Ludo--Hindi-2020-20201031121001-500x500.jpg",
            audio: "Music/arijit singh/Hardum Humdum 320 Kbps.mp3",
            genre: "Bollywood"
        },
        {
            id: 10,
            title: "Tum Hi Ho",
            artist: "Arijit Singh",
            album: "Aashiqui 2",
            duration: 245,
            cover: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRelAPnUO39G4Qh3_cGeXORJjGvg7JfGJuS6A&s",
            audio: "Music/arijit singh/Tum Hi Ho Aashiqui 2 320 Kbps.mp3",
            genre: "Bollywood"
        },
        
        // Atif Aslam songs
        {
            id: 11,
            title: "Dekhte Dekhte",
            artist: "Atif Aslam",
            album: "Batti Gul Meter Chalu",
            duration: 235,
            cover: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRL9BkjLCmo6Z1nwv3GVekqeOsqT-wr4XcJ_g&s",
            audio: "Music/atif aslam/Dekhte Dekhte Batti Gul Meter Chalu 320 Kbps.mp3",
            genre: "Bollywood"
        },
        {
            id: 12,
            title: "Dil Diyan Gallan",
            artist: "Atif Aslam",
            album: "Tiger Zinda Hai",
            duration: 250,
            cover: "https://www.radioandmusic.com/sites/www.radioandmusic.com/files/images/entertainment/2018/01/15/Dil-Diyan.jpg",
            audio: "Music/atif aslam/Dil Diyan Gallan Tiger Zinda Hai 320 Kbps.mp3",
            genre: "Bollywood"
        },
        {
            id: 13,
            title: "Dil Meri Na Sune",
            artist: "Atif Aslam",
            album: "Genius",
            duration: 228,
            cover: "https://a10.gaanacdn.com/gn_img/song/oAJbDElKnL/JbDkapplWn/size_m_1532677407.jpg",
            audio: "Music/atif aslam/Dil Meri Na Sune Genius 320 Kbps.mp3",
            genre: "Bollywood"
        },
        {
            id: 14,
            title: "Main Rang Sharbaton Ka",
            artist: "Atif Aslam",
            album: "Phata Poster Nikhla Hero",
            duration: 242,
            cover: "https://i.scdn.co/image/ab67616d0000b273a08e3ccaf8b8f0be5d0fac88",
            audio: "Music/atif aslam/Main Rang Sharbaton Ka Phata Poster Nikhla Hero 320 Kbps.mp3",
            genre: "Bollywood"
        },
        {
            id: 15,
            title: "Pehli Dafa",
            artist: "Atif Aslam",
            album: "Singles",
            duration: 238,
            cover: "https://c.saavncdn.com/866/Pehli-Dafa-Hindi-2017-500x500.jpg",
            audio: "Music/atif aslam/Pehli Dafa Atif Aslam 320 Kbps.mp3",
            genre: "Bollywood"
        },
        
        // King songs
        {
            id: 16,
            title: "Shining Star",
            artist: "King",
            album: "Singles",
            duration: 220,
            cover: "https://i.scdn.co/image/ab67616d0000b2733fb95269a03376d22043a958",
            audio: "Music/king/Shining Star - King (pagalall.com).mp3",
            genre: "Pop"
        },
        {
            id: 17,
            title: "Stay",
            artist: "King",
            album: "Singles",
            duration: 215,
            cover: "https://c.saavncdn.com/619/Stay-Hindi-2025-20250307175020-500x500.jpg",
            audio: "Music/king/Stay King (pagalall.com).mp3",
            genre: "Pop"
        },
        {
            id: 18,
            title: "Tere Ho Ke",
            artist: "King, Bella",
            album: "Collaborations",
            duration: 225,
            cover: "https://images.genius.com/17aa8557b1014c99d33978ff60ab7873.849x849x1.jpg",
            audio: "Music/king/Tere Ho Ke - King, Bella (pagalall.com).mp3",
            genre: "Pop"
        },
        {
            id: 19,
            title: "Till The End",
            artist: "King ft. Amyra Dastur",
            album: "Singles",
            duration: 230,
            cover: "https://i.scdn.co/image/ab67616d0000b273b6091eea58f2e133bfb1dbda",
            audio: "Music/king/Till The End King Ft. Amyra Dastur (pagalall.com).mp3",
            genre: "Pop"
        },
        {
            id: 20,
            title: "Tu Aake Dekhle",
            artist: "King",
            album: "Singles",
            duration: 218,
            cover: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLJayMeXQykk5sexpHAPpdaxHPW6cR5ypdpg&s",
            audio: "Music/king/Tu_Aake_Dekhle_king.mp3",
            genre: "Pop"
        }
    ],
    
    playlists: [
        {
            id: 1,
            name: "Ed Sheeran Hits",
            cover: "https://i.scdn.co/image/ab6761610000e5eb3bcef85e105dfc42399ef0ba",
            songIds: [1, 2, 3, 4, 5]
        },
        {
            id: 2,
            name: "Arijit Singh Collection",
            cover: "https://i.scdn.co/image/ab6761610000e5eb7b8d50712123dade4f96cc8a",
            songIds: [6, 7, 8, 9, 10]
        },
        {
            id: 3,
            name: "Atif Aslam Favorites",
            cover: "https://i.scdn.co/image/ab6761610000e5ebc39f29f17ca749c5c2caa4c6",
            songIds: [11, 12, 13, 14, 15]
        },
        {
            id: 4,
            name: "King's Best",
            cover: "https://i.scdn.co/image/ab6761610000e5ebec03236a89ef75f58cae63a2",
            songIds: [16, 17, 18, 19, 20]
        }
    ],
    
    genres: [
        "All Artists",
        "Ed Sheeran", 
        "Arijit Singh",
        "Atif Aslam",
        "King"
    ]
};

// Export the data for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { musicData };
}