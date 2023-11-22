<?php

function sanitizeFromUsername($inputText){
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ","",$inputText);
    return $inputText;
}

function sanitizeFromString($inputText){
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ","",$inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
}

function sanitizeFromPassword($inputText){
    $inputText = strip_tags($inputText);
    return $inputText;
}


if(isset($_POST['registerButton'])){
    //register button
    $username = sanitizeFromUsername($_POST['username']);
    $firstName = sanitizeFromString($_POST['firstName']);
    $lastName = sanitizeFromString($_POST['lastName']);
    $email = sanitizeFromString($_POST['email']);
    $email2 = sanitizeFromString($_POST['email2']);
    $password = sanitizeFromPassword($_POST['password']);
    $password2 = sanitizeFromPassword($_POST['password']);

    $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

    if($wasSuccessful == true){
        $_SESSION['userLoggedIn']=$username;
        header("Location: index.php");
    }
}


?>


