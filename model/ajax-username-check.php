<?php
require ("../../../../connection.php");
try {
    $db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

} catch (PDOException $e) {
    echo $e->getMessage();
}

if(isset($_POST["username"])) {

    $username = $_POST["username"];

    if(ctype_alnum($username)) {

        $sql = "SELECT * FROM `users` WHERE userName='$username'";
        $statement = $db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "Username taken";
        } else {
            echo "Username available";
        }
    } else {
        echo "alpha-numeric only ";
    }
} elseif (isset($_POST["email"])) {
    $email = $_POST["email"];

    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $sql = "SELECT * FROM `users` WHERE userEmail='$email'";
        $statement = $db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "Email taken";
        } else {
            echo "Email available";
        }
    }
}
