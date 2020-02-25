<?php

/**
 * Class PremiumCollection
 */
class PremiumCollection Extends Collection
{

    private $_attributes;
    //Parameterized constructor

    function __construct($_name, $_description, $_premium)
    {
        parent::__construct($_name, $_description, $_premium);
    }
    function setAttributeValues($att)
    {
         $this->_attributes = $att;
    }
    function getAttributeValues()
    {
        return $this->_attributes;
    }
}