<?php
require ("../../../../connection.php");
try {
    $db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

} catch (PDOException $e) {
    echo $e->getMessage();
}

if(isset($_POST["username"])) {

    $username = $_POST["username"];
    $title = $_POST["title"];

    if(ctype_alnum($username)) {

        $sql = "SELECT * FROM `users` WHERE userName='$username'";
        $statement = $db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if ($title === "iCollect Signup") {
                echo "Username taken";
            } else {
                echo "Username exists";
            }
        } else {
            if ($title === "iCollect Signup") {
                echo "Username available";
            } else {
                echo "Username doesn't exist";
            }
        }
    } else {
        echo "alpha-numeric only ";
    }
} elseif (isset($_POST["email"])) {
    $email = $_POST["email"];
    $title = $_POST["title"];

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
