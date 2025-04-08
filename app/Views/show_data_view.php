<!DOCTYPE html>
<html>
  <head>
    <title>AmplitudeJS Testing</title>

    <!-- Include font -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i" rel="stylesheet">

    <!-- Include Amplitude JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@5.3.2/dist/amplitude.min.js"></script>

    <script type="text/javascript" src="<?= base_url();?>/music/js/jsmediatags/3.9.5/jsmediatags.min.js"></script>

    <!-- Include Style Sheet -->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/music/css/app.css"/>

  </head>
  <body style="background-color: white">

  <div align="center" style="padding-top: 10px;">
    <input type="file" id="fileInput" multiple accept="audio/*">
  </div>

  <div id="flat-black-player-container">
    <!-- Player UI goes here -->
    <div id="list-screen" class="slide-in-top">
      <div id="list-screen-header" class="hide-playlist">
        <img id="up-arrow" src="img/up.svg"/>
        Hide Playlist
      </div>
      <div id="list">
        <!-- Playlist -->
      </div>

      <div id="list-screen-footer">
        <div id="list-screen-meta-container">
          <span data-amplitude-song-info="name" class="song-name"></span>

          <div class="song-artist-album">
            <span data-amplitude-song-info="artist"></span>
          </div>
        </div>
        <div class="list-controls">
          <div class="list-previous amplitude-prev"></div>
          <div class="list-play-pause amplitude-play-pause"></div>
          <div class="list-next amplitude-next"></div>
        </div>
      </div>
    </div>

    <div id="player-screen">
      <div class="player-header down-header">
        <img id="down" src="img/down.svg"/>
        Show Playlist
      </div>
      <div id="player-top">
        <img id="cover_art_url" data-amplitude-song-info="cover_art_url" style="height: 200px;" />
      </div>
      <div id="player-progress-bar-container">
        <progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
        <progress id="song-buffered-progress" class="amplitude-buffered-progress" value="0"></progress>
      </div>
      <div id="player-middle">
        <div id="time-container">
          <span class="amplitude-current-time time-container"></span>
          <span class="amplitude-duration-time time-container"></span>
        </div>
        <div id="meta-container">
          <span data-amplitude-song-info="name" class="song-name"></span>

          <div class="song-artist-album">
            <span data-amplitude-song-info="artist"></span>
          </div>
        </div>
      </div>

      <div id="player-bottom">
        <div id="control-container">
          <div id="shuffle-container">
            <div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle"></div>
          </div>

          <div id="prev-container">
            <div class="amplitude-prev" id="previous"></div>
          </div>

          <div id="play-pause-container">
            <div class="amplitude-play-pause" id="play-pause"></div>
          </div>

          <div id="next-container">
            <div class="amplitude-next" id="next"></div>
          </div>

          <div id="repeat-container">
            <div class="amplitude-repeat" id="repeat"></div>
          </div>
        </div>

        <div id="volume-container">
          <img src="img/volume.svg"/><input type="range" class="amplitude-volume-slider" step=".1"/>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    const songs = []; // Initialize your song list

    // On page load, check if we have saved state in localStorage
    window.onload = function() {
        const currentSongIndex = localStorage.getItem('currentSongIndex');
        const currentTime = localStorage.getItem('currentTime');
        const uploadedFile = localStorage.getItem('uploadedFile');

        // Check if there's an uploaded file and restore its state
        if (uploadedFile && currentSongIndex !== null && currentTime !== null) {
            // Initialize Amplitude with your songs list
            Amplitude.init({
                songs: JSON.parse(uploadedFile), // Load saved song from localStorage
                bindings: {
                    37: 'prev',
                    39: 'next',
                    32: 'play_pause'
                },
            });

            // Set the active song index and playback time
            Amplitude.setActiveSongIndex(parseInt(currentSongIndex));
            Amplitude.setSongPlayedPercentage(parseFloat(currentTime));

            // Play the song automatically
            Amplitude.playNow(parseInt(currentSongIndex));
        } else {
            // Initialize the player normally if no saved state
            Amplitude.init({
                songs: songs, // Your existing song list
                bindings: {
                    37: 'prev',
                    39: 'next',
                    32: 'play_pause'
                },
            });
        }
    };

    // Save current song and time to localStorage when the song is played or paused
    Amplitude.bind('play', function() {
        const currentSongIndex = Amplitude.getActiveSongIndex();
        const currentTime = Amplitude.getSongPlayedPercentage();
        localStorage.setItem('currentSongIndex', currentSongIndex);
        localStorage.setItem('currentTime', currentTime);
    });

    Amplitude.bind('pause', function() {
        const currentSongIndex = Amplitude.getActiveSongIndex();
        const currentTime = Amplitude.getSongPlayedPercentage();
        localStorage.setItem('currentSongIndex', currentSongIndex);
        localStorage.setItem('currentTime', currentTime);
    });

    // Clear saved state when song changes
    Amplitude.bind('next', function() {
        localStorage.removeItem('currentSongIndex');
        localStorage.removeItem('currentTime');
    });

    Amplitude.bind('prev', function() {
        localStorage.removeItem('currentSongIndex');
        localStorage.removeItem('currentTime');
    });

    // Handle file input change
    document.getElementById('fileInput').addEventListener('change', function(event) {
        const files = event.target.files;
        if (files.length > 0) {
            const file = files[0];

            // Parse metadata
            jsmediatags.read(file, {
                onSuccess: function(tag) {
                    // Read title and artist from the file metadata
                    const song = {
                        name: tag.tags.title || 'Unknown',
                        artist: tag.tags.artist || 'Unknown',
                        url: URL.createObjectURL(file),
                        cover_art_url: 'path/to/cover/art', // Replace with actual cover if available
                    };

                    // Add the new song to Amplitude's songs array
                    songs.push(song);

                    // Save the song list to localStorage
                    localStorage.setItem('uploadedFile', JSON.stringify(songs));

                    // Reload the player with the new song
                    Amplitude.init({
                        songs: songs,
                        bindings: {
                            37: 'prev',
                            39: 'next',
                            32: 'play_pause'
                        },
                    });

                    // Optionally play the song after adding it
                    Amplitude.playNow(songs.length - 1);
                },
                onError: function(error) {
                    console.error(error);
                }
            });
        }
    });

  </script>

  <script type="text/javascript" src="<?= base_url(); ?>/music/js/functions.js"></script>

  </body>
</html>
