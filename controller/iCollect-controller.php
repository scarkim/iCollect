<?php

class ICollectController {
    private $_f3;
    private $_validator;
    private $_db;
    private $_user;

    public function __construct()
    {
        //Instantiate Fat-Free
        $this->_f3 = Base::instance();
        $this->_validator = new Validate();
        $this->_db = new Database();
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

            if ($this->_db) {
                if (!$this->_validator->validLogin($_POST["username"])) {
                    $this->_f3->set("errors['invalidLogin']", "*invalid username.");
                    $isValid = false;
                }

                if (!$this->_db->checkCredentials($_POST["username"], $_POST['password'])) {
                    $this->_f3->set("errors['login']", "Try again.");
                    $isValid = false;
                }

            } else {
                $this->_f3->set("errors['connection']", "No Connection.");
                $isValid = false;
            }

            if ($isValid) {
                $_SESSION["user"] = $this->_db->getUser($_POST["username"]);
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

            $_SESSION["user"] = new User();

            if ($this->_f3->exists("errors['username']")) {
                $this->_f3->clear("errors['username']");
            }

            if ($this->_f3->exists("errors['email']")) {
                $this->_f3->clear("errors['email']");
            }

            if ($this->_db) {
                if (!$this->_validator->validLogin($_POST["username"]) OR $this->_db->containsUsername($_POST["username"])) {
                    $this->_f3->set("errors['username']", "Please choose another name.");
                    $isValid = false;
                }

                if (!$this->_validator->validEmail($_POST["email"]) OR $this->_db->containsEmail($_POST["email"]) ) {
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
                $_SESSION["user"]->setUsername($_POST["username"]);
                $_SESSION["user"]->setUserEmail($_POST["email"]);
                $_SESSION["user"]->setPremium($_POST["accountType"]);
                $id = $this->_db->addNewUser($this->_user, $_POST["password"]);
                if($id != null) {
                    $_SESSION["user"]->setUserID($id);
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


        if (!isset($_SESSION["user"])) {
            $this->_f3->reroute('/');
        }

        $_SESSION['page']="Welcome";
//        var_dump($this->_db->getCollections($_SESSION["user"]->getUserID()));
        $this->_f3->set("collectionsRepeat", $this->_db->getCollections($_SESSION["user"]->getUserID()));
        $view = new Template();
        echo $view->render("views/welcome.html");
    }

    public function createCollection() {
        $_SESSION['page']="Create Collection";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST["create"])) {
                $this->_f3->set("name", $_POST["title"]);
                $this->_f3->set("description", $_POST["description"]);

                $isValid = true;

                if (!$this->_validator->validCollectionName($_POST["title"])) {
                    $this->_f3->set("errors['invalidCollectionName']", "No special characters please.");
                    $isValid = false;
                }

                if (!$this->_validator->validCollectionDecription($_POST["description"])) {
                    $this->_f3->set("errors['invalidCollectionDescription']", "Only regular punctuation please.");
                    $isValid = false;
                }

                if ($isValid) {
                    if (isset($_POST["add-attributes"])) {
                        $_SESSION["collection"] =
                            new PremiumCollection($_POST["title"], $_POST["description"], "1");
                    } else {
                        $_SESSION["collection"] =
                            new Collection($_POST["title"], $_POST["description"], "0");
                    }

                    $_SESSION["collection"]->setCollectionID($this->_db->addCollection($_SESSION["collection"]));
                    if ($_SESSION["collection"]->getCollectionID() === null) {

                        //$this->_f3->reroute('/collection'); //new route and view not added
                        $this->_f3->set("errors['addCollection']",
                            "Sorry, there was an error adding collection to the database");
                    } else {
                        $this->_f3->set("errors['addCollection']", "Success! CollID:".$_SESSION["collection"]->getCollectionID());
//                            $_SESSION['collectionName'] = $_POST["title"];
                        $this->_f3->set("collection['name']", $_POST["title"] );
                            $this->_f3->reroute('/collection/@item');
                    }
                 }
            }
        }
        $view = new Template();
        echo $view->render("views/create-collection.html");
    }



    public function showCollection($collID){
        $collection = $this->_db->getCollection($collID);
        if ($collection[0]["premium"] == "0") {
            $_SESSION["collection"] = new Collection();
        } else {
            $_SESSION["collection"] = new PremiumCollection();
        }
        $view = new Template();
        echo $view->render("views/collection-view.html");
    }
    public function addItem() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $isValid = true;
            $_SESSION['page'] = "Add an item to your collection";
            $this->_f3->set("id", ""); //change this to the auto incrementing id
            $this->_f3->set("name", $_POST["name"]);
            $this->_f3->set("description", $_POST["description"]);
//            $this->_f3->set("image", $_POST["image"]); //adding later
            $this->_db->insertItem($_POST["name"], $_POST["description"], " ", 1);
        }
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