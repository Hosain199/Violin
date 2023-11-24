<?php include("includes/header.php"); ?>

<h1 class="pageHeadingBig">
	<?php function get_greeting()
	{
		$hour = date('H');

		$greeting = "";
		if ($hour < 12) {
			$greeting = "Good morning";
		} elseif ($hour < 17) {
			$greeting = "Good afternoon";
		} elseif ($hour < 21) {
			$greeting = "Good evening";
		} else {
			$greeting = "Good night";
		}

		return $greeting;
	}
	echo get_greeting();
	?>
	<!-- automatically greeting you -->
</h1>



<div class="gridviewContainer">
	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM albums");
		while($row = mysqli_fetch_array($albumQuery)){	//converts the query into array
			echo $row['name'] . "<br>"; //The dot (.) operator in PHP is used to concatenate two or more strings.
		}
	?>
</div>


<?php include("includes/footer.php"); ?>