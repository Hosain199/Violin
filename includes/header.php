<?php
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
//session_destroy(); LOGOUT

if (isset($_SESSION['userLoggedIn'])) { //$_SESSION global variable
	$userLoggedIn = $_SESSION['userLoggedIn'];

	echo "<script> userLoggedIn = '$userLoggedIn';</script>";
} else {
	header("Location: register.php");
}

?>

<html>

<head>
	<title>Welcome to Violina!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>

<body>


	<!-- <script>
		var audioElement = new Audio();
		audioElement.setTrack("assets/music/Linkin Park - In The End.mp3");
		audioElement.audio.play();
	</script> -->



	<div id="mainContainer">

		<div id="topContainer">
			<?php include("includes/navBarContainer.php"); ?>
			<!-- Content will imported from navBarContainer.php file  -->

			<div id="mainViewContainer">

			<div id="mainContent">