<?php
/**
 * @author Tomáš Blatný
 */

namespace App\Factories\Form;

use App\Components\Form\CompleteTaskForm;
use App\Model\Entity\Task;


interface ICompleteTaskFormFactory
{

	/** @return CompleteTaskForm */
	function create(Task $task);

}
