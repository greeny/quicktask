<?php
/**
 * @author Tomáš Blatný
 */

namespace App\Factories\Form;

use App\Components\Form\FilterTaskForm;


interface IFilterTaskFormFactory
{

	/** @return FilterTaskForm */
	function create();

}
