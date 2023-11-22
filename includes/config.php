<?php
    ob_start(); //This function allows to store the output of the PHP script in a buffer, instead of sending it to the browser immediately
    session_start();//function creates or resumes a session

    $timezone = date_default_timezone_set("Asia/Dhaka");
    $con = mysqli_connect("localhost", "root","", "violina");// the hostname is “localhost”, which means the server is running on the
                                                             // same machine as the PHP script, the username is “root”, the password is empty, and the database name is “violina”. The function returns a connection object, which is stored in a local variable called $con. The connection object can be used to perform queries and operations on the database. If the connection fails,

    if(mysqli_connect_errno()){
        echo "Failed to connect: " . mysqli_connect_error();
    }
?>