<?php

namespace Tests\AppBundle\Entity; 

use AppBundle\Entity\Task; 

/**
 * Test class for Task entity
 * 
 * @author Rémi Houdelette <b0ulzy.todo@gmail.com>
 */
class TaskTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * Test entity accessors
     */
    public function testAccessors() 
    {
        $label = 'task1'; 
        $task = new Task(); 
        $task->setLabel($label); 

        $this->assertNull($task->getId()); 
        $this->assertEquals($label, $task->getLabel()); 
        $this->assertFalse($task->isDone()); 
        $this->assertFalse($task->hasDueDate()); 
        $this->assertNull($task->getDueDate()); 

        $date = new \DateTime(); 
        $task->setDone(true) 
             ->setDueDate($date); 
        $this->assertTrue($task->isDone()); 
        $this->assertTrue($task->hasDueDate()); 
        $this->assertEquals($date, $task->getDueDate()); 

        $task->removeDueDate(); 
        $this->assertFalse($task->hasDueDate()); 
    } 
}
