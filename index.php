<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Required files
require_once('vendor/autoload.php');
require_once('model/validate.php');
//Start a session
session_start();

$iController = new ICollectController();

$iController->getF3()->route("GET /", function (){
    global $iController;
    $iController->home();
});

$iController->getF3()->route("GET|POST /signup", function () {
    global $iController;
    $iController->signup();
});

$iController->getF3()->route("GET|POST /login", function (){
    global $iController;
    $iController->login();
});

$iController->getF3()->route("GET /welcome", function (){
    global $iController;
    $iController->welcome();
});

$iController->getF3()->route("GET /createcollection", function (){
    global $iController;
    $iController->createCollection();
});
$iController->getF3()->route("GET /addItem", function (){
    global $iController;
    $iController->addItem();
});

$iController->getF3()->route("GET /success", function (){
    global $iController;
    $iController->success();
});

$iController->getF3()->route("GET|POST /logout", function (){
    global $iController;
    $iController->logout();
});

//Run Fat-Free
$iController->getF3()->run();