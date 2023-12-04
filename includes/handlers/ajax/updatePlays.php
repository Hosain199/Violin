<?php 
 include("../../config.php");   // database connection variable

    // ajax call database. we can't call Php from js
    
if(isset($_POST['songId'])){
    $songId = $_POST['songId'];
    
    $query = mysqli_query($con, "UPDATE songs SET plays = plays + 1 WHERE id='$songId'");

}

?>