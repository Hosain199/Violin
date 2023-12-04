<?php 
 include("../../config.php");   // database connection variable

    // call database
if(isset($_POST['songId'])){
    $songId = $_POST['songId'];
    
    $query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");

    $resultArray = mysqli_fetch_array($query);

    //convert to js using json_decode
    echo json_encode($resultArray);
}

?>