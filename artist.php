<?php

include("includes/includedFiles.php");


if(isset($_GET['id'])) {
    $artistId = $_GET['id'];
} else {
    header("Location: index.php");
}

$artist = new Artist($con, $artistId);
?>
<div class="entityInfo borderBottom">

    <div class="centerSection">

        <div class="artistInfo">
            <h1 class="artistName">

                <?php echo $artist->getname(); ?>

            </h1>

                <div class="headerButton">
                    <button class="button green" onclick= "playFirstSong()">Play</button>

                </div>

        </div>

    </div>

</div>


<div class="tracklistContainer borderBottom">
    <ul class="tacklist">

        <?php
        $songIdArray = $artist->getSongIds();

        $i = 1;
        foreach ($songIdArray as $songId) //referance
        {

            if($i > 5 ){
                break;
            }

            $albumSong = new Song($con, $songId);


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
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';   //PHP array convert into JSON foramt
            tempPlaylist = JSON.parse(tempSongIds);     //use JSON format converted into an js object
        </script>

    </ul>

</div>
