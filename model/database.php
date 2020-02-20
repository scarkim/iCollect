<?php
require ("../../../connection.php");
class Database
{
    /**
     * @var PDO
     */
    private $_cnxn;
    /**
     * Database constructor.
     */
    function __construct()
    {
        try {
            //CREATING A NEW PDO CONNECTION
            $this->_cnxn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
//            echo "Connected!";
            //if there is an error, print error message
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    function checkCredentials($username, $password){
            $sql = "SELECT * FROM `users` WHERE userName='$username' AND
                password='$password'";
            $statement = $this->_cnxn->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            //do the steps from class skip binding params
            return $result;
<<<<<<< HEAD
=======
    }
    function addNewUser() {
        $username = $_SESSION['username'];
        $password =  $_SESSION['password'];
        $userEmail = $_SESSION['email'];
        $accountType = $_SESSION['accountType'];
        $sql = "INSERT INTO `users` (userName, password, userEmail, premium) 
            VALUES ('$username', '$password', '$userEmail', '$accountType')";
        $statement = $this->_cnxn->prepare($sql);
        return $statement->execute();
        //get the primary key of the last inserted row (in this case it is sid)
        //$id = $this->_cnxn->lastInsertId();
    }
    function containsEmail($email)
    {
        //1. define the query
        $sql = "SELECT * FROM `users` WHERE userEmail='$email'";
        //2. prepare the statement
        $statement = $this->_cnxn->prepare($sql);
        //execute statement
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        //do the steps from class skip binding params
        return $result;
    }
    function containsUsername($username){
        $sql = "SELECT * FROM `users` WHERE userName='$username'";
        //2. prepare the statement
        $statement = $this->_cnxn->prepare($sql);
        //execute statement
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        //do the steps from class skip binding params
        return $result;
>>>>>>> 791da9433b91f3919ede831b568d9bd28133b69a
    }
}


