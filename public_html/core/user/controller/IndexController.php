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
		$information_section = $this->model->get('information_section', [
			'where' => ['visible' => 1],
			'order' => ['menu_position']
		]);
		$fotos = $this->model->get('foto', [
			'where' => ['visible' => 1],
			'order' => ['menu_position']
		]);
		$questions = $this->model->get('questions', [
			'where' => ['visible' => 1],
			'order' => ['menu_position']
		]);

		return compact('section_top', 'information_section', 'fotos', 'questions');
	}
}
