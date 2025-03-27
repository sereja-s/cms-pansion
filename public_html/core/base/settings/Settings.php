<?php

namespace core\base\settings;

use core\base\controller\Singleton;

/** 
 *  Класс настроек
 * 
 * Методы: static public function get($property); public function clueProperties($class); 
 * public function arrayMergeRecursive()
 */
class Settings
{
	use Singleton; // используем шаблон, запрещающий создавать более одного объекта класса

	// спецификатор доступа private даёт возможность читать, но запрещает перезаписывать это свойство в коде (т.к. это глобальные настройки проекта) 

	// запишем(сохраним) в свойствах массивы

	private $routes = [

		// запишем(сохраним) маршруты в виде массивов
		// для административной части сайта
		'admin' => [
			// перечислим ячейки массива
			'alias' => 'admin',
			'path' => 'core/admin/controller/',
			'hrUrl' => false, // для админки отключили человеко-понятные адреса ссылок
			'routes' => [
				//'product' => 'goods/getGoods/sale'
			]
		],
		// для настройек сайта
		'settings' => [
			'path' => 'core/base/settings/'
		],
		// для плагинов
		'plugins' => [
			'path' => 'core/plugins/',
			'hrUrl' => false,
			'dir' => false
		],
		// для пользовательской части сайта
		'user' => [
			'path' => 'core/user/controller/',
			'hrUrl' => true, // для пользовательской части включили человеко-понятные адреса ссылок
			'routes' => [
				// указываем в виде: 'алиас маршрута (вводится в адресной строке после домена)' => 'контроллер/входной метод контроллера/выходной метод контроллера'

				//'catalog' => 'site/hello/by' 
				//'site' => 'index/hello'
			]
		],
		// для раздела по умолчанию (если в св-ве: routes не указаны необходимые контроллер, входной и выходной методы)
		'default' => [
			'controller' => 'IndexController',
			// входной метод по умолчанию, который вызовется у контроллера
			'inputMethod' => 'inputData',
			// выходной метод по умолчанию для вывода данных в пользовательскую часть
			'outputMethod' => 'outputData'
		]

		//'p' => [1, 2, 3]
	];

	// свойство: расширение (путь к папке где хранятся расширения) 
	private $expansion = 'core/admin/expansion/';
	//private $expansion = 'core/plugin/expansion/';

	// свойство: сообщения (путь к папке где хранятся информационные сообщения)
	private $messages = 'core/base/messages/';

	// свойство с таблицей по умолчанию
	private $defaultTable = 'settings';

	// свойство в котором хранится путь к шаблонам админки
	private $formTemplates = PATH . 'core/admin/view/include/form_templates/';

	// свойство с таблицами, названия которых будут показаны в боковом меню админки
	private $projectTables = [

		'settings' => ['name' => 'Настройки (о сайте)'],
		'section_top' => ['name' => 'Слайды'],
		'information' => ['name' => 'Пункты меню'],
		'sections' => ['name' => 'Указатель на раздел'],
		'websites' => ['name' => 'Сайты'],
		'site_categories' => ['name' => 'Виды сайтов'],
		'socials' => ['name' => 'Соц.сети'],
	];

	// свойство: массив шаблонов
	private $templateArr = [

		// массив вида: 'название шаблона' => массив с полями для которых должен быть подключен соответствующий шаблон
		'text' => ['name', 'year', 'phone', 'phone_two', 'email', 'alias', 'section_id', 'external_alias', 'sub_title', 'number_of_years', 'discount', 'price', 'login', 'password', 'map_coordinates', 'scroll_to'],
		'textarea' => ['content', 'keywords', 'address', 'work_time', 'map_address', 'address_big', 'description', 'short_content'],
		'radio' => ['visible', 'show_top_menu', 'hit', 'sale', 'new', 'hot'],
		'checkboxlist' => ['filters', 'filters_test'], // указали, что хотим подключить фильтры к связанной таблице: 
		// товары (они прописаны в массиве: в свойстве: private $manyToMany)
		'select' => ['menu_position', 'parent_id'],
		'img' => ['img', 'img_logo', 'img_horizontal', 'img_footer', 'map_img', 'bg_img'],
		'gallery_img' => ['gallery_img', 'new_gallery_img']
	];

	// св-во, в котором будет храниться массив шаблонов в которых выводятся файлы
	private $fileTemplates = ['img', 'gallery_img'];

