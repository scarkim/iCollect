<?php
class User
{

    private $_userID;
    private $_username;
    //private $_password;
    private $_premium;
    private $_userEmail;

    /**
     * User constructor.
     * @param $username
     * @param $password
     * @param $premium
     * @param $userEmail
     */
    public function __construct($username = null, /*$password=null,*/ $premium=null, $userEmail=null)
    {
        $this->_username = $username;
        //$this->_password = $password;
        $this->_premium = $premium;
        $this->_userEmail = $userEmail;
    }
    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->_userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->_userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return mixed
     */
    /*public function getPassword()
    {
        return $this->_password;
    }*/

    /**
     * @param mixed $password
     */
    /*public function setPassword($password)
    {
        $this->_password = $password;
    }*/

    /**
     * @return mixed
     */
    public function getPremium()
    {
        return $this->_premium;
    }

    /**
     * @param mixed $premium
     */
    public function setPremium($premium)
    {
        $this->_premium = $premium;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->_userEmail;
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->_userEmail = $userEmail;
    }


}