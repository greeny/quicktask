<?php
/**
 * @author Tomáš Blatný
 */

namespace App\Components\Form;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Application\UI\ITemplate;
use Nette\Utils\ArrayHash;
use ReflectionClass;


/**
 * @method onSuccess(Form $form, ArrayHash $values)
 * @method onValidate(Form $form, ArrayHash $values)
 */
abstract class BaseForm extends Control
{

	/** @var callable[] */
	public $onSuccess = [];

	/** @var callable[] */
	public $onValidate = [];


	public function render()
	{
		$reflection = new ReflectionClass($this);
		$file = dirname($reflection->getFileName()) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . basename($reflection->getShortName(), '.php') . '.latte';
		$this->template->setFile($file);
		$this->initTemplate($this->template);
		$this->template->render();
	}


	/**
	 * @return Form
	 */
	public function getForm()
	{
		return $this['form'];
	}


	protected function createComponentForm()
	{
		$form = new Form;
		$this->initForm($form);
		$form->onSuccess[] = function (Form $form) {
			$this->formSuccess($form, $form->getValues());
			$this->onSuccess($form, $form->getValues());
		};
		$form->onValidate[] = function (Form $form) {
			$this->formValidate($form, $form->getValues());
			$this->onValidate($form, $form->getValues());
		};
		return $form;
	}


	abstract public function initForm(Form $form);


	abstract public function initTemplate(ITemplate $template);


	abstract public function formValidate(Form $form, ArrayHash $values);


	abstract public function formSuccess(Form $form, ArrayHash $values);

}
