<?php
namespace App\Factories\Form;

use App\Components\Form\InsertTaskForm;
use App\Model\Entity\TaskGroup;


interface IInsertTaskFormFactory
{

	/** @return InsertTaskForm */
	public function create(TaskGroup $taskGroup);

}
