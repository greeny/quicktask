<?php
namespace App\Model\Repository;

use App\Model\Entity;
use Kdyby\Doctrine\EntityManager;

class TaskGroupRepository extends AbstractRepository
{
    /** @var \Kdyby\Doctrine\EntityRepository */
    private $taskGroup;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->taskGroup = $this->entityManager->getRepository(Entity\TaskGroup::getClassName());
    }

    /**
     * @param number $id
     * @return Entity\TaskGroup|null
     */
    public function getById($id)
    {
        return $this->taskGroup->find($id);
    }

    /**
     * @return Entity\TaskGroup[]
     */
    public function getAll()
    {
        return $this->taskGroup->findBy(array());
    }

    /**
     * @param Entity\TaskGroup $taskGroup
     */
    public function insert(Entity\TaskGroup $taskGroup)
    {
        $this->entityManager->persist($taskGroup);
        $this->entityManager->flush();
    }
}
