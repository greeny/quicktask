<?php
namespace App\Presenters;

use Nette;

/**
 * Error presenter.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	public function flashMessage($message, $type = 'info')
	{
		if ($this->isAjax()) {
			$this->redrawControl('flashes');
		}
		return parent::flashMessage($message, $type);
	}


}
