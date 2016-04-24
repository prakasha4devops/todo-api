<?php

/*
 * This file is part of the TODO REST API package.
 *
 * (c) Rémi Houdelette <https://github.com/B0ulzy>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
