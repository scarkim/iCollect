<?php

class Collection
{
    private $_collectionID;
    private $_name;
    private $_description;
    private $_premium;

    /**
     * Collection constructor.
     * @param $_name
     * @param $_description
     * @param $_premium
     */
    public function __construct($_name, $_description, $_premium)
    {
        $this->_name = $_name;
        $this->_description = $_description;
        $this->_premium = $_premium;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     * Collection's title (required)
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     *  Collection's general description (optional)
     */
    public function getDescription()
    {
        return $this->_description;
    }/**
 * @return mixed
 */
    public function getCollectionID()
    {
        return $this->_collectionID;
    }
    /**
     * @param mixed $collectionID
     */
    public function setCollectionID($collectionID)
    {
        $this->_collectionID = $collectionID;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

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
}