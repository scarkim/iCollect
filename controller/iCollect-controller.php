<?php

class ICollectController {
    private $_f3;
    private $_validator;
    private $_cnxn;
    private $_user;

    public function __construct()
    {
        //Instantiate Fat-Free
        $this->_f3 = Base::instance();
        $this->_validator = new Validate();
        $this->_cnxn = new Database();
        //Turn on Fat-Free error reporting
        $this->_f3->set('DEBUG', 3);
    }

    public function home()
    {
        $_SESSION['page']="iCollect";
        $view = new Template();
        echo $view->render("views/home.html");
    }

    public function login()
    {
        $_SESSION['page']="iCollect Login";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $isValid = true;
            $this->_f3->set("username", $_POST["username"]);
            $this->_f3->set("password", $_POST["password"]);

            if ($this->_cnxn) {
                if ($this->_validator->validLogin($_POST["username"]) AND
                    $this->_cnxn->checkCredentials($_POST["username"], $_POST['password'])) {

                    $this->_user = $this->_cnxn->getUser($_POST["username"]);
                    $_SESSION["user"] = $this->_user;
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
        $_SESSION['page']="iCollect Signup";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $isValid = true;
            $this->_f3->set("username", $_POST["username"]);
            $this->_f3->set("password", $_POST["password"]);
            $this->_f3->set("password2", $_POST["password2"]);
            $this->_f3->set("email", $_POST["email"]);
            $this->_f3->set("accountType", $_POST["accountType"]);

            $this->_user = new User();

            if ($this->_f3->exists("errors['username']")) {
                $this->_f3->clear("errors['username']");
            }

            if ($this->_f3->exists("errors['email']")) {
                $this->_f3->clear("errors['email']");
            }

            if ($this->_cnxn) {
                if (!$this->_validator->validLogin($_POST["username"]) OR $this->_cnxn->containsUsername($_POST["username"])) {
                    $this->_f3->set("errors['username']", "Please choose another name.");
                    $isValid = false;
                }

                if (!$this->_validator->validEmail($_POST["email"]) OR $this->_cnxn->containsEmail($_POST["email"]) ) {
                    $this->_f3->set("errors['email']", "Please choose another email.");
                    $isValid = false;
                }

                if ($this->_validator->validPassword($_POST["password"])) {
                    if (!$this->_validator->passwordMatch($_POST["password"], $_POST["password2"])) {
                        $this->_f3->set("errors['passwordMatch']", "*not a match");
                        $isValid = false;
                    }
                } else {
                    $this->_f3->set("errors['password']", "*required");
                    $isValid = false;
                }

                if (!$this->_validator->validateAcctType($_POST["accountType"])) {
                    $this->_f3->set("errors['acctType']", "I don't think so");
                    $isValid = false;
                }
            } else {
                $this->_f3->set("errors['connection']", "No Connection.");
                $isValid = false;
            }

            //all inputs valid and user is added to the database, go to next page
            if ($isValid) {
                $this->_user->setUsername($_POST["username"]);
                $this->_user->setUserEmail($_POST["email"]);
                $this->_user->setPremium($_POST["accountType"]);
                $id = $this->_cnxn->addNewUser($this->_user, $_POST["password"]);
                if($id != null) {
                    $this->_user->setUserID($id);
                    $_SESSION["user"] = $this->_user;
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
        if (!isset($_SESSION["user"])) {
            $this->_f3->reroute('/');
        }

        $view = new Template();
        echo $view->render("views/welcome.html");
    }

    public function createCollection() {
        $_SESSION['page']="Create Collection";
        $view = new Template();
        echo $view->render("views/create-collection.html");
    }
    public function addItem() {
        $_SESSION['page']="Add an item to your collection";
        $view = new Template();
        echo $view->render("views/add-item.html");
    }

    public function success() {
        $_SESSION['page']="Sign Up Success";

        if (!isset($_SESSION["user"])) {
            $this->_f3->reroute('/');
        }

        $view = new Template();
        echo $view->render("views/success.html");
    }

    public function logout() {
        unset($_SESSION["user"]);
        $this->_f3->reroute('/');
    }

    /**
     * @return Base
     */
    public function getF3()
    {
        return $this->_f3;
    }
}