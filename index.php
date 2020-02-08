<?php
//Start a session
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Required file
require_once('vendor/autoload.php');
require ("connection.php");
require_once('model/validate.php');

//Instantiate Fat-Free
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

$f3->route("GET /", function (){
    $view = new Template();
    echo $view->render("views/home.html");
});


$f3->route("GET|POST /signup", function ($f3, $cnxn) {

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
                $_SESSION["email"] = $_POST["username"];
            } else {
                $f3->set("errors['email']", "Please choose another email.");
                $isValid = false;
            }
        } else {
            $f3->set("errors['connection']", "No Connection.");
            $isValid = false;
        }

        //all inputs valid, go to next page
        if ($isValid) {
            $f3->reroute('/confirm');
        }
    }

    $view = new Template();
    echo $view->render("views/signup.html");
});

$f3->route("GET /createcollection", function (){
    $view = new Template();
    echo $view->render("views/create-collection.html");
});

$f3->route("GET|POST /confirm", function ($f3){
    $view = new Template();
    echo $view->render("views/success.html");
});

$f3->route("GET /login", function (){
    $view = new Template();
    echo $view->render("views/login.html");
});

//Run Fat-Free
$f3->run();