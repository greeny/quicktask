<?php
/**
 * @author Tomáš Blatný
 */

namespace App\Components\Form;

use App\Model\Entity\Task;
use App\Model\Repository\TaskRepository;
use Nette\Application\UI\Form;
use Nette\Application\UI\ITemplate;
use Nette\Utils\ArrayHash;


class CompleteTaskForm extends BaseForm
{

	/** @var Task */
	private $task;

	/** @var TaskRepository */
	private $taskRepository;


	public function __construct(Task $task, TaskRepository $taskRepository)
	{
		parent::__construct();
		$this->task = $task;
		$this->taskRepository = $taskRepository;
	}


	public function initForm(Form $form)
	{
		$form->addCheckbox('completed')
			->setDefaultValue($this->task->getCompleted());
    }


	public function initTemplate(ITemplate $template)
	{
		$this->template->task = $this->task;
	}


	public function formValidate(Form $form, ArrayHash $values)
	{

	}


	public function formSuccess(Form $form, ArrayHash $values)
	{
		$this->task->setCompleted($values->completed);
		$this->taskRepository->updateEntity($this->task);
	}
}
