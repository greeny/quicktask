<?php
namespace App\Presenters;

use App\Factories\Form\ICompleteTaskFormFactory;
use App\Model\Entity\Task;
use Nette\Application\UI\Multiplier;


/**
 * Class TaskPresenter
 *
 * @package App\Presenters
 */
class TaskPresenter extends BasePresenter
{

	/** @var \App\Model\Repository\TaskGroupRepository @inject */
	public $taskGroupRepository;

	/** @var \App\Model\Repository\TaskRepository @inject */
	public $taskRepository;

	/** @var \App\Factories\Modal\IInsertTaskGroupFactory @inject */
	public $insertTaskGroupFactory;

	/** @var ICompleteTaskFormFactory @inject */
	public $completeTaskFormFactory;

	/** @var \App\Factories\Form\IInsertTaskFactory @inject */
	public $insertTaskFactory;

	/** @var number */
	protected $idTaskGroup;

	/** @var Task[] */
	private $tasks;


	public function renderDefault()
	{
		$this->template->taskGroups = $this->getTaskGroups();
	}


	/**
	 * @param int $id
	 */
	public function handleDeleteTaskGroup($id)
	{
		$this->taskGroupRepository->delete($id);
		if ($this->isAjax()) {
			$this->redrawControl('taskGroups');
		} else {
			$this->redirect('this');
		}
	}


	public function actionTaskGroup($idTaskGroup)
	{
		$this->idTaskGroup = $idTaskGroup;
		$this->tasks = $this->getTasks($idTaskGroup);
	}


	public function renderTaskGroup()
	{
		$this->template->tasks = $this->tasks;
	}


	/**
	 * @return \App\Components\Modal\InsertTaskGroup
	 */
	protected function createComponentInsertTaskGroupModal()
	{
		$control = $this->insertTaskGroupFactory->create();
		return $control;
	}


	/**
	 * @return \App\Components\Form\InsertTask
	 */
	protected function createComponentInsertTaskForm()
	{
		$control = $this->insertTaskFactory->create();
		$control->setTaskGroupId($this->idTaskGroup);
		return $control;
	}


	protected function createComponentCompleteTaskForm()
	{
		return new Multiplier(function ($id) {
			$form = $this->completeTaskFormFactory->create($this->tasks[$id]);
			$form->onSuccess[] = function ($form, $values) use ($id) {
				$this->flashMessage('Task \'' . $this->tasks[$id]->getName() . '\' marked as ' . ($values->completed ? '' : 'not ') . 'completed.', 'success');
				$this->redirect('this');
			};
			return $form;
		});
	}


	/**
	 * @return array
	 */
	protected function getTaskGroups()
	{
		$result = [];
		$taskGroups = $this->taskGroupRepository->getAll();
		foreach ($taskGroups as $taskGroup) {
			$item = [];
			$item['id'] = $taskGroup->getId();
			$item['name'] = $taskGroup->getName();
			$result[] = $item;
		}
		return $result;
	}


	/**
	 * @param number $idTaskGroup
	 * @return array
	 */
	protected function getTasks($idTaskGroup)
	{
		$result = [];
		$tasks = $this->taskRepository->getByTaskGroup($idTaskGroup);
		foreach ($tasks as $task) {
			$result[$task->getId()] = $task;
		}
		return $result;
	}
}
