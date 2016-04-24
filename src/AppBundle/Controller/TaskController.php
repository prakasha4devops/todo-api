<?php

namespace AppBundle\Controller; 

use AppBundle\Util\ValueToBooleanConverter; 
use FOS\RestBundle\Controller\FOSRestController; 
use FOS\RestBundle\Controller\Annotations\RequestParam; 
use FOS\RestBundle\Request\ParamFetcher; 
use FOS\RestBundle\Routing\ClassResourceInterface; 
use Nelmio\ApiDocBundle\Annotation\ApiDoc; 
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; 

/**
 * Controller for task actions
 * 
 * @author Rémi Houdelette <b0ulzy.todo@gmail.com> 
 */
class TaskController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Get tasks
     * 
     * @return array
     * 
     * @ApiDoc(
     *      description="Returns a collection of Task", 
     *      statusCodes = {
     *          200 = "Returned when successful"
     *      }
     * )
     */
    public function cgetAction() 
    {
        return $this->getTaskManager()->findAll(); 
    } 

    /**
     * Get a task by its identifier
     * 
     * @param integer $id
     * @return Task 
     * @throws NotFoundHttpException The task cannot be found.
     * 
     * @ApiDoc(
     *      description="Returns a Task by its identifier", 
     *      output = "AppBundle\Entity\Task", 
     *      statusCodes = {
     *          200 = "Returned when successful", 
     *          404 = "Returned when the Task cannot be found"
     *      }
     * )
     */
    public function getAction($id) 
    {
        $task = $this->getTaskManager()->find($id); 

        if ($task === null) {
            throw $this->createNotFoundException(sprintf('The task with ID %s cannot be found.', $id)); 
        } 

        return $task; 
    } 

    /**
     * Create a new task 
     * 
     * @return Task 
     * 
     * @RequestParam(name="label", description="Task label.") 
     * @RequestParam(name="due_date", nullable=true, description="Task due date.") 
     * 
     * @ApiDoc(
     *      description="Create and returns a new Task", 
     *      output = "AppBundle\Entity\Task", 
     *      statusCodes = {
     *          200 = "Returned when successful", 
     *          400 = "Returned when one or more parameters are missing or incorrect"
     *      }
     * )
     */
    public function postAction(ParamFetcher $paramFetcher) 
    {
        $label = $paramFetcher->get('label'); 
        $dueDate = $paramFetcher->get('due_date'); 

        $taskManager = $this->getTaskManager(); 

        $task = $taskManager->create(); 
        $task->setLabel($label); 

        if ($dueDate !== null) {
            $task->setDueDate(\DateTime::createFromFormat($this->getParameter('app.date_format'), $dueDate)); 
        } 

        $taskManager->save($task); 

        return $task; 
    }

    /**
     * Update a task 
     * 
     * @param integer $id
     * @return Task
     * @throws NotFoundHttpException The task cannot be found.
     * 
     * @RequestParam(name="label", description="Task label.") 
     * @RequestParam(name="done", description="True if the task is done, false otherwise.") 
     * @RequestParam(name="due_date", description="Task due date.") 
     * 
     * @ApiDoc(
     *      description="Update a Task", 
     *      output = "AppBundle\Entity\Task", 
     *      statusCodes = {
     *          200 = "Returned when successful", 
     *          400 = "Returned when one or more parameters are missing or incorrect", 
     *          404 = "Returned when the Task cannot be found"
     *      }
     * )
     */
    public function putAction(ParamFetcher $paramFetcher, $id) 
    {
        $taskManager = $this->getTaskManager(); 

        $task = $taskManager->find($id); 

        if ($task === null) {
            throw $this->createNotFoundException(sprintf('The task with ID %s cannot be found.', $id)); 
        } 

        $params = $paramFetcher->all();

        $task->setLabel($params['label']) 
             ->setDone(ValueToBooleanConverter::convert($params['done'])); 

        if (empty($params['due_date']) === true) {
            $task->removeDueDate(); 
        } else {
            $task->setDueDate(\DateTime::createFromFormat($this->getParameter('app.date_format'), $params['due_date'])); 
        } 

        $taskManager->save($task); 

        return $task; 
    } 

    /**
     * Update partially a task
     * 
     * @param integer $id
     * @return Task
     * @throws NotFoundHttpException The task cannot be found.
     * 
     * @RequestParam(name="label", nullable=true, description="Task label.") 
     * @RequestParam(name="done", nullable=true, description="True if the task is done, false otherwise.") 
     * @RequestParam(name="due_date", nullable=true, description="Task due date.") 
     * 
     * @ApiDoc(
     *      description="Update partially a Task", 
     *      output = "AppBundle\Entity\Task", 
     *      statusCodes = {
     *          200 = "Returned when successful", 
     *          400 = "Returned when one or more parameters are missing or incorrect", 
     *          404 = "Returned when the Task cannot be found"
     *      }
     * )
     */
    public function patchAction(ParamFetcher $paramFetcher, $id) 
    {
        $taskManager = $this->getTaskManager(); 

        $task = $taskManager->find($id); 

        if ($task === null) {
            throw $this->createNotFoundException(sprintf('The task with ID %s cannot be found.', $id)); 
        } 

        $params = $paramFetcher->all(); 

        if ($params['label'] !== null) {
            $task->setLabel($params['label']); 
        } 

        if ($params['done'] !== null) {
            $task->setDone(ValueToBooleanConverter::convert($params['done'])); 
        } 

        if ($params['due_date'] !== null) {
            if (empty($params['due_date']) === true) {
                $task->removeDueDate(); 
            } else {
                $task->setDueDate(\DateTime::createFromFormat($this->getParameter('app.date_format'), $params['due_date'])); 
            }
        }

        $taskManager->save($task); 

        return $task; 
    } 

    /**
     * Delete a task
     * 
     * @param integer $id
     * @return null
     * @throws NotFoundHttpException The task cannot be found.
     * 
     * @ApiDoc(
     *      description="Delete a Task", 
     *      output = "AppBundle\Entity\Task", 
     *      statusCodes = {
     *          204 = "Returned when successful", 
     *          404 = "Returned when the Task cannot be found"
     *      }
     * )
     */
    public function deleteAction($id) 
    {
        $taskManager = $this->getTaskManager(); 

        $task = $taskManager->find($id); 

        if ($task === null) {
            throw $this->createNotFoundException(sprintf('The task with ID %s cannot be found.', $id)); 
        } 

        $taskManager->delete($task); 

        return null; 
    } 

    /**
     * Get task manager
     * 
     * @return \AppBundle\Manager\EntityManager
     */
    protected function getTaskManager() 
    {
        return $this->get('task_manager'); 
    }
}
