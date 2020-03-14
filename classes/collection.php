<?php

/**
 * Class Collection
 * Creates a collection in which items
 * can be added into
 */
class Collection
{
    /**
     * The ID of the collection
     * Auto incrementing int
     * @var
     */
    private $_collectionID;
    /**
     * Name of collection
     * @var string
     */
    private $_name;
    /**
     * Description of collection
     * @var string
     */
    private $_description;
    /**
     * Whether of not the collection is a premium type
     * @var int
     */
    private $_premium;
    /**
     * Cover image for the collection
     * @var string
     */
    private $_collectionImage;

    /**
     * Returns the cover image of collection
     * @return mixed
     */
    public function getCollectionImage()
    {
        return $this->_collectionImage;
    }

    /**
     * Sets the cover image of collection
     * @param mixed $collectionImage
     */
    public function setCollectionImage($collectionImage)
    {
        $this->_collectionImage = $collectionImage;
    }

    /**
     * Collection constructor.
     * @param $_name
     * @param $_description
     * @param $_premium
     */
    public function __construct($_name=null, $_description=null, $_premium=null)
    {
        $this->_name = $_name;
        $this->_description = $_description;
        $this->_premium = $_premium;
    }

    /**
     * returns name of the collection
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
    }
    /**
    * @return mixed
     * Returns the collections ID (required)
    */
    public function getCollectionID()
    {
        return $this->_collectionID;
    }
    /**
     * @param mixed $collectionID
     * sets the collections ID (required)
     */
    public function setCollectionID($collectionID)
    {
        $this->_collectionID = $collectionID;
    }

    /**
     * @param mixed $description
     * sets the collections description (optional)
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @return mixed
     * returns collection type 0 or 1 (required)
     */
    public function getPremium()
    {
        return $this->_premium;
    }

    /**
     * @param mixed $premium
     * sets the collection type 0 or 1 (required)
     */
    public function setPremium($premium)
    {
        $this->_premium = $premium;
    }
}