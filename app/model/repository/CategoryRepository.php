<?php
/**
 * @author Tomáš Blatný
 */

namespace App\Model\Repository;

use App\Model\Entity\Category;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;


class CategoryRepository extends AbstractRepository
{

	/** @var EntityRepository */
	private $category;

	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager);
		$this->category = $this->entityManager->getRepository(Category::class);
	}


	/**
	 * @param int $id
	 * @return Category|NULL
	 */
	public function getById($id)
	{
		return $this->category->find($id);
	}


	/**
	 * @return array
	 */
	public function getPairs()
	{
		return $this->category->findPairs('name', ['name' => 'ASC']);
	}

}
