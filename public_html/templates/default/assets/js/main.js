//===================================================================================================================//

/* myLib start - набор повторяющихся элементов для повторного использования */
; (function () {

	// создаём глобальную переменную (пустой объект)
	window.myLib = {};


	// допишем в него повторяющиеся элементы и функции:

	window.myLib.body = document.querySelector('body');


	window.myLib.closestAttr = function (item, attr) {
		var node = item;

		while (node) {
			var attrValue = node.getAttribute(attr);
			if (attrValue) {
				return attrValue;
			}

			node = node.parentElement;
		}

		return null;
	};


	/**
	 * функция находит ближайший элемент у которого класс соответствует параметру переданному на вход 2-ым: className
	 * @param {*} item 
	 * @param {*} className 
	 * @returns 
	 */
	window.myLib.closestItemByClass = function (item, className) {
		var node = item;

		while (node) {
			if (node.classList.contains(className)) {
				return node;
			}

			node = node.parentElement;
		}

		return null;
	};

	// чтобы отключить прокручивание контента под открытым попапом, в функции добавляем(убираем) для body, класс: 
	// no-scroll (для которого прописано соответствующее св-во в main.css)
	window.myLib.toggleScroll = function () {
		myLib.body.classList.toggle('no-scroll');
	};
})();
/* myLib end */

//===================================================================================================================//

/* header start - изменение высоты шапки в начале прокрутки (если разиер экрана больше 992px */

/* ; (function () {
	if (window.matchMedia('(max-width: 992px)').matches) {
		return;
	}

	var headerPage = document.querySelector('.header-page');

	window.addEventListener('scroll', function () {
		if (window.pageYOffset > 0) {
			headerPage.classList.add('is-active');
		} else {
			headerPage.classList.remove('is-active');
		}
	});
})(); */
/* header end */

//====================================================================================================================//

// #5 Верстка сайта для начинающих | JavaScript. Настройка попапов, скролл к элементам

/* popup start */
; (function () {

	var showPopup = function (target) {
		target.classList.add('is-active');
	};

	var closePopup = function (target) {
		target.classList.remove('is-active');
	};

	myLib.body.addEventListener('click', function (e) {
		var target = e.target;
		var popupClass = myLib.closestAttr(target, 'data-popup');

		if (popupClass === null) {
			return;
		}

		e.preventDefault();
		var popup = document.querySelector('.' + popupClass);

		if (popup) {
			showPopup(popup);
			myLib.toggleScroll();
		}
	});

	// закрытие попапа при нажатии на закрывающей кнопке открытого попапа или затемнённой области вокруг
	myLib.body.addEventListener('click', function (e) {
		var target = e.target;

		if (target.classList.contains('popup-close') ||
			target.classList.contains('popup__inner')) {
			var popup = myLib.closestItemByClass(target, 'popup');

			closePopup(popup);
			myLib.toggleScroll();
		}
	});

	// закрытие попапа при нажатии на клавишу: Esc (keyCode === 27)
	myLib.body.addEventListener('keydown', function (e) {
		if (e.keyCode !== 27) {
			return;
		}

		var popup = document.querySelector('.popup.is-active');

		if (popup) {
			closePopup(popup);
			myLib.toggleScroll();
		}
	});
})();

/* popup end */

/* scrollTo start - переход к конкретному месту сайта при нажатии на соответствующий пункт меню или кнопку */
; (function () {

	var scroll = function (target) {
		var targetTop = target.getBoundingClientRect().top;
		var scrollTop = window.pageYOffset;
		var targetOffsetTop = targetTop + scrollTop;
		var headerOffset = document.querySelector('.header-page').clientHeight;

		window.scrollTo(0, targetOffsetTop - headerOffset);
	}

	myLib.body.addEventListener('click', function (e) {
		var target = e.target;
		var scrollToItemClass = myLib.closestAttr(target, 'data-scroll-to');

		if (scrollToItemClass === null) {
			return;
		}

		e.preventDefault();
		var scrollToItem = document.querySelector('.' + scrollToItemClass);

		if (scrollToItem) {
			scroll(scrollToItem);
		}
	});
})();
/* scrollTo end */

//===================================================================================================================//

