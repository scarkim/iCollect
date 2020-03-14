<?php

/**
 * Class User creates a user object
 */
class User
{
    /**
     * The user's ID
     * @var int
     */
    private $_userID;
    /**
     * The user's username
     * @var string
     */
    private $_username;

    /**
     * The user's premium status
     * @var int
     */
    private $_premium;
    /**
     * The user's email
     * @var string
     */
    private $_userEmail;
    /**
     * The user's profile image (optional)
     * @var string
     */
    private $_profileImg;

    /**
     * User constructor.
     * @param null $username
     * @param $premium
     * @param $userEmail
     */
    public function __construct($username = null,  $premium=null, $userEmail=null)
    {
        $this->_username = $username;
        $this->_premium = $premium;
        $this->_userEmail = $userEmail;
    }

    /**
     * returns the user's profile picture
     * @return mixed
     */
    public function getProfileImg()
    {
        return $this->_profileImg;
    }

    /**
     * sets the user's profile picture (optional)
     * @param mixed $profileImg
     */
    public function setProfileImg($profileImg)
    {
        $this->_profileImg = $profileImg;
    }

    /**
     * returns the user's ID
     * @return mixed
     */
    public function getUserID()
    {
        return $this->_userID;
    }

    /**
     * sets the user's ID
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->_userID = $userID;
    }

    /**
     * returns the username
     * @return mixed username
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * sets the username
     * @param $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return int
     * returns whether or not the user is a premium user
     */
    public function getPremium()
    {
        return $this->_premium;
    }

    /**
     * @param mixed $premium
     * set status of user's premium (0 or 1)
     */
    public function setPremium($premium)
    {
        $this->_premium = $premium;
    }

    /**
     * returns user's email
     * @return string
     */
    public function getUserEmail()
    {
        return $this->_userEmail;
    }

    /**
     * sets user's email
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->_userEmail = $userEmail;
    }
}