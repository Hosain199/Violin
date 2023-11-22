<?php
    class Account{

        private $con;
        private $errorArray;

        public function __construct($con){
            $this->con = $con;
            $this->errorArray = array();

        }
        public function login($un, $pw){
            $pw = md5($pw);
            $query = mysqli_query($this->con, "SELECT * FROM user WHERE username='$un' AND password='$pw'");
            if(mysqli_num_rows($query) ==1){
                return true;
            }
            else{
                array_push($this->errorArray,Constants::$loginFaield);
                return false;
            }
        }

        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLasttName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray) == true){
                //insert into database
                return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
            }
            else{
                return false;
            }
        }

        public function getError($error){
            if(!in_array($error, $this->errorArray)){
                $error = "";
            }
            return "<span class = 'errorMessage'>$error</span>";
        }
        private function insertUserDetails($un, $fn, $ln, $em, $pw){
            $encryptedPw = md5($pw);//password encryotion
            $profilePic = "assets/images/profile-pics/my-profile.png";
            $date = date("y-m-d");

            $result = mysqli_query($this->con, "INSERT INTO user VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");
            
            return $result;
        }
        private function validateUsername($un){
            if(strlen($un) > 25 || strlen($un) < 5){
                array_push($this->errorArray,Constants::$usernameCharacters);//'::'for calling static class function '->' for calling instant class function 
                return;
            }
            //check username exits\
            $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM user WHERE username = '$un'");
            if(mysqli_num_rows($checkUsernameQuery) != 0){
                array_push($this->errorArray,Constants::$usernameTaken);
                return;
            }
        }

        private function validateFirstName($fn){
            if(strlen($fn) > 25 || strlen($fn) < 2){
                array_push($this->errorArray,Constants::$firstnameCharacters);
                return;
            }

        }

        private function validateLasttName($ln){
            if(strlen($ln) > 25 || strlen($ln) < 2){
                array_push($this->errorArray,Constants::$lastnameCharacters);
                return;
            }

        }

        private function validateEmails($em, $em2){
            if($em != $em2){
                array_push($this->errorArray,Constants::$emailtMatch);
            }
            if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }

            //Check that username hasn't already been used
            $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM user WHERE email = '$em'");
            if(mysqli_num_rows($checkEmailQuery) != 0){
                array_push($this->errorArray,Constants::$emailTaken);
                return;
            }
        }

        private function validatePasswords($pw, $pw2){

            if($pw!=$pw2){
                array_push($this->errorArray, Constants::$passwordDoNotMatch);
                return;
            }

            if(preg_match('/^[a-zA-Z][a-zA-Z0-9_!@#$%^&*().]{10,25}$/', $pw)){
                array_push($this->errorArray, Constants::$passwordDoNotAlphanumeric);
                return;
                
            }
            if(strlen($pw) > 25 || strlen($pw) < 6){
                array_push($this->errorArray,Constants::$passwordCharacters);
                return;
            }
        }
    }
?>