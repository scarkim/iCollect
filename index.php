<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Required files
require_once('vendor/autoload.php');
require_once('model/validate.php');
//Start a session
session_start();
//Instantiate Fat-Free
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);
$iController = new ICollectController($f3);

$f3->route("GET /", function (){
    global $iController;
    $iController->home();
});

$f3->route("GET|POST /signup", function () {
    global $iController;
    $iController->signup();
});

$f3->route("GET|POST /login", function (){
    global $iController;
    $iController->login();
});

$f3->route("GET /welcome", function (){
    global $iController;
    $iController->welcome();
});

$f3->route("GET /createcollection", function (){
    global $iController;
    $iController->createCollection();
});

$f3->route("GET /success", function (){
    global $iController;
    $iController->success();
});

//Run Fat-Free
$f3->run();