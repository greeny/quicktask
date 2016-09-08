<?php
/**
 * @author Tomáš Blatný
 */

namespace App\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;


/**
 * @ORM\Entity
 */
class Category
{

	use Identifier;


	/**
	 * @var Task[]|ArrayCollection
	 * @ORM\OneToMany(targetEntity="Task", mappedBy="category")
	 */
	private $tasks;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	private $name;


	public function __construct()
	{
		$this->tasks = new ArrayCollection;
	}


	/**
	 * @return Task[]
	 */
	public function getTasks()
	{
		return $this->tasks->toArray();
	}


	/**
	 * @param Task $task
	 * @return $this
	 */
	public function addTask(Task $task)
	{
		$this->tasks->add($task);
		return $this;
	}


	/**
	 * @param Task $task
	 * @return $this
	 */
	public function removeTask(Task $task)
	{
		$this->tasks->removeElement($task);
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

}
