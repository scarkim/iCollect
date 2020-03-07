<?php
class Validate {
    //check if user is already in db
    function validUserName($userName) {
        return ctype_alnum($userName);
    }

    function validEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validLogin($userName) {
        return ctype_alnum($userName);
    }


    function validPassword($pass1) {
        return $pass1 !== "";
    }

    function passwordMatch($pass1, $pass2) {
        return $pass2 != "" AND $pass1 == $pass2;
    }

    function validateAcctType($acctType) {
        return $acctType === "0" OR $acctType === "1";
    }

    function validCollectionName($name) {

        if (sizeof($name) > 50) return false;
        $array = str_split($name);
        foreach ($array AS $char)
        if(!ctype_alnum($char) AND !ctype_space($char)) {
            return false;
        }
        return true;
    }

 function validCollectionDescription($description) {
     if (sizeof($description) > 200) return false;
     $array = str_split($description);
     foreach ($array AS $char)
         if(!ctype_alnum($char) AND !ctype_space($char)) {
             return false;
         }
     return true;
 }
}
