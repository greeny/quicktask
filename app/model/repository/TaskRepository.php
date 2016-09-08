<?php
namespace App\Model\Repository;

use App\Model\Entity;
use Kdyby\Doctrine\EntityManager;

class TaskRepository extends AbstractRepository
{
    /** @var \Kdyby\Doctrine\EntityRepository */
    private $task;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->task = $this->entityManager->getRepository(Entity\Task::getClassName());
    }

    /**
     * @param number $id
     * @return Entity\Task|null
     */
    public function getById($id)
    {
        return $this->task->find($id);
    }

    /**
     * @param Entity\TaskGroup $taskGroup
     * @return Entity\Task[]
     */
    public function getByTaskGroup(Entity\TaskGroup $taskGroup, $filterName = NULL, $order = TRUE)
    {
    	$queryBuilder = $this->task->createQueryBuilder('t');
    	$queryBuilder->andWhere('t.taskGroup = :taskGroup');
    	$queryBuilder->setParameter('taskGroup', $taskGroup);
    	if ($order) {
    		$queryBuilder->orderBy('t.date', 'DESC');
	    }
	    if ($filterName) {
    		$queryBuilder->andWhere($queryBuilder->expr()->like('t.name', ':name'));
    		$queryBuilder->setParameter('name', '%' . $this->escapeLikeArg($filterName) . '%');
	    }
	    return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Entity\Task $task
     */
    public function insert(Entity\Task $task)
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }
}
