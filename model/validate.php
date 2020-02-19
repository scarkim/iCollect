<?php
class Validate {
    function validUserName($userName, $cnxn) {
        if (ctype_alnum($userName)) {
            $sql = "SELECT * FROM `users` WHERE userName='$userName'";
            $searchResult = mysqli_query($cnxn, $sql);
            return mysqli_num_rows($searchResult) == 0;
        }
        return false;
    }

    function validEmail($email, $cnxn){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM `users` WHERE userEmail='$email'";
            $searchResult = mysqli_query($cnxn, $sql);
            return mysqli_num_rows($searchResult) == 0;
        }
        return false;
    }

    function validLogin($userName) {
        return ctype_alnum($userName);
    }

    function addNewUser($cnxn) {
        $username = $_SESSION['username'];
        $password =  $_SESSION['password'];
        $userEmail = $_SESSION['email'];
        $accountType = $_SESSION['accountType'];
        $sql = "INSERT INTO `users` (userName, password, userEmail, premium) 
            VALUES ('$username', '$password', '$userEmail', '$accountType')";
        $searchResult = mysqli_query($cnxn, $sql);
        return $searchResult;
    }
}
