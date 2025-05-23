<?php

namespace core\user\controller;

use core\user\model\Model;

/** 
 * Пользовательский контроллер с базовым функционалом (абстрактный класс) -Выпуск №120
 *  Методы: protected function img(); protected function alias()
 *          protected function wordsForCounter();
 */
abstract class BaseUser extends \core\base\controller\BaseController
{
	protected $model;
	protected $table;

	// Выпуск №122- Пользовательская часть | Вывод данных в хедер сайта
	/** 
	 * свойство, в которое будем класть данные из таблицы: settings (настройки системы: лого, телефон, эл.почта и т.д.)
	 */
	protected $set;

	/** 
	 * свойство с данными для меню (каталог)
	 */
	//protected $menu;

	/** 
	 * св-во в котором будем держать данные пользователя (Выпуск №145)
	 */
	protected $userData = [];

	/** 
	 * Проектные свойства (Выпуск №123)
	 */
	protected $socials;

	//protected $site_categories;
	//protected $websites;

	protected function inputData()
	{
		// инициализируем стили и скрипты На вход здесь ничего не передаём (Выпуск №120)
		$this->init();

		// получим модель (если ещё не получена)
		!$this->model && $this->model = Model::instance();

		// Выпуск №122- Пользовательская часть | Вывод данных в хедер сайта
		// (св-во: $this->set будет доступно везде (без рендеринга), где будет вызываться header и footer, т.к. это св-во
		// любого объекта класса, который наследует: BaseUser и поэтому его никуда передавать не надо)
		$this->set = $this->model->get('settings', [
			'order' => ['id'],
			'limit' => 1
		]);
		// укажежем, что если что то пришло в свойство: $this->set, то сохраним в нём только нулевой элемент массива, 
		// который пришёл (первый по очереди, т.е. будет забираться только одна каждая следующая созданная запись)
		$this->set && $this->set = $this->set[0];

		//-------------------------------------------------------------------------------------------------------------//

		// получим в св-во: $this->site_categories, то что хранится в соответствующей таблице БД
		/* $this->site_categories = $this->model->get('site_categories', [
			'where' => ['visible' => 1, 'parent_id' => null],
			'order' => ['menu_position']
		]); */

		/* $this->websites = $this->model->get('websites', [
			'where' => ['visible' => 1],
			'join' => [
				'site_categories' => [
					'fields' => ['alias as alias_categories_name'],
					'on' => ['parent_id', 'id']
				]
			]
		]); */

		// к пунктам меню присоединили таблицу с названиями секций (они будут выводиться в выпадающем списке в админке) к 
		// которым происходит переход при нажатии на них
		/* $this->menu['information'] = $this->model->get('information', [
			'where' => ['visible' => 1, 'show_top_menu' => 1,],
			'join' => [
				'sections' => [
					'fields' => ['name as section_name'],
					'on' => ['parent_id', 'id']
				]
			]
		]); */

		// получим в св-во: $this->socials, то что хранится в соответствующей таблице БД
		$this->socials = $this->model->get('socials', [
			'where' => ['visible' => 1],
			'order' => ['menu_position']
		]);
	}

	// Выпуск №120
	protected function outputData()
	{
		// +Выпуск №129
		// в переменной сохраним результат работы ф-ии php: func_get_arg()- Возвращает указанный аргумент из списка 
		// аргументов пользовательской функции (здесь- порядковый номер: 0)
		$args = func_get_arg(0);
		$vars = $args ? $args : [];


		if (!$this->content) {

			$this->content = $this->render($this->template, $vars);
		}

		$this->header = $this->render(TEMPLATE . 'include/header', $vars);
		$this->footer = $this->render(TEMPLATE . 'include/footer', $vars);

		return $this->render(TEMPLATE . 'layout/default');
	}

