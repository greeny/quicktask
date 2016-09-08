<?php
namespace App\Components\Form;

use App\Model\Entity\Task;
use App\Model\Entity\TaskGroup;
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


	/**
	 * @param TaskGroup $taskGroup
	 * @param TaskRepository $taskRepository
	 */
	public function __construct(TaskGroup $taskGroup, TaskRepository $taskRepository)
	{
		parent::__construct();
		$this->taskGroup = $taskGroup;
		$this->taskRepository = $taskRepository;
	}


	public function initForm(Form $form)
	{
		$form->addText('name', 'Name')
			->setRequired('Please fill task name');

		$form->addText('date', 'Date')
			->setRequired('Please fill task date');

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
		$taskEntity = new Task;
		$taskEntity->setName($values->name);
		$taskEntity->setDate($values->date);
		$taskEntity->setTaskGroup($this->taskGroup);
		$this->taskRepository->insert($taskEntity);
	}
}
