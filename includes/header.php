<?php
include("includes/config.php");

//session_destroy(); LOGOUT

if (isset($_SESSION['userLoggedIn'])) { //$_SESSION global variable
	$userLoggedIn = $_SESSION['userLoggedIn'];
} else {
	header("Location: register.php");
}

?>

<html>

<head>
	<title>Welcome to Violina!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
	<div id="mainContainer">

		<div id="topContainer">
			<?php include("includes/navBarContainer.php"); ?>
			<!-- Content will imported from navBarContainer.php file  -->

			<div id="mainViewContainer">

			<div id="mainContent">