<?php
namespace App\Model\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\BaseEntity;


/**
 * @ORM\Entity
 */
class Task extends BaseEntity
{

	use Identifier;

	/**
	 * @var TaskGroup
	 * @ORM\ManyToOne(targetEntity="TaskGroup")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	protected $taskGroup;

	/**
	 * @var Category|NULL
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="tasks", cascade={"persist"})
	 */
	private $category;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	protected $name;

	/**
	 * @var DateTime
	 * @ORM\Column(type="date", nullable=FALSE)
	 */
	protected $date;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean", nullable=FALSE)
	 */
	protected $completed = FALSE;


	/**
	 * @return TaskGroup
	 */
	public function getTaskGroup()
	{
		return $this->taskGroup;
	}


	/**
	 * @param TaskGroup $taskGroup
	 * @return $this
	 */
	public function setTaskGroup(TaskGroup $taskGroup)
	{
		$this->taskGroup = $taskGroup;
		return $this;
	}


	/**
	 * @return Category|NULL
	 */
	public function getCategory()
	{
		return $this->category;
	}


	/**
	 * @param Category|NULL $category
	 * @return $this
	 */
	public function setCategory(Category $category = NULL)
	{
		$this->category = $category;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @param string $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}


	/**
	 * @return DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}


	/**
	 * @param DateTime|string $date
	 * @return $this
	 */
	public function setDate($date)
	{
		if (!$date instanceof \DateTime) {
			$date = new \DateTime($date);
		}
		$this->date = $date;
		return $this;
	}


	/**
	 * @return bool
	 */
	public function getCompleted()
	{
		return $this->completed;
	}


	/**
	 * @param bool $completed
	 * @return $this
	 */
	public function setCompleted($completed)
	{
		$this->completed = $completed;
		return $this;
	}

}
