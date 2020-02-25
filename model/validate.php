<?php
class Validate {
    //check if user is already in db
    function validUserName($userName, $cnxn) {
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
}
