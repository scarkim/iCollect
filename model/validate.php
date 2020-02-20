<?php
class Validate {
    //check if user is already in db
    function validUserName($userName, $cnxn) {
        return ctype_alnum($userName);
//        if (ctype_alnum($userName)) {
//            $sql = "SELECT * FROM `users` WHERE userName='$userName'";
//            $searchResult = mysqli_query($cnxn, $sql);
//            return mysqli_num_rows($searchResult) == 0;
//        }
//        return false;
    }

    function validEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
        //check for dup emails in db
//        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            $sql = "SELECT * FROM `users` WHERE userEmail='$email'";
//            $searchResult = mysqli_query($cnxn, $sql);
//            return mysqli_num_rows($searchResult) == 0;
//        }
//        return false;
    }

    function validLogin($userName) {
        return ctype_alnum($userName);
    }


}