	/** 
	 * Метод для удобного заполнения пути к изображению в файлах (Выпуск №120, 121)
	 */
	protected function img($img = '', $tag = false)
	{
		// если картинка отсутствует и есть папка с изображениями по умолчанию
		if (!$img && is_dir($_SERVER['DOCUMENT_ROOT'] . PATH . UPLOAD_DIR . DEFAULT_IMAGE_DIRECTORY)) {

			// scandir() — возвращает список файлов и каталогов внутри указанного пути
			$dir = scandir($_SERVER['DOCUMENT_ROOT'] . PATH . UPLOAD_DIR . DEFAULT_IMAGE_DIRECTORY);

			// preg_grep() — возвращает записи массива, соответствующие шаблону ( или регулярному выражению)
			// в переменную: $imgArr положим то что в названии будет указывать на IndexController далее точка и какое то 
			// расширение, если такого нет, то будем искать файл с названием: default далее точка и какое то расширение
			$imgArr = preg_grep('/' . $this->getController() . '\./i', $dir) ?: preg_grep('/default\./i', $dir);

			// если в переменную: $imgArr что то пришло, то в переменную $img сохраним выражение, где 
			// array_shift()— возвращает массив поданный на вход, исключив первый элемент (все ключи числового массива 
			// будут изменены, чтобы начать отсчет с нуля) +Выпуск №121
			$imgArr && $img = DEFAULT_IMAGE_DIRECTORY . '/' . array_shift($imgArr);
		}

		// Выпуск №121
		if ($img) {

			// сформируем путь к изображению
			$path = PATH . UPLOAD_DIR . $img;

			// если в параметрах передали: $tag = false
			if (!$tag) {

				// то вернём путь 
				return $path;
			}

			// если в параметрах передали: $tag = true, то вернём:
			echo '<img src="' . $path . '" alt="image" title="image">';
		}

		return '';
	}

	/** 
	 * Метод формирования ссылок в пользовательской части (Выпуск №121)
	 */
	protected function alias($alias = '', $queryString = '')
	{

		$str = '';

		if ($queryString) {

			if (is_array($queryString)) {

				foreach ($queryString as $key => $item) {

					// к переменной: $str конкатенируем символ: знак вопроса (если в строку ничего не пришло) иначе- символ амперсанд
					$str .= (!$str ? '?' : '&');

					if (is_array($item)) {

						// к ключу конкатенируем символ квадратных скобок
						$key .= '[]';

						foreach ($item as $k => $v) {

							// +Выпуск №132
							$str .= $key . '=' . $v . (!empty($item[$k + 1]) ? '&' : '');
						}
					} else {

						$str .= $key . '=' . $item;
					}
				}

				// иначе если в переменную: $queryString пришёл не массив
			} else {

				// проверим не пришёл ли уже знак вопроса в переменную: $queryString
				if (strpos($queryString, '?') === false) {

					$str = '?' . $str;
				}

				$str .= $queryString;
			}
		}


		if (is_array($alias)) {

			$aliasStr = '';

			foreach ($alias as $key => $item) {

				// если пришёл не числовой ключ и что то пришло в переменную: $item
				if (!is_numeric($key) && $item) {

					$aliasStr .= $key . '/' . $item . '/';

					// иначе если что то пришло в переменную: $item, но ключ числовой
				} elseif ($item) {

					$aliasStr .= $item . '/';
				}
			}

			// trim() — удаление пробелов (или других символов (здесь- символ: / )) из начала и конца строки
			$alias = trim($aliasStr, '/');
		}

		if (!$alias || $alias === '/') {

			return PATH . $str;
		}

		// если в $str пришла готовая ссылка (URL c http или https), то это может быть ссылка на внешний ресурс
		if (preg_match('/^\s*https?:\/\//i', $alias)) {

			return $alias . $str;
		}

		// ищем слеш повторяющийся 2-а и более раз и меняем на единичный слеш, и выводить это будем в готовом пути
		return preg_replace('/\/{2,}/', '/', PATH . $alias . END_SLASH . $str);
	}
}
