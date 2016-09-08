<?php
/**
 * @author Tomáš Blatný
 */

namespace App\Components\Form;

use Nette\Application\UI\Form;
use Nette\Application\UI\ITemplate;
use Nette\Utils\ArrayHash;


class FilterTaskForm extends BaseForm
{

	public function initForm(Form $form)
	{
		$form->addText('search')
			->setAttribute('placeholder', 'Search by name');
	}


	public function initTemplate(ITemplate $template)
	{

	}


	public function formValidate(Form $form, ArrayHash $values)
	{

	}


	public function formSuccess(Form $form, ArrayHash $values)
	{

	}
}
