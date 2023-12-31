<?php
class Album
{

    private $con;
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artworkPath;


    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $Query = mysqli_query($con, "SELECT * FROM albums WHERE id='$this->id'");
        $album = mysqli_fetch_array($Query);


        $this->title = $album['name'];
        $this->artistId = $album['artist'];
        $this->genre= $album['genre'];
        $this->artworkPath = $album['artworkPath'];

    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getArtist()
    {
        return new Artist($this->con, $this->artistId); //return Artist as Object
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getArtworkPath()
    {
        return $this->artworkPath;
    }

    public function getNumberOfSongs()
    {
        $Query = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
        return mysqli_num_rows($Query);
    }

    public function getSongIds()
    {
        $query = mysqli_query($this->con,"SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");

        $array = array();

        while($row = mysqli_fetch_array($query))
        {
            array_push($array, $row['id']);
        }
        return $array;
    }

}
?>