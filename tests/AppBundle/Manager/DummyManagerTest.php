<?php

/*
 * This file is part of the TODO REST API package.
 *
 * (c) Rémi Houdelette <https://github.com/B0ulzy>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Manager; 

use Doctrine\Common\Persistence\ObjectManager; 
use Doctrine\Common\Persistence\ObjectRepository; 
use Tests\AppBundle\Entity\Dummy; 
use Tests\AppBundle\Manager\DummyManager; 

/**
 * Test class for EntityManager abstract class
 * 
 * @author Rémi Houdelette <b0ulzy.todo@gmail.com>
 */
class DummyManagerTest extends \PHPUnit_Framework_TestCase 
{
    const ENTITY_CLASS = 'Tests\\AppBundle\\Entity\\Dummy'; 

    /**
     * Test create method
     */
    public function testCreate() 
    {
        $om = $this->getObjectManagerMock(); 
        $dummyManager = $this->getDummyManager($om); 

        $dummy = $dummyManager->create(); 

        $this->assertInstanceOf(self::ENTITY_CLASS, $dummy); 
    } 

    /**
     * Test save method with supported object
     */
    public function testSaveWithSupportedObject() 
    {
        $dummy = new Dummy(); 
        $dummy->setName('dummy1'); 

        $om = $this->getObjectManagerMock(); 
        $om->expects($this->at(1))->method('contains')->will($this->returnValue(false)); 
        $om->expects($this->any())->method('contains')->will($this->returnValue(true)); 
        $om->expects($this->once())->method('persist')->with($dummy); 
        $om->expects($this->exactly(2))->method('flush'); 

        $dummyManager = $this->getDummyManager($om); 
        $dummyManager->save($dummy); 

        $dummy->setName('dummy2'); 
        $dummyManager->save($dummy); 
    } 

    /**
     * Test save method with unsupported object
     * 
     * @expectedException \InvalidArgumentException
     */
    public function testSaveWithUnsupportedObject() 
    {
        $object = new \stdClass(); 
        $om = $this->getObjectManagerMock(); 
        $dummyManager = $this->getDummyManager($om); 

        $dummyManager->save($object); 
    }

    /**
     * Test delete method with supported object
     */
    public function testDeleteWithSupportedObject() 
    {
        $dummy = new Dummy(); 
        $dummy->setName('dummy1'); 

        $om = $this->getObjectManagerMock(); 
        $om->expects($this->once())->method('remove')->with($dummy); 
        $om->expects($this->once())->method('flush'); 

        $dummyManager = $this->getDummyManager($om); 
        $dummyManager->delete($dummy); 
    } 

    /**
     * Test delete method with unsupported object
     * 
     * @expectedException \InvalidArgumentException
     */
    public function testDeleteWithUnsupportedObject() 
    {
        $object = new \stdClass(); 
        $om = $this->getObjectManagerMock(); 
        $dummyManager = $this->getDummyManager($om); 

        $dummyManager->delete($object); 
    }

    /**
     * Test find method 
     */
    public function testFind() 
    {
        $dummyRepository = $this->getObjectRepositoryMock(); 
        $dummyRepository->expects($this->once())->method('find')->with(1); 

        $om = $this->getObjectManagerMockWithRepository($dummyRepository); 

        $dummyManager = $this->getDummyManager($om); 
        $retrievedDummy = $dummyManager->find(1); 
    } 

    /**
     * Test findAll method
     */
    public function testFindAll() 
    {
        $dummyRepository = $this->getObjectRepositoryMock(); 
        $dummyRepository->expects($this->any())->method('findAll'); 

        $om = $this->getObjectManagerMockWithRepository($dummyRepository); 

        $dummyManager = $this->getDummyManager($om); 
        $retrievedDummies = $dummyManager->findAll(); 
    } 

    /**
     * Test findOneBy method
     */
    public function testFindOneBy() 
    {
        $criteria = array('name' => 'dummy1'); 
        $dummyRepository = $this->getObjectRepositoryMock(); 
        $dummyRepository->expects($this->any())->method('findOneBy')->with($criteria); 

        $om = $this->getObjectManagerMockWithRepository($dummyRepository); 

        $dummyManager = $this->getDummyManager($om); 
        $retrievedDummies = $dummyManager->findOneBy($criteria); 
    } 

    /**
     * Test findBy method
     */
    public function testFindBy() 
    {
        $criteria = array('name' => 'dummy1'); 
        $dummyRepository = $this->getObjectRepositoryMock(); 
        $dummyRepository->expects($this->any())->method('findBy')->with($criteria); 

        $om = $this->getObjectManagerMockWithRepository($dummyRepository); 

        $dummyManager = $this->getDummyManager($om); 
        $retrievedDummies = $dummyManager->findBy($criteria); 
    } 

    /**
     * Get mock for ObjectManager object
     * 
     * @return ObjectManager
     */
    private function getObjectManagerMock() 
    {
        $mockBuilder = $this->getMockBuilder('\\Doctrine\\Common\\Persistence\\ObjectManager'); 

        return $mockBuilder->getMock(); 
    } 

    /**
     * Get mock for ObjectRepository object
     * 
     * @return ObjectRepository
     */
    private function getObjectRepositoryMock() 
    {
        $mockBuilder = $this->getMockBuilder('\\Doctrine\\Common\\Persistence\\ObjectRepository'); 

        return $mockBuilder->getMock(); 
    }

    /**
     * Get DummyManager object
     * 
     * @param ObjectManager $om
     * @return DummyManager
     */
    private function getDummyManager(ObjectManager $om) 
    {
        $dummyManager = new DummyManager($om, self::ENTITY_CLASS); 

        return $dummyManager; 
    } 

    /**
     * Get DummyManager object containing an ObjectRepository
     * 
     * @param ObjectRepository $objectRepository
     * @return DummyManager
     */
    private function getObjectManagerMockWithRepository(ObjectRepository $objectRepository) 
    {
        $om = $this->getObjectManagerMock(); 
        $om->expects($this->any())->method('getRepository')->with('\\' . self::ENTITY_CLASS)->will($this->returnValue($objectRepository)); 

        return $om; 
    }
}
