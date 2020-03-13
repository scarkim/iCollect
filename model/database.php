<?php
require ("../../../connection.php");

/**
 * Class Database
 */
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

    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    function checkCredentials($username, $password){
            $sql = "SELECT * FROM `users` WHERE userName='$username' AND
                password='$password'";
            $statement = $this->_cnxn->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            //do the steps from class skip binding params
            return $result;
    }

    /**
     * @param $user
     * @param $password
     * @return string|null
     */
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
    }

    /**
     * @param $name
     * @param $description
     * @param $collID
     * @return string|null
     */
    function insertItem($name, $description, $collID){
        $sql = "INSERT INTO `collectionItems`  (itemName, itemDescription, collectionID)
           VALUES ('$name', '$description', $collID )";
        $statement = $this->_cnxn->prepare($sql);
        if ($statement->execute()) {
            return $this->_cnxn->lastInsertId();
        } else {
            return null;
        }
    }

    /**
     * @param $email
     * @return mixed
     */
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

    /**
     * @param $username
     * @return mixed
     */
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

    /**
     * @param $username
     * @return User
     */
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
        $user->setProfileImg($result["profileImage"]);
        return $user;
    }

    /**
     * @param $collection
     * @return string|null
     */
    function addCollection($collection) {
        $userID = $_SESSION["user"]->getUserID();
        $name = $collection->getName();
        $descr = $collection->getDescription();
        $collectionType = $collection->getPremium();
        $sql = "INSERT INTO `userCollections` (userID, collectionName, collectionDescription, premium) 
            VALUES ('$userID', '$name', '$descr', '$collectionType')";
        $statement = $this->_cnxn->prepare($sql);
        if ($statement->execute()) {
            return $this->_cnxn->lastInsertId();
        } else {
            return null;
        }
    }

    /**
     * @param $user_id
     * @return array
     */
    function getCollections($user_id) {
        $sql = "SELECT * FROM `userCollections` WHERE userID ='$user_id'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param $userID
     * @param $image
     */
    function addImage($userID, $image)
    {
        $sql = "UPDATE `users`
                SET profileImage ='$image'
                WHERE userID = '$userID'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
    }

    /**
     * @param $collectionID
     * @param $image
     */
    function addCollectionImage($collectionID, $image)
    {
        $sql = "UPDATE `userCollections`
                SET collectionImage ='$image'
                WHERE collectionID = '$collectionID'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
    }

    /**
     * @param $collID
     * @return mixed
     */
    function getCollection($collID) {
        $sql = "SELECT * FROM `userCollections` WHERE collectionID ='$collID'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param $collID
     * @return array
     */
    function getCollectionItems($collID){
        $sql = "SELECT * FROM `collectionItems` WHERE collectionID ='$collID'
ORDER BY itemID";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function insertAttribute($collID, $attrName) {
        $sql = "INSERT INTO `collectionAttributes` (collectionID, attributeName) 
            VALUES ('$collID', '$attrName')";
        $statement = $this->_cnxn->prepare($sql);
        if ($statement->execute()) {
            return $this->_cnxn->lastInsertId();
        } else {
            return null;
        }
    }

    function getAttributes($collID) {
        $sql = "SELECT * FROM `collectionAttributes` WHERE collectionID ='$collID'
                ORDER BY attributeID ASC";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $returnArray = array();
        foreach ($result AS $attr) {
            $returnArray[$attr["attributeID"]] = $attr["attributeName"];
        }
        //return an array of id's not result
        return $returnArray;
    }

    function addItemAttributeValue($itemID, $attrID, $itemValue) {
        $sql = "INSERT INTO `itemAttributeValue` (itemID, attributeID, itemValue) 
            VALUES ('$itemID', '$attrID', '$itemValue')";
        $statement = $this->_cnxn->prepare($sql);
        $result = $statement->execute();
        return $result;
    }

    function getItemAttrValue($attrID, $itemID) {
        $sql = "SELECT itemValue From `itemAttributeValue` 
                WHERE attributeID = '$attrID' AND itemID = '$itemID'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["itemValue"];
    }

    function changeItemValue($itemID, $collectionID, $colName, $newValue) {
        if ($colName === "Name") {
            $sql = "UPDATE `collectionItems` 
                SET itemName = '$newValue'
                WHERE itemID = '$itemID'";
        } else {
            $sql = "UPDATE `collectionItems` 
                SET itemDescription = '$newValue'
                WHERE itemID = '$itemID'";
        }

        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
    }

    function changeItemAttributeValue($collectionID, $colName, $itemID, $newValue) {
        $attrID = $this->getAttributeID($collectionID, $colName);
        $valueExists = $this->getItemAttrValue($attrID, $itemID);
        if ($valueExists) {
            $sql = "UPDATE `itemAttributeValue` 
                SET itemValue = '$newValue'
                WHERE itemID = '$itemID' AND attributeID = '$attrID'";
        } else {
            $this->addItemAttributeValue($itemID, $attrID, $newValue);
        }


        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
    }

    function getAttributeID($collectionID, $colName) {
        $sql = "SELECT attributeID From `collectionAttributes` 
                WHERE collectionID = '$collectionID' AND attributeName = '$colName'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["attributeID"];
    }

    function deleteItem($itemID) {
        $sql = "DELETE FROM `collectionItems` 
                WHERE itemID = '$itemID'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();

        $sql2 = "DELETE FROM `itemAttributeValue` 
                WHERE itemID = '$itemID'";
        $statement2 = $this->_cnxn->prepare($sql2);
        $statement2->execute();
    }

    function deleteCollection($collectionID){
        $sql = "SELECT itemID FROM `collectionItems`
                WHERE collectionID = '$collectionID'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result AS $row) {
            $this->deleteItem($row["itemID"]);
        }

        $sql2 = "DELETE FROM `collectionAttributes`
                WHERE collectionID = '$collectionID'";
        $statement2 = $this->_cnxn->prepare($sql2);
        $statement2->execute();

        $sql3 = "DELETE FROM `userCollections` WHERE collectionID = '$collectionID'";
        $statement3 = $this->_cnxn->prepare($sql3);
        $statement3->execute();
    }
}