// #6 Верстка сайта для начинающих | JavaScript. Фильтр, динамические данные, яндекс карта

/* catalog start - при нажатии на категорию выводятся товары данной категории */
; (function () {
	var catalogSection = document.querySelector('.section-catalog');

	if (catalogSection === null) {
		return;
	}


	/**
	 * функция удаляющая все дочерние злементы из показа (не будут выводиться на экран) для поданого на вход параметра
	 * @param {*} item 
	 */
	var removeChildren = function (item) {

		// Свойство firstChild обеспечивают быстрый доступ к первому дочернему элементу
		while (item.firstChild) {

			// Операция removeChild разрывает все связи между удаляемым узлом и его родителем
			item.removeChild(item.firstChild);
		}
	};

	/**
	 * функция обновляет содержимое элемента (для вывода на экран) в соответствии с запросом
	 * @param {*} item 
	 * @param {*} children 
	 */
	var updateChildren = function (item, children) {

		// сначала удалим все элементы каталога которые выводились ранее
		removeChildren(item);

		// в цикле добавим в каталог (выведем на экран) необходимые нам элементы каталога (соответствующие выбранной категории)
		for (var i = 0; i < children.length; i += 1) {
			item.appendChild(children[i]);
		}
	};


	var catalog = catalogSection.querySelector('.catalog');
	var catalogNav = catalogSection.querySelector('.catalog-nav');
	var catalogItems = catalogSection.querySelectorAll('.catalog__item');

	catalogNav.addEventListener('click', function (e) {

		// находим элемент по которому кликнули
		var target = e.target;

		// ближайшийЭлементПоклассу
		// находим ближайший элемент у которого класс: catalog-nav__btn
		var item = myLib.closestItemByClass(target, 'catalog-nav__btn');

		// Метод contains для проверки на вложенность (Синтаксис: var result = parent.contains(child);
		// Возвращает true, если parent содержит child или parent == child)
		// Если item равен null или содержит класс: is-active
		if (item === null || item.classList.contains('is-active')) {

			// выходим (на выполняем скрипт)
			return;
		}

		e.preventDefault();

		// получим значение атрибута переданного на вход в качестве параметра методу: getAttribute()
		var filterValue = item.getAttribute('data-filter');

		// найдём предыдущую активную кнопку
		var previousBtnActive = catalogNav.querySelector('.catalog-nav__btn.is-active');

		// удаляем класс: is-active у предыдущей активной кнопки
		previousBtnActive.classList.remove('is-active');

		// а текущей активной кнопке добавляем класс: is-active
		item.classList.add('is-active');

		if (filterValue === 'all') {

			// добавляем все элементы (все элементы каталога будут показаны (выведены на экран))
			updateChildren(catalog, catalogItems);
			return;
		}

		// если значение атрибута элемента на котором сработало событие: click не равно all, то
		var filteredItems = [];

		// в цикле 
		for (var i = 0; i < catalogItems.length; i += 1) {

			// получим текущий элемент
			var current = catalogItems[i];

			// если значение атрибута: data-category текущего элемента, равно значению атрибута полученного ранее: data-filter
			if (current.getAttribute('data-category') === filterValue) {

				// добавляем текущий элемент (в итоге получим массив с отфильтрованными элементами)
				filteredItems.push(current);
			}
		}
		// будут показаны только элементы каталога соответствующие выбранному фильтру
		updateChildren(catalog, filteredItems);
	});
})();

