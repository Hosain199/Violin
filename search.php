<?php
include("includes/includedFiles.php");

if (isset($_GET['term'])) {
    $term = urldecode($_GET['term']);           //disable the %20 or anything just like url
} else {
    $term = "";
}
?>


<div class="searchContainer">
    <h4>What do you want to listen?</h4>
    <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing..."
        onfocus="this.value = this.value">
</div>



<script>                        //type in search box to reload page
    $(".searchInput").focus();          //it gives some time to page load
    $(function () {
        
        $(".searchInput").keyup(function () {            //keyup event to validate a form field, to update a search result
            clearTimeout(timer);
            timer = setTimeout(function () {
                var val = $(".searchInput").val();
                openPage("search.php?term=" + val);
            }, 2000);                                       //2000ms leater page reload
        })
    })

</script>
<?php If($term == "") exit(); ?>


<div class="tracklistContainer borderBottom">
    <ul class="tacklist">
        <?php
        $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");         //first % belongs enythig search with the letter last % return after its
        if (mysqli_num_rows($songsQuery) == 0) {
            echo "<span class = 'noResults'>No songs found matching" . $term . "</span";
        }

        $songIdArray = array();

        $i = 1;
        while ($row = mysqli_fetch_array($songsQuery)) //referance
        {
            if ($i > 15) {
                break;
            }
            array_push($songIdArray, $row['id']);
            $albumSong = new Song($con, $row['id']);

            $albumArtist = $albumSong->getArtist();
            //   cancel a character out.  \" is cancel out character
            echo "<li class='tracklistRow'> 
            <div class='trackCount'>
                 <img class ='play' src = 'assets/images/icons/play-white.png' onclick = 'setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>            
                <span class ='trackNumber'>$i</span>
            </div>
            <div class='trackInfo'>
                <span class ='trackName'>" . $albumSong->getTitle() . "</span>
                <span class='artistName'>" . $albumArtist->getName() . "</span>
            </div>

            <div class= 'trackOption'>
                <img class='optionButton' src ='assets/images/icons/more.png'>
            </div>

            <div class='trackDuration'>
                <span class='duration'>" . $albumSong->getDuration() . "</span>
            </div>


            
            </li>";


            $i = $i + 1;
        }

        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>

    </ul>

</div>


<div class="artistContainer borderBottom">

    <h2>ARTISTS</h2>

    <?php
    $artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");

    if (mysqli_num_rows($artistQuery) == 0) {
        echo "<span class='noResults'>No Artists found matching" . $term . "</span>";

    }

    while ($row = mysqli_fetch_array($artistQuery)) {
        $artistFound = new Artist($con, $row['id']);

        echo "<div class='searchResultRow'>
            <div class='aristName'>
                <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() . "\")'>
                
                ". $artistFound->getname() ."

                </span>
            </div>
                    
        </div>";
    }
    ?>

</div>


<div class="gridViewContainer">
	<h2>ALBUMS</h2>
	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE name LIKE'$term%' LIMIT 10");

        if (mysqli_num_rows($albumQuery) == 0) {
            echo "<span class='noResults'>No Albums found matching" . $term . "</span>";
    
        }

		while($row = mysqli_fetch_array($albumQuery)) {

			echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>"
							. $row['name'] .
						"</div>
					</span>

				</div>";



		}
	?>

</div>