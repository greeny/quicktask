<?php
namespace App\Components\Form;

use App\Model\Entity\Category;
use App\Model\Entity\Task;
use App\Model\Entity\TaskGroup;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\TaskRepository;
use Nette\Application\UI\Form;
use Nette\Application\UI\ITemplate;
use Nette\Utils\ArrayHash;


class InsertTaskForm extends BaseForm
{

	/** @var TaskRepository */
	public $taskRepository;

	/** @var TaskGroup */
	private $taskGroup;

	/** @var number */
	public $idTaskGroup;

	/** @var CategoryRepository */
	private $categoryRepository;


	/**
	 * @param TaskGroup $taskGroup
	 * @param TaskRepository $taskRepository
	 */
	public function __construct(TaskGroup $taskGroup, TaskRepository $taskRepository, CategoryRepository $categoryRepository)
	{
		parent::__construct();
		$this->taskGroup = $taskGroup;
		$this->taskRepository = $taskRepository;
		$this->categoryRepository = $categoryRepository;
	}


	public function initForm(Form $form)
	{
		$form->addText('name', 'Name')
			->setRequired('Please fill task name');

		$form->addText('date', 'Date')
			->setRequired('Please fill task date');

		$categories = [-1 => '* New category'] + $this->categoryRepository->getPairs();

		$form->addSelect('category', 'Category', $categories)
			->setPrompt('* None')
			->addCondition($form::EQUAL, -1)
				->toggle('customCategory');

		$form->addText('customCategory', 'Category name')
			->addConditionOn($form['category'], $form::EQUAL, -1)
				->setRequired('Please fill category name');

		$form->addSubmit('submit', 'Add');
	}


	public function initTemplate(ITemplate $template)
	{

	}


	public function formValidate(Form $form, ArrayHash $values)
	{

	}


	public function formSuccess(Form $form, ArrayHash $values)
	{
		$task = new Task;
		$task->setName($values->name)
			->setDate($values->date)
			->setTaskGroup($this->taskGroup);

		if ($values->category) {
			if ($values->category === -1) {
				$category = new Category;
				$category->setName($values->customCategory);
			} else {
				$category = $this->categoryRepository->getById($values->category);
			}
			$category->addTask($task);
			$task->setCategory($category);
		}

		$this->taskRepository->insert($task);
	}
}
