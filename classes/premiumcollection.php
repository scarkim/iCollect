<?php

/**
 * Class PremiumCollection
 * Extends collection class, creates a premium instance of a collection
 */
class PremiumCollection Extends Collection
{
    /**
     * @var array
     */
    private $_attributes;
    /**
     * PremiumCollection constructor.
     * @param null $_name
     * @param null $_description
     * @param null $_premium
     */
    function __construct($_name=null, $_description=null, $_premium=null)
    {
        parent::__construct($_name, $_description, $_premium);
        $this->_attributes = array();
    }

    /**
     * returns attributes of this collection
     * @return array
     */
    function getAttributes()
    {
        return $this->_attributes;
    }

    /**
     * sets the given attributes
     * @param $attributes
     */
    public function setAttributes($attributes)
    {
        $this->_attributes = $attributes;
    }

    /**
     * adds an attribute to the collection given the attribute ID
     * and the attribute name
     * @param $attrID
     * @param $attrName
     */
    function addAttribute($attrID, $attrName)
    {
        $this->_attributes[$attrID] = $attrName;
    }
}