/* map start - подключение карты с реализацией её загрузки только когда доскроллили до секции: section-contacts */
; (function () {
	var sectionContacts = document.querySelector('.section-contacts');

	var ymapInit = function () {
		if (typeof ymaps === 'undefined') {
			return;
		}

		ymaps.ready(function () {

			var ymap = document.querySelector('.contacts__map');
			var coordinates = ymap.getAttribute('data-coordinates');
			var address = ymap.getAttribute('data-address');

			var myMap = new ymaps.Map('ymap', {
				center: coordinates.split(','),
				zoom: 18
			}, {
				searchControlProvider: 'yandex#search'
			}),

				myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
					balloonContent: address
				}, {
					iconLayout: 'default#image',
					iconImageHref: ForJS.imgMap,
					iconImageSize: [100, 70],
					iconImageOffset: [25, -55]
				});

			myMap.geoObjects.add(myPlacemark);

			myMap.behaviors.disable('scrollZoom');
		});
	};


	var ymapLoad = function () {
		var script = document.createElement('script');
		script.src = 'https://api-maps.yandex.ru/2.1/?lang=RU';
		myLib.body.appendChild(script);
		script.addEventListener('load', ymapInit);
	};


	var checkYmapInit = function () {
		var sectionContactsTop = sectionContacts.getBoundingClientRect().top;
		var scrollTop = window.pageYOffset;
		var sectionContactsOffsetTop = scrollTop + sectionContactsTop;

		if (scrollTop + window.innerHeight > sectionContactsOffsetTop) {
			ymapLoad();
			window.removeEventListener('scroll', checkYmapInit);
		}
	};


	window.addEventListener('scroll', checkYmapInit);
	checkYmapInit();
})();
/* map end */

/* form start */
/* ; (function () {
	var forms = document.querySelectorAll('.form-send');

	if (forms.length === 0) {
		return;
	}

	var serialize = function (form) {
		var items = form.querySelectorAll('input, select, textarea');
		var str = '';
		for (var i = 0; i < items.length; i += 1) {
			var item = items[i];
			var name = item.name;
			var value = item.value;
			var separator = i === 0 ? '' : '&';

			if (value) {
				str += separator + name + '=' + value;
			}
		}
		return str;
	};

	var formSend = function (form) {
		var data = serialize(form);
		var xhr = new XMLHttpRequest();
		var url = 'mail/mail.php';

		xhr.open('POST', url);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

		xhr.onload = function () {
			var activePopup = document.querySelector('.popup.is-active');

			if (activePopup) {
				activePopup.classList.remove('is-active');
			} else {
				myLib.toggleScroll();
			}

			if (xhr.response === 'success') {
				document.querySelector('.popup-thanks').classList.add('is-active');
			} else {
				document.querySelector('.popup-error').classList.add('is-active');
			}

			form.reset();
		};

		xhr.send(data);
	};

	for (var i = 0; i < forms.length; i += 1) {
		forms[i].addEventListener('submit', function (e) {
			e.preventDefault();
			var form = e.currentTarget;
			formSend(form);
		});
	}
})(); */
/* form end */

//===================================================================================================================//

const swiper = new Swiper('.swiper', {


	// If we need pagination
	pagination: {
		el: '.swiper-pagination',
		dynamicBullets: true,
	},

	// Navigation arrows
	/* navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	}, */

	// And if we need scrollbar
	/* scrollbar: {
		el: '.swiper-scrollbar',
	}, */

	grabCursor: true,
	loop: true,
	autoplay: {
		delay: 12000,
	},
	speed: 5000,
	effect: 'fade',
	fadeEffect: {
		crossFade: true
	},
});

//============================================ СПОИЛЕР ===================================================================//

