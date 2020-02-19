<?php

class ICollectController {
    private $_f3;
    private $_validator;

    public function __construct($f3)
    {
        $this->_f3 = $f3;
        $this->_validator = new Validate();
    }

    public function home() {
        $_SESSION['page']="iCollect";
        $view = new Template();
        echo $view->render("views/home.html");
    }

    public function login() {
        require ("../../../connection.php");
        $_SESSION['page']="iCollect Login";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $isValid = true;
            $this->_f3->set("username", $_POST["username"]);
            $this->_f3->set("password", $_POST["password"]);

            if ($cnxn) {
                if ($this->_validator->validLogin($_POST["username"], $_POST["password"], $cnxn)) {
                    $_SESSION["username"] = $_POST["username"];
                } else {
                    $this->_f3->set("errors['login']", "Try again.");
                    $isValid = false;
                }
            } else {
                $this->_f3->set("errors['connection']", "No Connection.");
                $isValid = false;
            }

            if ($isValid) {
                $this->_f3->reroute('/welcome');
            }
        }
        $view = new Template();
        echo $view->render("views/login.html");
    }

    public function signup() {
        require ("../../../connection.php");
        $_SESSION['page']="iCollect Signup";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $isValid = true;
            $this->_f3->set("username", $_POST["username"]);
            $this->_f3->set("password", $_POST["password"]);
            $this->_f3->set("email", $_POST["email"]);
            $this->_f3->set("accountType", $_POST["accountType"]);

            if ($cnxn) {
                if ($this->_validator->validUserName($_POST["username"], $cnxn)) {
                    $_SESSION["username"] = $_POST["username"];
                } else {
                    $this->_f3->set("errors['username']", "Please choose another name.");
                    $isValid = false;
                }

                if ($this->_validator->validEmail($_POST["email"], $cnxn)) {
                    $_SESSION["email"] = $_POST["email"];
                } else {
                    $this->_f3->set("errors['email']", "Please choose another email.");
                    $isValid = false;
                }
            } else {
                $this->_f3->set("errors['connection']", "No Connection.");
                $isValid = false;
            }

            //all inputs valid and user is added to the database, go to next page
            if ($isValid) {
                $_SESSION["password"] = $_POST["password"];
                $_SESSION["accountType"] = $_POST["accountType"];
                if($this->_validator->addNewUser($cnxn)) {
                    $this->_f3->reroute('/success');
                } else {
                    $this->_f3->set("errors['addNewUser']", "Something went wrong try again.");
                }
            }
        }

        $view = new Template();
        echo $view->render("views/signup.html");
    }

    public function welcome() {
        $_SESSION['page']="Welcome";
        $view = new Template();
        echo $view->render("views/welcome.html");
    }

    public function createCollection() {
        $_SESSION['page']="Create Collection";
        $view = new Template();
        echo $view->render("views/create-collection.html");
    }

    public function success() {
        $_SESSION['page']="Sign Up Success";
        $view = new Template();
        echo $view->render("views/success.html");
    }
}