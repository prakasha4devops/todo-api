<?php

/*
 * This file is part of the TODO REST API package.
 *
 * (c) Rémi Houdelette <https://github.com/B0ulzy>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity; 

use Doctrine\ORM\Mapping as ORM; 

/**
 * Entity representing a task to do
 * 
 * @author Rémi Houdelette <b0ulzy.todo@gmail.com>
 * 
 * @ORM\Entity
 */
class Task 
{
    /**
     * @var integer 
     * 
     * @ORM\Id
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue(strategy="AUTO") 
     */
    protected $id; 

    /**
     * @var string 
     * 
     * @ORM\Column(type="string") 
     */
    protected $label; 

    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean", options={"default"=false}) 
     */
    protected $done; 

    /**
     * @var \DateTime|null
     * 
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dueDate; 

    public function __construct() 
    {
        $this->done = false; 
    } 

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
     * Get label
     * 
     * @return string
     */
    public function getLabel() 
    {
        return $this->label; 
    } 

    /**
     * Set label
     * 
     * @param string $label
     * @return self
     */
    public function setLabel($label) 
    {
        $this->label = $label; 

        return $this; 
    } 

    /**
     * Is the task done?
     * 
     * @return boolean
     */
    public function isDone() 
    {
        return $this->done; 
    } 

    /**
     * Defines the task status
     * 
     * @param boolean $done
     * @return self
     */
    public function setDone($done) 
    {
        $this->done = (boolean) $done; 

        return $this; 
    } 

    /**
     * Has the task a due date?
     * 
     * @return boolean
     */
    public function hasDueDate() 
    {
        return ($this->dueDate instanceof \DateTime); 
    }

    /**
     * Get due date
     * 
     * @return \DateTime|null
     */
    public function getDueDate() 
    {
        return $this->dueDate; 
    } 

    /**
     * Set due date
     * 
     * @param \DateTime $dueDate
     * @return self
     */
    public function setDueDate(\DateTime $dueDate) 
    {
        $this->dueDate = $dueDate; 

        return $this; 
    } 

    /**
     * Remove due date
     * 
     * @return self
     */
    public function removeDueDate() 
    {
        $this->dueDate = null; 

        return $this; 
    }
}
