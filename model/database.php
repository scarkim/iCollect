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
     * Checks for user with given username and password
     * @param $username
     * @param $password
     * @return mixed
     */
    function checkCredentials($username, $password)
    {
            $sql = "SELECT * FROM `users` WHERE userName='$username' AND
                password='$password'";
            $statement = $this->_cnxn->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            //do the steps from class skip binding params
            return $result;
    }

    /**
     * Adds a new user to the users table given the user object and password
     * @param $user
     * @param $password
     * @return string|null
     */
    function addNewUser($user, $password)
    {
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
     * inserts an item into collectionItems table
     * @param $name
     * @param $description
     * @param $collID
     * @return string|null
     */
    function insertItem($name, $description, $collID)
    {
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
     * checks if users table contains $email in userEmail column
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
     * Checks if users table contains $username in username column
     * @param $username
     * @return mixed
     */
    function containsUsername($username)
    {
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
     * Returns the user with the associated $username
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
     * Adds a new collection
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
     * Returns the collections of a user
     * @param $user_id
     * @return array
     */
    function getCollections($user_id)
    {
        $sql = "SELECT * FROM `userCollections` WHERE userID ='$user_id'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Adds a user's profile image
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
     * Adds a cover image to a collection
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
     * returns the collection with the given $collID
     * @param $collID
     * @return mixed
     */
    function getCollection($collID)
    {
        $sql = "SELECT * FROM `userCollections` WHERE collectionID ='$collID'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * returns the collection items from the
     * given collection ID
     * @param $collID
     * @return array
     */
    function getCollectionItems($collID)
    {
        $sql = "SELECT * FROM `collectionItems` WHERE collectionID ='$collID'
ORDER BY itemID";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Inserts a new attribute into collectionAttributes
     * @param $collID
     * @param $attrName
     * @return string|null
     */
    function insertAttribute($collID, $attrName)
    {
        $sql = "INSERT INTO `collectionAttributes` (collectionID, attributeName) 
                VALUES ('$collID', '$attrName')";
        $statement = $this->_cnxn->prepare($sql);
        if ($statement->execute()) {
            return $this->_cnxn->lastInsertId();
        } else {
            return null;
        }
    }

    /**
     * Returns the attributes of a collection in ascending order
     * @param $collID
     * @return array
     */
    function getAttributes($collID)
    {
        $sql = "SELECT * FROM `collectionAttributes` 
                WHERE collectionID ='$collID'
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

    /**
     * adds an attribute value to an item
     * @param $itemID
     * @param $attrID
     * @param $itemValue
     * @return bool
     */
    function addItemAttributeValue($itemID, $attrID, $itemValue)
    {
        $sql = "INSERT INTO `itemAttributeValue` (itemID, attributeID, itemValue) 
                VALUES ('$itemID', '$attrID', '$itemValue')";
        $statement = $this->_cnxn->prepare($sql);
        $result = $statement->execute();
        return $result;
    }

    /**
     * returns the item attribute value given the attribute's
     * ID and the item's ID
     * @param $attrID
     * @param $itemID
     * @return mixed
     */
    function getItemAttrValue($attrID, $itemID)
    {
        $sql = "SELECT itemValue From `itemAttributeValue` 
                WHERE attributeID = '$attrID' AND itemID = '$itemID'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["itemValue"];
    }

    /**
     * changes name, description, or attribute value of an item
     * @param $itemID
     * @param $collectionID
     * @param $colName
     * @param $newValue
     */
    function changeItemValue($itemID, $collectionID, $colName, $newValue)
    {
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

    /**
     * updates the attribute value of given item
     * @param $collectionID
     * @param $colName
     * @param $itemID
     * @param $newValue
     */
    function changeItemAttributeValue($collectionID, $colName, $itemID, $newValue)
    {
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

    /**
     * returns the attributeID from collectionAttributes table if
     * collectionID and name match
     * @param $collectionID
     * @param $colName
     * @return mixed
     */
    function getAttributeID($collectionID, $colName)
    {
        $sql = "SELECT attributeID From `collectionAttributes` 
                WHERE collectionID = '$collectionID' 
                AND attributeName = '$colName'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["attributeID"];
    }

    /**
     * delets the item associated with $itemID along with its attribute values
     * @param $itemID
     */
    function deleteItem($itemID)
    {
        $sql = "DELETE FROM `collectionItems` 
                WHERE itemID = '$itemID'";
        $statement = $this->_cnxn->prepare($sql);
        $statement->execute();

        $sql2 = "DELETE FROM `itemAttributeValue` 
                WHERE itemID = '$itemID'";
        $statement2 = $this->_cnxn->prepare($sql2);
        $statement2->execute();
    }

    /**
     * deletes collection associated with the $collectionID
     * @param $collectionID
     */
    function deleteCollection($collectionID)
    {
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

        $sql3 = "DELETE FROM `userCollections` 
                 WHERE collectionID = '$collectionID'";
        $statement3 = $this->_cnxn->prepare($sql3);
        $statement3->execute();
    }
}