let _slideUp = (target, duration = 500, showmore = 0) => {
	if (!target.classList.contains("_slide")) {
		target.classList.add("_slide");
		target.style.transitionProperty = "height, margin, padding";
		target.style.transitionDuration = duration + "ms";
		target.style.height = `${target.offsetHeight}px`;
		target.offsetHeight;
		target.style.overflow = "hidden";
		target.style.height = showmore ? `${showmore}px` : `0px`;
		target.style.paddingTop = 0;
		target.style.paddingBottom = 0;
		target.style.marginTop = 0;
		target.style.marginBottom = 0;
		window.setTimeout(() => {
			target.hidden = !showmore ? true : false;
			!showmore ? target.style.removeProperty("height") : null;
			target.style.removeProperty("padding-top");
			target.style.removeProperty("padding-bottom");
			target.style.removeProperty("margin-top");
			target.style.removeProperty("margin-bottom");
			!showmore ? target.style.removeProperty("overflow") : null;
			target.style.removeProperty("transition-duration");
			target.style.removeProperty("transition-property");
			target.classList.remove("_slide");
			// Создаем событие
			document.dispatchEvent(
				new CustomEvent("slideUpDone", {
					detail: {
						target: target
					}
				})
			);
		}, duration);
	}
};
let _slideDown = (target, duration = 500, showmore = 0) => {
	if (!target.classList.contains("_slide")) {
		target.classList.add("_slide");
		target.hidden = target.hidden ? false : null;
		showmore ? target.style.removeProperty("height") : null;
		let height = target.offsetHeight;
		target.style.overflow = "hidden";
		target.style.height = showmore ? `${showmore}px` : `0px`;
		target.style.paddingTop = 0;
		target.style.paddingBottom = 0;
		target.style.marginTop = 0;
		target.style.marginBottom = 0;
		target.offsetHeight;
		target.style.transitionProperty = "height, margin, padding";
		target.style.transitionDuration = duration + "ms";
		target.style.height = height + "px";
		target.style.removeProperty("padding-top");
		target.style.removeProperty("padding-bottom");
		target.style.removeProperty("margin-top");
		target.style.removeProperty("margin-bottom");
		window.setTimeout(() => {
			target.style.removeProperty("height");
			target.style.removeProperty("overflow");
			target.style.removeProperty("transition-duration");
			target.style.removeProperty("transition-property");
			target.classList.remove("_slide");
			// Создаем событие
			document.dispatchEvent(
				new CustomEvent("slideDownDone", {
					detail: {
						target: target
					}
				})
			);
		}, duration);
	}
};
let _slideToggle = (target, duration = 500) => {
	if (target.hidden) {
		return _slideDown(target, duration);
	} else {
		return _slideUp(target, duration);
	}
};
function dataMediaQueries(array, dataSetValue) {
	// Получение объектов с медиа запросами
	const media = Array.from(array).filter(function (item, index, self) {
		if (item.dataset[dataSetValue]) {
			return item.dataset[dataSetValue].split(",")[0];
		}
	});
	// Инициализация объектов с медиа запросами
	if (media.length) {
		const breakpointsArray = [];
		media.forEach((item) => {
			const params = item.dataset[dataSetValue];
			const breakpoint = {};
			const paramsArray = params.split(",");
			breakpoint.value = paramsArray[0];
			breakpoint.type = paramsArray[1] ? paramsArray[1].trim() : "max";
			breakpoint.item = item;
			if (item.hasAttribute("data-em")) {
				breakpoint.dataEm = true;
			}
			breakpointsArray.push(breakpoint);
		});
		// Получаем уникальные брейкпоинты
		let mdQueries = breakpointsArray.map(function (item) {
			if (item.dataEm) {
				item.value = (item.value / 16).toString();
				return (
					"(" +
					item.type +
					"-width: " +
					item.value +
					"em)," +
					item.value +
					"," +
					item.type
				);
			} else {
				return (
					"(" +
					item.type +
					"-width: " +
					item.value +
					"px)," +
					item.value +
					"," +
					item.type
				);
			}
			// item.value = (item.value / 16).toString()
			// return '(' + item.type + "-width: " + item.value + "em)," + item.value + ',' + item.type;
		});
		mdQueries = uniqArray(mdQueries);
		const mdQueriesArray = [];

		if (mdQueries.length) {
			// Работаем с каждым брейкпоинтом
			mdQueries.forEach((breakpoint) => {
				const paramsArray = breakpoint.split(",");
				const mediaBreakpoint = paramsArray[1];
				const mediaType = paramsArray[2];
				const matchMedia = window.matchMedia(paramsArray[0]);
				// Объекты с нужными условиями
				const itemsArray = breakpointsArray.filter(function (item) {
					if (item.value === mediaBreakpoint && item.type === mediaType) {
						return true;
					}
				});
				mdQueriesArray.push({
					itemsArray,
					matchMedia
				});
			});
			return mdQueriesArray;
		}
	}
}
function spollers() {
	const spollersArray = document.querySelectorAll("[data-spollers]");
	if (spollersArray.length > 0) {
		// Получение обычных слойлеров
		const spollersRegular = Array.from(spollersArray).filter(function (
			item,
			index,
			self
		) {
			return !item.dataset.spollers.split(",")[0];
		});
		// Инициализация обычных слойлеров
		if (spollersRegular.length) {
			initSpollers(spollersRegular);
		}
		let mdQueriesArray = dataMediaQueries(spollersArray, "spollers");
		if (mdQueriesArray && mdQueriesArray.length) {
			mdQueriesArray.forEach((mdQueriesItem) => {
				// Событие
				// mdQueriesItem.matchMedia.addEventListener("change", function () {
				// 	initSpollers(mdQueriesItem.itemsArray, mdQueriesItem.matchMedia);
				// });
				mdQueriesItem.matchMedia.onchange = () => {
					initSpollers(mdQueriesItem.itemsArray, mdQueriesItem.matchMedia);
				};
				initSpollers(mdQueriesItem.itemsArray, mdQueriesItem.matchMedia);
			});
		}
		// Инициализация
		function initSpollers(spollersArray, matchMedia = false) {
			spollersArray.forEach((spollersBlock) => {
				spollersBlock = matchMedia ? spollersBlock.item : spollersBlock;
				if (matchMedia.matches || !matchMedia) {
					spollersBlock.classList.add("_spoller-init");
					initSpollerBody(spollersBlock);
					spollersBlock.addEventListener("click", setSpollerAction);
				} else {
					spollersBlock.classList.remove("_spoller-init");
					initSpollerBody(spollersBlock, false);
					spollersBlock.removeEventListener("click", setSpollerAction);
				}
			});
		}
		// Работа с контентом
		function initSpollerBody(spollersBlock, hideSpollerBody = true) {
			let spollerTitles = spollersBlock.querySelectorAll("[data-spoller]");
			if (spollerTitles.length) {
				spollerTitles = Array.from(spollerTitles).filter(
					(item) => item.closest("[data-spollers]") === spollersBlock
				);
				spollerTitles.forEach((spollerTitle) => {
					if (hideSpollerBody) {
						spollerTitle.removeAttribute("tabindex");
						if (!spollerTitle.classList.contains("_spoller-active")) {
							spollerTitle.nextElementSibling.hidden = true;
						}
					} else {
						spollerTitle.setAttribute("tabindex", "-1");
						spollerTitle.nextElementSibling.hidden = false;
					}
				});
			}
		}
		function setSpollerAction(e) {
			const el = e.target;
			if (el.closest("[data-spoller]")) {
				const spollerTitle = el.closest("[data-spoller]");
				const spollersBlock = spollerTitle.closest("[data-spollers]");
				const oneSpoller = spollersBlock.hasAttribute("data-one-spoller");
				const spollerSpeed = spollersBlock.dataset.spollersSpeed
					? parseInt(spollersBlock.dataset.spollersSpeed)
					: 500;
				if (!spollersBlock.querySelectorAll("._slide").length) {
					if (oneSpoller && !spollerTitle.classList.contains("_spoller-active")) {
						hideSpollersBody(spollersBlock);
					}
					spollerTitle.classList.toggle("_spoller-active");
					_slideToggle(spollerTitle.nextElementSibling, spollerSpeed);
				}
				e.preventDefault();
			}
		}
		function hideSpollersBody(spollersBlock) {
			const spollerActiveTitle = spollersBlock.querySelector(
				"[data-spoller]._spoller-active"
			);
			const spollerSpeed = spollersBlock.dataset.spollersSpeed
				? parseInt(spollersBlock.dataset.spollersSpeed)
				: 500;
			if (
				spollerActiveTitle &&
				!spollersBlock.querySelectorAll("._slide").length
			) {
				spollerActiveTitle.classList.remove("_spoller-active");
				_slideUp(spollerActiveTitle.nextElementSibling, spollerSpeed);
			}
		}
		// Закрытие при клике вне спойлера
		const spollersClose = document.querySelectorAll("[data-spoller-close]");
		if (spollersClose.length) {
			document.addEventListener("click", function (e) {
				const el = e.target;
				if (!el.closest("[data-spollers]")) {
					spollersClose.forEach((spollerClose) => {
						const spollersBlock = spollerClose.closest("[data-spollers]");
						const spollerSpeed = spollersBlock.dataset.spollersSpeed
							? parseInt(spollersBlock.dataset.spollersSpeed)
							: 500;
						spollerClose.classList.remove("_spoller-active");
						_slideUp(spollerClose.nextElementSibling, spollerSpeed);
					});
				}
			});
		}
	}
}
spollers();