	// св-во, позволяющее переводить поля административной панели из файла настроек
	private $translate = [
		// каждое поле тоже представляет собой массив, в котором можно указать два элемента (название элемента, комментарий элемента)
		'name' => ['Название', '(Не более 120 символов)'],
		'year' => ['год'],
		'keywords' => ['Ключевые слова', '(Не более 75 символов)'],
		'content' => ['Описание', '(Текстовая часть, фотографии, картинки к описанию)'],
		'description' => ['SEO описание'],
		'phone' => ['Телефон'],
		'phone_two' => ['Телефон-2'],
		'email' => ['Электронная почта'],
		'address' => ['Адрес'],
		'address_big' => ['детали адреса'],
		'alias' => ['Ссылка ЧПУ'],
		'section_id' => ['Идетификатор'],
		'external_alias' => ['Внешняя ссылка'],
		'img' => ['Изображение'],
		'img_logo' => ['Изображение', '(логотип)'],
		'img_horizontal' => ['Изображение горизонтальное', '(Одно)'],
		'img_footer' => ['Изображение внизу', '(для больших экранов)'],
		'map_img' => ['логотип', '(на карте)'],
		'bg_img' => ['Изображение-фон', '(слайд)'],
		'gallery_img' => ['галерея изображений', '(Несколько)'],
		'visible' => ['Видимость', '(Показывать?)'],
		'menu_position' => ['Позиция в списке', '(Расположение в меню)'],
		'show_top_menu' => ['Показывать в верхнем меню'],
		'sub_title' => ['Подзаголовок'],
		'short_content' => ['Краткое описание'],
		'hit' => ['Хит продаж'],
		'sale' => ['Акция'],
		'new' => ['Новинка'],
		'hot' => ['Горячее предложение'],
		'discount' => ['Скидка'],
		'price' => ['Цена'],
		'parent_id' => ['Выбрать категорию', '(К чему относится?)'],
		'promo_img' => ['Изображение для главной страницы'],
		'login' => ['Логин'],
		'password' => ['Пароль', '(зашифрован md5)'],
		'map_coordinates' => ['координаты карты', '(пример: 47.995140, 37.683212)'],
		'map_address' => ['адрес на карте'],
		'scroll_to' => ['указатель на раздел'],
		'work_time' => ['График работы']
		//'filters' => ['Категории фильтров']
	];

	// св-во, в котором будут храниться значения для input type radio (кнопок переключателей (да, нет и т.д.))
	private $radio = [

		'visible' => ['НЕТ', 'ДА', 'default' => 'ДА'],
		'show_top_menu' => ['НЕТ', 'ДА', 'default' => 'ДА'],
	];

	// св-во, в котором будет храниться информация о корневых таблицах (Выпуск №40 метод получения данных из связанных таблиц)
	private $rootItems = [
		'name' => 'Корневая',
		'tables' => ['site_categories', 'filters']
	];

	// свойство для автоматизации связей многие ко многим
	private $manyToMany = [
		// массив содержит название таблиц, которые связаны в БД
		'goods_filters' => ['goods', 'filters'/* , 'type' => 'root' */], // 'type' => 'child' || 'root' - необязательный 
		// 3-ий элемент массива: показывает (здесь- в товарах) только дочерние элементы или только родительские категории. 
		// Без него (по умолчанию) будет показано всё (т.е и название фильтра и его значения)
	];

	// св-во, в котором будут храниться названия блоков админки (левого, правого, центрального) и их содержимое 
	// (по умолчанию содержимое разделов адмики занимает левый блок: vg-rows) 
	private $blockNeedle = [
		'vg-rows' => [],
		'vg-img' => ['img', 'img_logo', 'img_footer', 'map_img', 'gallery_img', 'img_horizontal', 'bg_img'],
		'vg-content' => ['content']
	];

	// свойство, в котором будет храниться массив полей, которые мы будем валидировать
	private $validation = [
		'name' => ['empty' => true, 'trim' => true],
		'price' => ['int' => true],
		'discount' => ['int' => true],
		'login' => ['empty' => true, 'trim' => true],
		'password' => ['crypt' => true, 'empty' => true],
		'keywords' => ['count' => 70, 'trim' => true],
		'description' => ['count' => 160, 'trim' => true]
	];

	// Объявим метод, который будет возвращать указанные выше свойства
	// на вход этому методу (в параметры) мы передаём свойство, которое мы хотим получить
	/**
	 * Метод возвращает свойства, описанные в классе базовых настроек
	 */
	static public function get($property)
	{
		// метод get() обращается к методу instance() данного класса (этот метод возвращает свойство в которое будет 
		// записана (сохранена) ссылка на объект данного класса) и мы можем обратиться к этому объекту и к его свойству, 
		// имя которого пришло на вход функции get()
		return self::instance()->$property;
	}

	// Определим функцию (метод), которая будет клеять (объединять) свойства, например из массива шаблонов и свойства 
	// из массива плагина, если такие ему понадобятся (чтобы нам не приходилось дублировать свойства вручную)	 
	// (в параметры приходит класс с которым мы работаем)

