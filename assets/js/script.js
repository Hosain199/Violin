var currentPlaylist = [];
var audioElement;


function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	this.setTrack = function(src) {
		this.audio.src = src;
	}

	this.play = function() {
		this.audio.play();
	}

}

