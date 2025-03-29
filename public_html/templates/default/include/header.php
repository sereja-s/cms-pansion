<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="icon" href="<?= SITE_URL ?>/favicon.ico" type="image/x-icon">

	<meta name="description" content="Пансион для пожилых людей и инвалидов в Донецке ДНР <?= $this->set['phone'] ?>, <?= $this->set['phone_two'] ?>. Круглосуточная забота о ваших близких. Опытный персонал. Контроль за состоянием здоровья. Домашний уют и комфорт. Уход 24/7.">
	<meta name="keywords" content="Пансион для пожилых людей и инвалидов в Донецке, ДНР">

	<meta property="og:title" content="<?= $this->set['keywords'] ?>" />
	<meta property="og:description" content="Пансион для пожилых людей и инвалидов в Донецке. Уход 24/7 с проживанием для пожилых в Донецке. Комфортное проживание. Уборка, смена белья. Связь с родными" />
	<meta property="og:image" content="<?= $this->img($this->set['img_logo']) ?>" />

	<link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
	<link rel="shortcut icon" href="/favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
	<link rel="manifest" href="/favicon/site.webmanifest" />

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
				<a href="<?= $this->alias() ?>" class="logo">
					<img class="logo__img lazy" src="<?= $this->img($this->set['img_logo']) ?>"
						alt="<?= $this->set['name'] ?>">
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
					<a class="phone__item header-page__phone" href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone']) ?>"><?= $this->set['phone'] ?></a>
					<a class="phone__item header-page__phone" href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone_two']) ?>"><?= $this->set['phone_two'] ?></a>
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