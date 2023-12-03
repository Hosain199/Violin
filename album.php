<?php include("includes/header.php");

if (isset($_GET['id'])) {
    $albumId = $_GET['id'];
} else {
    header("Location: index.php");
}

$album = new Album($con, $albumId);

$artist = $album->getArtist();

// echo $album->getTitle() . "<br>";
// echo $artist->getname();
?>


<div class="entityInfo">

    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>">

    </div>

    <div class="rightSection">
        <h2>
            <?php echo $album->getTitle(); ?>
        </h2>
        <p>By
            <?php echo $artist->getname(); ?>
        </p>
        <p>By
            <?php echo $album->getNumberOfSongs(); ?>
        </p>
    </div>
</div>


<div class="tracklistContainer">
    <ul class="tacklist">

        <?php
        $songIdArray = $album->getSongIds();

        $i = 1;
        foreach ($songIdArray as $songId) //referance
        {
            $albumSong = new Song($con, $songId);

            
            $albumArtist = $albumSong->getArtist();

            echo "<li class='tracklistRow'>
            <div class='trackCount'>
                <img class ='play' src = 'assets/images/icons/play-white.png'>
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


            $i= $i+1;
        }
        ?>

    </ul>

</div>

<?php include("includes/footer.php"); ?>