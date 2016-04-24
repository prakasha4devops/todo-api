<?php

namespace Tests\AppBundle\Entity; 

/**
 * Dummy entity for test purposes 
 * 
 * @author Rémi Houdelette <b0ulzy.todo@gmail.com>
 */
class Dummy 
{
    /**
     * @var integer
     */
    private $id; 

    /**
     * @var string
     */
    private $name; 

    /**
     * Get ID
     * 
     * @return integer
     */
    public function getId() 
    {
        return $this->id; 
    } 

    /**
     * Set ID
     * 
     * @param integer $id
     * @return self
     */
    public function setId($id) 
    {
        $this->id = $id; 

        return $this; 
    }

    /**
     * Get name
     * 
     * @return string
     */
    public function getName() 
    {
        return $this->name; 
    } 

    /**
     * Set name
     * 
     * @param string $name
     * @return self
     */
    public function setName($name) 
    {
        $this->name = $name; 

        return $this; 
    }
}

