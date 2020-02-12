<?php
//Start a session
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Required files
require_once('vendor/autoload.php');
require ("../../../connection.php");
require_once('model/validate.php');

//Instantiate Fat-Free
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

$f3->route("GET /", function (){
    $_SESSION['page']="iCollect";
    $view = new Template();
    echo $view->render("views/home.html");
});

$f3->route("GET|POST /signup", function ($f3, $cnxn) {

    $_SESSION['page']="iCollect Signup";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $isValid = true;
        $f3->set("username", $_POST["username"]);
        $f3->set("password", $_POST["password"]);
        $f3->set("email", $_POST["email"]);
        $f3->set("accountType", $_POST["accountType"]);

        if ($cnxn) {
            if (validUserName($_POST["username"])) {
                $_SESSION["username"] = $_POST["username"];
            } else {
                $f3->set("errors['username']", "Please choose another name.");
                $isValid = false;
            }

            if (validEmail($_POST["email"])) {
                $_SESSION["email"] = $_POST["email"];
            } else {
                $f3->set("errors['email']", "Please choose another email.");
                $isValid = false;
            }
        } else {
            $f3->set("errors['connection']", "No Connection.");
            $isValid = false;
        }

        //all inputs valid and user is added to the database, go to next page
        if ($isValid) {
            $_SESSION["password"] = $_POST["password"];
            $_SESSION["accountType"] = $_POST["accountType"];
            if(addNewUser()) {
                $f3->reroute('/confirm');
            } else {
                $f3->set("errors['addNewUser']", "Something went wrong try again.");
            }
        }
    }

    $view = new Template();
    echo $view->render("views/signup.html");
});

$f3->route("GET|POST /login", function ($f3, $cnxn){
<<<<<<< HEAD

=======
>>>>>>> 94662377aa6c1809750c808783600ba8b9ab5781
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $isValid = true;
        $f3->set("username", $_POST["username"]);
        $f3->set("password", $_POST["password"]);

        if ($cnxn) {
            if (validLogin($_POST["username"], $_POST["password"])) {
                $_SESSION["username"] = $_POST["username"];
            } else {
                $f3->set("errors['login']", "Try again.");
                $isValid = false;
            }
        } else {
            $f3->set("errors['connection']", "No Connection.");
            $isValid = false;
        }

        if ($isValid) {
            $f3->reroute('/createcollection');
        }
    }
    $view = new Template();
    echo $view->render("views/login.html");
});

$f3->route("GET /createcollection", function (){
    $view = new Template();
    echo $view->render("views/create-collection.html");
});

$f3->route("GET /confirm", function ($f3){
    $view = new Template();
    echo $view->render("views/success.html");
});

//Run Fat-Free
$f3->run();