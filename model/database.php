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
    }
    function addNewUser($user, $password) {
        $username = $user->getUsername();
        $userEmail = $user->getUserEmail();
        $accountType = $user->getPremium();
        $sql = "INSERT INTO `users` (userName, password, userEmail, premium) 
            VALUES ('$username', '$password', '$userEmail', '$accountType')";
        $statement = $this->_cnxn->prepare($sql);
        if ($statement->execute()) {
            return $this->_cnxn->lastInsertId();
        } else {
            return null;
        }

        //get the primary key of the last inserted row (in this case it is sid)
        //$id =
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
    }

    function getUser($username) {
        $sql = "SELECT * FROM `users` WHERE userName='$username'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $user = new User();
        $user->setUserID($result["userID"]);
        $user->setUsername($result["userName"]);
        $user->setUserEmail($result["userEmail"]);
        $user->setPremium($result["premium"]);
        return $user;
    }
<<<<<<< HEAD
    function insertItem($itemID, $name, $description, $image, $collection_id ){
        $sql = "INSERT INTO `collectionItems` (itemID, itemName, itemDescription, itemImage, collectionID) 
            VALUES ('$itemID', '$name', '$description', '$image', '$collection_id')";
=======

    function addCollection($collection) {
        $userID = $_SESSION["user"]->getUserID();
        $name = $collection->getName();
        $descr = $collection->getDescription();
        $collectionType = $collection->getPremium();
        $sql = "INSERT INTO `userCollections` (userID, collectionName, collectionDescription, premium) 
            VALUES ('$userID', '$name', '$descr', '$collectionType')";
>>>>>>> bb24302fb8485e257f4e6b6403e3ea9f72fdea4c
        $statement = $this->_cnxn->prepare($sql);
        if ($statement->execute()) {
            return $this->_cnxn->lastInsertId();
        } else {
            return null;
        }
    }
}


