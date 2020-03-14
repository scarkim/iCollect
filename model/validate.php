<?php

/**
 * Class Validate
 * Validates input values
 */
class Validate
{
    /**
     * Checks if username is alphanumeric
     * @param $userName
     * @return bool
     */
    function validUserName($userName)
    {
        return ctype_alnum($userName);
    }

    /**
     * Checks if email is valid
     * @param $email
     * @return mixed
     */
    function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Checks if username is alphanumeric
     * @param $userName
     * @return bool
     */
    function validLogin($userName)
    {
        return ctype_alnum($userName);
    }


    /**
     * Checks if password is blank
     * @param $pass1
     * @return bool
     */
    function validPassword($pass1)
    {
        return $pass1 !== "";
    }

    /**
     * Checks if password field is not blank and the value from first input
     * is the same as the value in the second input
     * @param $pass1
     * @param $pass2
     * @return bool
     */
    function passwordMatch($pass1, $pass2)
    {
        return $pass2 != "" AND $pass1 == $pass2;
    }

    /**
     * Validates the account type (Premium(1) General(0))
     * @param $acctType
     * @return bool
     */
    function validateAcctType($acctType)
    {
        return $acctType === "0" OR $acctType === "1";
    }

    /**
     * Validates the collection name
     * @param $name
     * @return bool
     */
    function validCollectionName($name)
    {
        if ($name === "" OR $name == null) return false;
        if (strlen($name) > 50) return false;
        if (!preg_match("/^[^<>#@$%^*|]+$/", $name)) return false;
        return true;
    }

    /**
     * Validates the description of collection
     * @param $description
     * @return bool
     */
    function validCollectionDescription($description)
 {
     if ($description === "" OR $description == null) return true;
     if (strlen($description) > 200) return false;
     if (!preg_match("/^[^<>#@$%^*|]+$/", $description)) return false;
     return true;
 }
}
