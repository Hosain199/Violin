<?php
$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while ($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['id']);
}


// convert php file to js
$jsonArray = json_encode($resultArray);
?>


<!-- Start jQuery fuction. It simplifies HTML document manipulation, event handling, animation, and Ajax.
		The code block uses the jQuery syntax, which is $(selector).action(), to select HTML elements and perform actions on them.
		 For example, the code uses $(document).ready(function() {...}) to execute a function when the document is fully loaded.
		  The code also uses the jQuery object ?php echo $jsonArray; ?> to store the current playlist of songs -->


<script>
	$(document).ready(function () {	//start rendering js
		currentPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(currentPlaylist[0], currentPlaylist, false);
	});


	function setTrack(trackId, newPlaylist, play) {

		//audioElement.setTrack("assets/music/Linkin Park - Battle_Symphony.mp3");

		// ajax call for song name. it excute php without page reload 

		$.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function (data) {
			var track = JSON.parse(data); //pass JSON data from ajax call; 

			$(".trackName span").text(track.title); // input value into 
			//console.log(track);

			$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function (data) {
				var artist = JSON.parse(data);
				$(".artistName span").text(artist.name);
			});

			$.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function (data) {
				var album = JSON.parse(data);
				$(".albumLink img").attr("src", album.artworkPath);
			});


			audioElement.setTrack(track.path);
			audioElement.play();
		});

		// ajax call for artist name.



		if (play == true) {
			audioElement.play();

		}

	}

	function playSong() {


		
		$(".controlButton.play").hide();	//jQuery Object;
		$(".controlButton.pause").show();
		audioElement.play();
	}

	function pauseSong() {
		$(".controlButton.play").show();
		$(".controlButton.pause").hide();
		audioElement.pause();
	}

</script>



<div id="nowPlayingBarContainer">

	<div id="nowPlayingBar">

		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img src="" alt="song image" class="albumArtwork">
				</span>
				<div class="trackInfo">
					<span class="trackName">
						<span> </span>

					</span>
					<span class="artistName">
						<span></span>

					</span>

				</div>
			</div>

		</div>

		<div id="nowPlayingCenter">

			<div class="content playerControls">

				<div class="buttons">

					<button class="controlButton shuffle" title="Shuffle button">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>

					<button class="controlButton previous" title="Previous button">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>

					<button class="controlButton play" title="Play button" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause button" style="display: none;"
						onclick="pauseSong()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>

					<button class="controlButton next" title="Next button">
						<img src="assets/images/icons/next.png" alt="Next">
					</button>

					<button class="controlButton repeat" title="Repeat button">
						<img src="assets/images/icons/repeat.png" alt="Repeat">
					</button>

				</div>


				<div class="playbackBar">

					<span class="progressTime current">0.00</span>

					<div class="progressBar">
						<div class="progressBarBg">
							<div class="progress"></div>
						</div>
					</div>

					<span class="progressTime remaining">0.00</span>


				</div>


			</div>


		</div>

		<div id="nowPlayingRight">
			<div class="volumeBar">
				<button class="controlButton volume" title="Volume button">
					<img src="assets/images/icons/volume.png" alt="Volume">

				</button>

				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress"></div>
					</div>
				</div>

			</div>



		</div>




	</div>

</div>