<?php
function validUserName($userName) {
    global $cnxn;

    if (ctype_alnum($userName)) {
        $sql = "SELECT * FROM `users` WHERE userName='$userName'";
        $searchResult = mysqli_query($cnxn, $sql);
        return mysqli_num_rows($searchResult) == 0;
    }
   return false;
}

function validEmail($email){
    global $cnxn;

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM `users` WHERE userEmail='$email'";
        $searchResult = mysqli_query($cnxn, $sql);
        return mysqli_num_rows($searchResult) == 0;
    }
    return false;
}