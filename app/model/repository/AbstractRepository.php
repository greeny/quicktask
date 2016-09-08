<?php
namespace App\Model\Repository;

use Kdyby\Doctrine\EntityManager;
use Nette\Object;


abstract class AbstractRepository extends Object
{

	/** @var EntityManager */
	protected $entityManager;


	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	public function updateEntity($entity)
	{
		$this->entityManager->persist($entity);
		$this->entityManager->flush();
	}


	public function delete($id)
	{
		$entity = $this->getById($id);
		$this->entityManager->remove($entity);
		$this->entityManager->flush();
	}


	abstract public function getById($id);


	/**
	 * Escapes argument used in LIKE statement to prevent wildcard injection
	 * @param string $arg
	 * @return string
	 */
	protected function escapeLikeArg($arg)
	{
		return addcslashes($arg, '%_');
	}
}
