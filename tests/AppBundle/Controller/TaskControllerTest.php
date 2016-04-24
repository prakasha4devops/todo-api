<?php

/*
 * This file is part of the TODO REST API package.
 *
 * (c) Rémi Houdelette <https://github.com/B0ulzy>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Controller; 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response; 

/**
 * Test class for task actions 
 * 
 * @author Rémi Houdelette <b0ulzy.todo@gmail.com>
 */
class TaskControllerTest extends WebTestCase 
{
    /**
     * Test POST method
     */
    public function testPostTask() 
    {
        $client = self::createClient();

        $client->request(Request::METHOD_POST, '/tasks');
        $response = json_decode($client->getResponse()->getContent(), true); 
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode()); 
        $this->assertTrue(is_array($response)); 

        $client->request(Request::METHOD_POST, '/tasks', array('label' => 'Test Task', 'due_date' => date('Y-m-d H:i:s'))); 
        $response = json_decode($client->getResponse()->getContent(), true); 
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode()); 
        $this->assertTrue(is_array($response)); 
    }

    /**
     * Test GET method
     */
    public function testGetTasks() 
    {
        $client = self::createClient();
        $client->request(Request::METHOD_GET, '/tasks');
        $response = json_decode($client->getResponse()->getContent(), true); 

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode()); 
        $this->assertTrue(is_array($response)); 
    } 

    /**
     * Test GET method with ID
     */
    public function testGetTask() 
    {
        $client = self::createClient();
        $client->request(Request::METHOD_GET, '/tasks/0');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode()); 

        $client->request(Request::METHOD_GET, '/tasks');
        $tasks = json_decode($client->getResponse()->getContent(), true); 

        foreach ($tasks as $task) {
            $client->request(Request::METHOD_GET, '/tasks/' . $task['id']); 
            $response = json_decode($client->getResponse()->getContent(), true); 
            $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode()); 
            $this->assertTrue(is_array($response)); 
        }
    } 

    /**
     * Test PUT method
     */
    public function testPutTask() 
    {
        $client = self::createClient();
        $client->request(Request::METHOD_PUT, '/tasks/0');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

        $client->request(Request::METHOD_GET, '/tasks');
        $tasks = json_decode($client->getResponse()->getContent(), true); 

        foreach ($tasks as $task) {
            $client->request(Request::METHOD_PUT, '/tasks/' . $task['id'], array('label' => 'Test Task', 'done' => true, 'due_date' => '')); 
            $response = json_decode($client->getResponse()->getContent(), true); 
            $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode()); 
            $this->assertTrue(is_array($response)); 
        }
        
        
        foreach ($tasks as $task) {
            $client->request(Request::METHOD_PUT, '/tasks/' . $task['id'], array('label' => 'Test Task', 'done' => true, 'due_date' => date('Y-m-d H:i:s'))); 
            $response = json_decode($client->getResponse()->getContent(), true); 
            $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode()); 
            $this->assertTrue(is_array($response)); 
        }
    }

    /**
     * Test PATCH method
     */
    public function testPatchTask() 
    {
        $client = self::createClient();
        $client->request(Request::METHOD_PATCH, '/tasks/0');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

        $client->request(Request::METHOD_GET, '/tasks');
        $tasks = json_decode($client->getResponse()->getContent(), true); 

        foreach ($tasks as $task) {
            $client->request(Request::METHOD_PATCH, '/tasks/' . $task['id'], array('done' => false, 'due_date' => date(''))); 
            $response = json_decode($client->getResponse()->getContent(), true); 
            $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode()); 
            $this->assertTrue(is_array($response)); 
        }

        foreach ($tasks as $task) {
            $client->request(Request::METHOD_PATCH, '/tasks/' . $task['id'], array('label' => 'Task Test', 'due_date' => date('Y-m-d H:i:s'))); 
            $response = json_decode($client->getResponse()->getContent(), true); 
            $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode()); 
            $this->assertTrue(is_array($response)); 
        }
    } 

    /**
     * Test DELETE method
     */
    public function testDeleteTask() 
    {
        $client = self::createClient();
        $client->request(Request::METHOD_DELETE, '/tasks/0');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

        $client->request(Request::METHOD_GET, '/tasks');
        $response = json_decode($client->getResponse()->getContent(), true); 

        foreach ($response as $task) {
            $client->request(Request::METHOD_DELETE, '/tasks/' . $task['id']); 
            $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode()); 
        }
    }
}
