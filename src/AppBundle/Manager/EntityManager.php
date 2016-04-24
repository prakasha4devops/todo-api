<?php

/*
 * This file is part of the TODO REST API package.
 *
 * (c) Rémi Houdelette <https://github.com/B0ulzy>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Manager; 

use Doctrine\Common\Persistence\ObjectManager; 
use Doctrine\Common\Persistence\ObjectRepository; 

/**
 * Abstract class to extend for entity or document managers
 * 
 * @author Rémi Houdelette <b0ulzy.todo@gmail.com>
 */
abstract class EntityManager 
{
    /**
     * @var ObjectManager
     */
    protected $om; 

    /**
     * @var string
     */
    protected $className; 

    /**
     * @var ObjectRepository 
     */
    protected $repository; 

    public function __construct(ObjectManager $om, $className) 
    {
        if (substr($className, 0, 1) !== '\\') {
            $className = '\\' . $className; 
        } 

        $this->om = $om; 
        $this->className = $className; 
        $this->repository = $this->om->getRepository($className); 
    } 

    /**
     * Create a new object
     * 
     * @return object
     */
    public function create() 
    {
        $object = new $this->className(); 

        return $object; 
    } 

    /**
     * Save an object
     * 
     * @param object $object
     * @throws \InvalidArgumentException If the object is not supported by the manager
     */
    public function save($object) 
    {
        if ($this->supports($object) === false) {
            throw new \InvalidArgumentException(sprintf(
                'Objects of type %s are not supported by the manager %s. Expected type: %s.', 
                get_class($object), 
                get_class($this), 
                $this->className
            )); 
        } 

        if ($this->om->contains($object) === false) {
            $this->om->persist($object); 
        } 

        $this->om->flush(); 
    } 

    /**
     * Delete an object
     * 
     * @param object $object
     * @throws \InvalidArgumentException If the object is not supported by the manager
     */
    public function delete($object) 
    {
        if ($this->supports($object) === false) {
            throw new \InvalidArgumentException(sprintf(
                'Objects of type %s are not supported by the manager %s. Expected type: %s.', 
                get_class($object), 
                get_class($this), 
                $this->className
            )); 
        } 

        $this->om->remove($object); 
        $this->om->flush(); 
    }

    /**
     * Find an object by its primary key / identifier.
     * 
     * @param integer $id
     * @return object
     */
    public function find($id) 
    {
        return $this->repository->find($id); 
    } 

    /**
     * Find all objects in the repository. 
     * 
     * @return array
     */
    public function findAll() 
    {
        return $this->repository->findAll(); 
    } 

    /**
     * Find objects by a set of criteria. 
     * 
     * @param array $criteria
     * @param array|null $orderBy
     * @param integer|null $limit
     * @param integer|null $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) 
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset); 
    }

    /**
     * Find a single object by a set of criteria. 
     * 
     * @param array $criteria
     * @return object
     */
    public function findOneBy(array $criteria) 
    {
        return $this->repository->findOneBy($criteria); 
    } 

    /**
     * Does the manager supports the given object?
     * 
     * @param object $object
     * @return boolean
     */
    protected function supports($object) 
    {
        return ($object instanceof $this->className); 
    }
}
