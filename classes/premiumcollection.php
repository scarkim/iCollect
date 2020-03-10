<?php

/**
 * Class PremiumCollection
 */
class PremiumCollection Extends Collection
{

    private $_attributes;

    //Parameterized constructor
    function __construct($_name=null, $_description=null, $_premium=null)
    {
        parent::__construct($_name, $_description, $_premium);
        $this->_attributes = array();
    }

    function getAttributes()
    {
        return $this->_attributes;
    }

    public function setAttributes($attributes)
    {
        $this->_attributes = $attributes;
    }

    function addAttribute($attrID, $attrName) {
        $this->_attributes[$attrID] = $attrName;
    }
}