<?php
namespace App\Presenters;

use App\Factories\Form\ICompleteTaskFormFactory;
use App\Factories\Form\IFilterTaskFormFactory;
use App\Factories\Form\IInsertTaskFormFactory;
use App\Model\Entity\Task;
use App\Model\Entity\TaskGroup;
use Nette\Application\UI\Form;
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

	/** @var IFilterTaskFormFactory @inject */
	public $filterTaskFormFactory;

	/** @var IInsertTaskFormFactory @inject */
	public $insertTaskFormFactory;

	/** @var string @persistent */
	public $filterName;

	/** @var TaskGroup */
	private $taskGroup;

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
		$this->taskGroup = $this->taskGroupRepository->getById($idTaskGroup);
		$this->updateTasks();
	}


	public function renderTaskGroup()
	{
		if ($this->isAjax()) {
			$this->redrawControl('content');
		}
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
	 * @return \App\Components\Form\InsertTaskForm
	 */
	protected function createComponentInsertTaskForm()
	{
		$form = $this->insertTaskFormFactory->create($this->taskGroup);
		$form->onSuccess[] = function (Form $form, $values) {
			$this->flashMessage('Task \'' . $values->name . '\' was created', 'success');
			if ($this->isAjax()) {
				$this->updateTasks();
				$this->redrawControl('content');
			} else {
				$this->redirect('this');
			}
		};
		return $form;
	}


	protected function createComponentCompleteTaskForm()
	{
		return new Multiplier(function ($id) {
			$task = $this->getTask($id);
			$form = $this->completeTaskFormFactory->create($task);
			$form->onSuccess[] = function ($form, $values) use ($task) {
				$this->flashMessage('Task \'' . $task->getName() . '\' marked as ' . ($values->completed ? '' : 'not ') . 'completed.', 'success');
				if ($this->isAjax()) {
					$this->redrawControl('content');
				} else {
					$this->redirect('this');
				}
			};
			return $form;
		});
	}


	protected function createComponentFilterTaskForm()
	{
		$form = $this->filterTaskFormFactory->create();
		$form->getForm()['search']->setValue($this->filterName);
		$form->onSuccess[] = function ($form, $values) {
			if ($this->isAjax()) {
				$this->filterName = $values->search;
				$this->updateTasks();
				$this->redrawControl('content');
			} else {
				$this->redirect('this', ['filterName' => $values->search]);
			}
		};
		return $form;
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


	protected function updateTasks()
	{
		$this->tasks = $this->taskRepository->getByTaskGroup($this->taskGroup, $this->filterName);
	}


	/**
	 * @param int $id
	 * @return Task|NULL
	 */
	protected function getTask($id)
	{
		$task = NULL;
		foreach ($this->tasks as $item) {
			if ($item->getId() == $id) { // intentionally ==
				$task = $item;
			}
		}
		return $task;
	}
}
