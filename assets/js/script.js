var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;

function openPage(url){

	if(url.indexOf("?") == -1){
		url = url + "?";
	}

	var encodedUrl = encodeURI(url + "$userLoggedIn" + userLoggedIn);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);

}
function formatTime(seconds){
	var time = Math.round(seconds); //Math js object, time contains rounded version of seconds. 5.4s to 5s
	var minutes = Math.floor(time / 60); 	//rounds down
	var seconds = time - (minutes * 60);

	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;		//in php we use (.) in js use (+) for add two strings 
}

function updaateTimeProgressBar(audio){
	$(".progressTime.current").text(formatTime(audio.currentTime));		//jQuery object
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

			// inline progress with jQuery + css

	var progress = audio.currentTime / audio.duration * 100;
	$(".playbackBar .progress").css("width", progress + "%");


}

function updaateVolumeProgressBar(audio)
{
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}
function playFirstSong(){

	setTrack(tempPlaylist[0], tempPlaylist, true);
	
}

function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener("ended", function(){
		nextSong();
	});

	this.audio.addEventListener("canplay", function(){
		//this refers to the object that the event was called on
		
		var duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration);		//create jQuery object, (.) use for class 
	
		
	
	});

	this.audio.addEventListener("timeupdate", function(){
		if(this.duration){
			updaateTimeProgressBar(this);
		}
	});


	this.audio.addEventListener("volumechange", function(){
		updaateVolumeProgressBar(this);
	});



	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function(){
		this.audio.pause();
	}

	this.setTime = function(seconds){
		this.audio.currentTime = seconds;
	}

}

