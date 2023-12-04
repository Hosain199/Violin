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
		
		newPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(newPlaylist[0], newPlaylist, false);
		updaateVolumeProgressBar(audioElement.audio);	 //to see volume progress after page reload


		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove", function (e) {
			e.preventDefault();	//don't do your normal behaviour. Like don't highligts the nowplayingBar when we drag on it
		});




		$(".playbackBar .progressBar").mousedown(function () {
			mouseDown = true;
		});

		$(".playbackBar .progressBar").mousemove(function (e) {	//e for event
			if (mouseDown == true) {
				//set time of song, depending on position of mouse
				timeFromOffset(e, this);
			}
		});

		$(".playbackBar .progressBar").mouseup(function (e) {	//e for event
			timeFromOffset(e, this);
		});


		// volume change

		$(".volumeBar .progressBar").mousedown(function () {
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function (e) {	//e for event
			if (mouseDown == true) {
				//set time of song, depending on position of mouse
				var percentage = e.offsetX / $(this).width();

				if (percentage >= 0 && percentage <= 1) {

					audioElement.audio.volume = percentage;
				}

			}
		});

		$(".volumeBar .progressBar").mouseup(function (e) {	//e for event
			var percentage = e.offsetX / $(this).width();

			if (percentage >= 0 && percentage <= 1) {

				audioElement.audio.volume = percentage;
			}
		});



		$(document).mouseup(function () {
			mouseDown = false;
		});

	});

	function timeFromOffset(mouse, progressBar) {
		var percentage = mouse.offsetX / $(progressBar).width() * 100;		//creating jQuery object for using upper(e, this )HTML element.offsetX is something like we use in graph to measure the X axis.
		var seconds = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(seconds);

	}

	function prevSong() {
		if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
			audioElement.setTime(0); 									//if the current song is at less then 3s then it go back to previous song, 
			//othewise it plays from its very first also if the song index is 0 in 
			//current playlist then it runs itself again.
		}
		else{
			currentIndex = currentIndex - 1;
			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);		//previous song,newPlaylist is currentplaylist now
		}
	}


	function nextSong() {

		if (repeat == true) {
			audioElement.setTime(0);
			playSong();
			return;
		}

		if (currentIndex == currentPlaylist.length - 1) {
			currentIndex = 0;

		}
		else {
			currentIndex++;
		}

		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
		setTrack(trackToPlay, currentPlaylist, true);
	}

	function setRepeat() {
		repeat = !repeat; 	//if(repeat== true){return false}else {return true}
		var imageName = repeat ? "repeat-active.png" : "repeat.png";
		$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
	}

	function setMute() {
		audioElement.audio.muted = !audioElement.audio.muted; 	//if(muted== true){return unmute}else {return mute}
		var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
		$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
	}


	function setShuffle() {
		shuffle = !shuffle; 	
		var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
		$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);
		
		if(shuffle==true){
			//randomize playlist
			shuffleArray(shufflePlaylist);
			currentIndex =shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);

		}
		else{
			//shuffle has been deactivate
			//go back to regular playlist
			currentIndex =currentPlaylist.indexOf(audioElement.currentlyPlaying.id);

		}
	
	
	
	}

	function shuffleArray(a){
		var j, x, i;
		for(i = a.length; i; i--){
			j = Math.floor(Math.random()*i);
			x = a[i - 1];
			a[i - 1] = a[j];
			a[j] = x;
		}
	}

	function setTrack(trackId, newPlaylist, play) {

		if(newPlaylist != currentPlaylist){
			currentPlaylist = newPlaylist;
			shufflePlaylist = currentPlaylist.slice(); //.slice() create a copy of array 
			shuffleArray(shufflePlaylist);
		}

		if(shuffle == true){
			currentIndex = shufflePlaylist.indexOf(trackId);
		}
		else{
			currentIndex = currentPlaylist.indexOf(trackId);		//get song Id to change song
		}
				//get song Id to change song
		pauseSong();

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

			audioElement.setTrack(track);
			playSong();
		});

		// ajax call for artist name.we can't call Php from js
		//php code execute as soon as when page load. we can't execute php when page reloded
		//so we use ajax call to update song count.

		if (play == true) {
			audioElement.play();
		}
	}

	function playSong() {

		//so we use ajax call to update song count.
		// console.log(audioElement);

		if (audioElement.audio.currentTime == 0) {
			$.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
		}

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

					<button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>

					<button class="controlButton previous" title="Previous button" onclick ="prevSong()">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>

					<button class="controlButton play" title="Play button" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause button" style="display: none;"
						onclick="pauseSong()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>

					<button class="controlButton next" title="Next button" onclick="nextSong()">
						<img src="assets/images/icons/next.png" alt="Next">
					</button>

					<button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
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
				<button class="controlButton volume" title="Volume button" onclick="setMute()">
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