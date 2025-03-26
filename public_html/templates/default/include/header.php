<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">



	<meta name="description" content="Сайт Построен — создание и продвижение сайтов">
	<meta name="keywords" content="создать сайт в Донецке, сделать сайт в Донецке, интернет-магазин в Донецке, визитки">

	<meta property="og:title" content="Сайт Построен — создание и продвижение сайтов, дизайн визиток" />
	<meta property="og:description" content="Сайт Построен — создание и продвижение сайтов в Донецке" />
	<meta property="og:image" content="" />




	<title>Пансион | Осень жизни | Донецк</title>

	<?php $this->getStyles() ?>

	<script>
		var ForJS = {};
		/* укажем для описания полного пути к маркеру(картинки-лого) на карте */
		/* Остальное описано в main.js  */

		ForJS.imgMap = '<?= $this->img($this->set['map_img']) ?>';
	</script>

</head>

<body>

	<!-- header-page -->
	<header class="header-page">
		<div class="container header-page__container">
			<div class="header-page__start">
				<a href="/" class="logo">
					<img class="logo__img lazy" src="<?= TEMPLATE ?>/assets/images/section-01/логотип-осень жизни.jpg"
						alt="sait postroen">
				</a>
			</div>
			<div class="header-page__end">
				<nav class="header-page__nav">
					<ul class="header-page__ul">

						<li class="header-page__li">
							<a class="header-page__link" href="#" data-scroll-to="section-about">
								<span class="header-page__text">О нас</span>
							</a>
						</li>
						<li class="header-page__li">
							<a class="header-page__link" href="#" data-scroll-to="blog">
								<span class="header-page__text">Поселение</span>
							</a>
						</li>
						<li class="header-page__li">
							<a class="header-page__link" href="#" data-scroll-to="section-contacts">
								<span class="header-page__text">Контакты</span>
							</a>
						</li>
					</ul>
				</nav>
				<div class="phone">
					<a class="phone__item header-page__phone" href="tel:+79999999999">+7 (949) 407-90-93</a>
					<a class="phone__item header-page__phone" href="tel:+79999999999">+7 (949) 613-89-80</a>
				</div>
				<div class="header-page__hamburger">
					<button class="btn-menu" type="button" data-popup="popup-menu">
						<span class="btn-menu__box">
							<span class="btn-menu__inner"></span>
						</span>
					</button>
				</div>
			</div>
		</div>
	</header>
	<!-- /.header-page -->

	<main class="main">