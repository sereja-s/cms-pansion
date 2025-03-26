<?php

namespace core\user\controller;

/** 
 * Индексный контроллер пользовательской части
 */
class IndexController extends BaseUser
{
	protected function inputData()
	{
		// Выпуск №120
		parent::inputData();

		$section_top = $this->model->get('section_top', [
			'where' => ['visible' => 1],
			'order' => ['menu_position']
		]);

		return compact('section_top');
	}
}
