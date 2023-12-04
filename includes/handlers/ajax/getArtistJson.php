<?php 
 include("../../config.php");   // database connection variable

    // call database
if(isset($_POST['artistId'])){
    $artistId = $_POST['artistId'];
    
    $query = mysqli_query($con, "SELECT * FROM artists WHERE id='$artistId'");

    $resultArray = mysqli_fetch_array($query);

    //convert to js using json_decode
    echo json_encode($resultArray);
}

?>