	/**
	 * Метод добавит необходимые свойства в массив свойств к уже прописанным ранее 
	 */
	public function clueProperties($class)
	{
		// определим массив свойств, которые будут возвращаться (например ShopSettings и тогда мы можем вызвать статический метод get(),который нам вернёт то или иное свойство)
		$baseProperties = [];

		// так как перед вызовом функции clueProperties() в классе ShopSettings в файле BaseSettings.php, был создан объект данного класса, 
		// в этой функции теперь доступно использование ключевого слова $this которая ссылается на объект нашего класса
		// пройдёмся в цикле по объекту нашего класса $this как имя(название) свойства $name и значения свойства $item
		foreach ($this as $name => $item) {

			// на каждой итерации цикла в переменную: $property сохраним свойства класса, который мы передали в параметры функции 
			// (указываем переданный класс и вызываем у него метод get() на вход которого передаём имя свойства, которое у нас пришло в 
			// качестве имени свойства $name)
			$property = $class::get($name);

			// поверка условия: функция is_array() проверяет: является ли массивом то, что приходит ей на вход 
			// (т.е. являются ли свойство private $templateArr из файла Settings.php и свойство private $templateArr ($property) из 
			// файла ShopSettings.php ($item) массивами)
			if (is_array($property) && is_array($item)) {
				// то нам нужно их клеить (соединять)
				$baseProperties[$name] = $this->arrayMergeRecursive($this->$name, $property);
				// уходим на следующую итерацию цикла
				continue;
			}

			// если свойство есть только в основном объекте настроек и отсутствует в другом (для которого делается склейка),
			// тогда в переменную: $property придёт- null, false (т.е. пусто)
			if (!$property) {
				// то берём наш результирующий массив $baseProperties и в его ячейку $name запишем, то что находится в 
				// свойстве основного объекта настроек (т.к. нам нужно вытащить все свойства основного объекта настроек)
				$baseProperties[$name] = $this->$name;
			}
		}
		// вернём наш результирующий массив $baseProperties
		return $baseProperties;
	}

	// объявим функцию которая будет склеивать массивы свойств 
	// (в параметры(на вход) ей ничего не передаём, т.к. аргументы (здесь- массивы свойств) передавались на вход при вызове функции 
	// arrayMergeRecursive() и уже попали в память) Из памяти их вытащит функция php: func_get_args()

	/** 
	 * Метод склеит массивы свойств (если в массиве нумерованный ключ, то массивы склеятся Если есть ячейка и в 1-ом и во 2-ом массиве, в которой ключ строковый и мы его переобъявили, то значение заменится Если ячейки не было, то она добавится)
	 */
	public function arrayMergeRecursive()
	{
		// объявим переменную в которую сохраним результат работы функции php: func_get_args(), т.е. получим аргументы, 
		// передаваемые при вызове функции: arrayMergeRecursive()
		$arrays = func_get_args();

		// в переменную $base сохраним результат работы функции php: array_shift(), которая возвращает первый элемент массива поданного на вход(здесь- массив $namе) 
		// и при этом удаляет его из $arrays (здесь- останется только второй элемент массива: массив $property)  
		$base = array_shift($arrays);

		// в цикле мы должны пройтись по массиву $arrays и забирать из него оставшийся массив $array
		foreach ($arrays as $array) {
			// в цикле мы должны пройтись по массиву $array как ключ(имя) $key и значение $value
			foreach ($array as $key => $value) {
				// поверка условия: функция is_array() проверяет: является ли массивом то, что приходит ей на вход, т.е. является ли 
				// массивами $value и $base (здесь нам нужен его конкретный элемент с таким же именем ($key) как и у массива $array)
				// (т.е. если это одинаковые свойства)
				if (is_array($value) && is_array($base[$key])) {
					// то ничего не будем делать, а рекурсивно вызовем наш метод arrayMergeRecursive()
					// обратимся к массиву $base и его ячейке $key и сохраняем результат работы функции arrayMergeRecursive(), на вход 
					// которой подаём: массив $base и его ячейке $key. а также значение $value
					$base[$key] = $this->arrayMergeRecursive($base[$key], $value);
				} else {
					// проверка: нумерованный ли массив ()
					//  функция php: is_int() проверяет целое ли число сюда пришло или пытается строку вида (например '1') привести к целочисленному типу если да:
					if (is_int($key)) {
						// то выполним ещё одну проверку: если не существует такой элемент в массиве
						// первым аргументом мы передаём значение, которое мы ищем ($value), а вторым- массив в котором осуществлем поиск ($base)
						if (!in_array($value, $base)) {
							// если такого значения ($value) не существует. то мы закинем его в проверяемый массив ($base)
							array_push($base, $value);
						}
						// уходим на следующую итерацию цикла
						continue;
					}
					// если ключ не числовой, а строковый, то мы его дожны переопределить, а не просто добавить этот элемент
					// перезапишем в массиве $base его ячейку $key значением $value;
					$base[$key] = $value;
				}
			}
		}
		// возвращаем массив $base
		return $base;
	}
}
