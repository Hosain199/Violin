<?php 
 include("../../config.php");   // database connection variable

    // ajax call database. we can't call Php from js
    
if(isset($_POST['albumId'])){
    $albumId = $_POST['albumId'];
    
    $query = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumId'");

    $resultArray = mysqli_fetch_array($query);

    //convert to js using json_decode
    echo json_encode($resultArray);
}

?>