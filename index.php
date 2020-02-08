<?php
//Start a session
session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Required file
require_once('vendor/autoload.php');
//require_once('model/validate.php');

//Instantiate Fat-Free
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

$f3->route("GET /", function (){
    $view = new Template();
    echo $view->render("views/home.html");
});

$f3->route("GET|POST /signup", function (){
/*username
password
email
accountType*/

    $view = new Template();
    echo $view->render("views/signup.html");
});

$f3->route("GET /createcollection", function (){
    $view = new Template();
    echo $view->render("views/create-collection.html");
});
$f3->route("GET /login", function (){
    $view = new Template();
    echo $view->render("views/login.html");
});
//Run Fat-Free
$f3->run();