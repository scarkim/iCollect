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
                $id = $this->_db->addNewUser($_SESSION["user"], $_POST["password"]);
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
                $this->_f3->set("name", trim($_POST["title"]));
                $this->_f3->set("description", trim($_POST["description"]));

                $isValid = true;

                if (!$this->_validator->validCollectionName(trim($_POST["title"]))) {
                    $this->_f3->set("errors['invalidCollectionName']", "No special characters, not empty and less than 50.");
                    $isValid = false;
                }

                if (!$this->_validator->validCollectionDescription(trim($_POST["description"]))) {
                    $this->_f3->set("errors['invalidCollectionDescription']", "Only regular punctuation and less than 200.");
                    $isValid = false;
                }

                if ($isValid) {
                    if (isset($_POST["add-attributes"])) {
                        $_SESSION["collection"] =
                            new PremiumCollection(trim($_POST["title"]), trim($_POST["description"]), "1");
                    } else {
                        $_SESSION["collection"] =
                            new Collection(trim($_POST["title"]), trim($_POST["description"]), "0");
                    }

                    $_SESSION["collection"]->setCollectionID($this->_db->addCollection($_SESSION["collection"]));
                    if ($_SESSION["collection"]->getCollectionID() === null) {
                        $this->_f3->set("errors['addCollection']",
                            "Sorry, there was an error adding collection to the database");
                    } else {
                        $this->_f3->reroute('/success');
                    }
                }
            }
        }
        $view = new Template();
        echo $view->render("views/create-collection.html");
    }

    public function showCollection($collID){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
//            get post values, call db function
            $isValid = true;
            if (!$this->_validator->validCollectionName($_POST["name"])) {
                $this->_f3->set("errors['invalidCollectionName']", "No special characters please.");
                $isValid = false;
            }

            if(!$this->_validator->validCollectionDescription($_POST["description"])){
                $this->_f3->set("errors['invalidCollectionDescription']", "Only regular punctuation please.");
                $isValid = false;
            }
            if($isValid) {
                $this->_f3->set("name", $_POST["name"]);
                $this->_f3->set("description", $_POST["description"]);
                //$this->_f3->set("image", $_POST["image"]); //adding later
                $this->_db->insertItem($_POST["name"], $_POST["description"], $collID);
            }

        }
        if ($collID === "index.php") {
            $this->_f3->reroute('/');
        }
        $collection = $this->_db->getCollection($collID);
        if ($collection) {
            if ($collection["premium"] == "0") {
                $_SESSION["collection"] = new Collection();
            } else {
                $_SESSION["collection"] = new PremiumCollection();
            }
            $_SESSION["collection"]->setName($collection["collectionName"]);
            $_SESSION["collection"]->setDescription($collection["collectionDescription"]);
            $_SESSION["collection"]->setPremium($collection["premium"]);
            $_SESSION["collection"]->setCollectionID($collection["collectionID"]);
            $this->_f3->set("itemsRepeat", $this->_db->getCollectionItems($_SESSION["collection"]->getCollectionID()));
        }
        $view = new Template();
        echo $view->render("views/collection-view.html");
    }

    public function success() {

        if (!isset($_SESSION["user"])) {
            $this->_f3->reroute('/');
        }

        if (isset($_SESSION["collection"])) {
            $_SESSION['page']="Collection Image Upload";
        } else {
            $_SESSION['page']="Profile Image Upload";
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $target_dir = "uploads/";
            $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);

            $imageFileType = strtolower(pathinfo($target_file,
                PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if (isset($_POST["submit"]) AND
                !empty($_FILES["fileToUpload"]["tmp_name"])) {

                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                $uploadOk = true;

                if($imageFileType != "jpg" && $imageFileType != "png" &&
                    $imageFileType != "jpeg") {
                    $this->_f3->set("errors['fileFormat']",
                        "Sorry, only JPG, JPEG, PNG files are allowed.");
                    $uploadOk = false;
                } elseif ($check === false) {
                    $this->_f3->set("errors['fileExists']",
                        "Not recognized as an image.");
                    $uploadOk = false;
                }

                if ($uploadOk) {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],
                        $target_file)) {

                        if ($_SESSION["page"] === "Collection Image Upload") {
                            $_SESSION["collection"]->setCollectionImage($target_file);
                            $this->_db->addCollectionImage($_SESSION["collection"]->getCollectionID(), $target_file);
                            $this->_f3->reroute('/'.$_SESSION["collection"]->getCollectionID());
                        }

                        $_SESSION["user"]->setProfileImg($target_file);
                        //$this->_f3->set("profileImage", $target_file);
                        $this->_db->addImage($_SESSION["user"]->getUserID(), $target_file);
                        $this->_f3->reroute('/welcome');

                    } else {
                        $this->_f3->set("errors['fileUpload']",
                            "Sorry, there was an error uploading your file.");
                    }
                }
            } else {
                $this->_f3->set("errors['fileExists']", "No file.");
            }
            //if skip was pressed
            if (isset($_POST["skip"])) {
                $this->_f3->reroute('/welcome');
            }
        }

        $view = new Template();
        echo $view->render("views/success.html");
    }

    public function logout() {
        unset($_SESSION["user"]);
        unset($_SESSION["collection"]);
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