<?php if (!empty($section_top)) : ?>

	<!-- section-top -->
	<section class="main-slider swiper">

		<div class="main-slider__inner swiper-wrapper">

			<?php foreach ($section_top as $item) : ?>

				<div class="main-slider__item lazy swiper-slide">
					<div class="main-slider__content">
						<h2 class="main-slider__title">

							<?= $item['name'] ?>

						</h2>
						<p class="main-slider__text">

							<?= $item['short_content'] ?>

						</p>

					</div>
					<img class="main-slider__img" src="<?= $this->img($item['img']) ?>" alt="<?= $this->set['name'] ?>">
				</div>

			<?php endforeach; ?>

		</div>

	</section>

<?php endif; ?>

<section class="benefits">

	<div class="container--small">
		<div class="benefits-row">

			<div class="benefits-item">
				<img src="<?= TEMPLATE ?>/assets/images/section-01/free-icon-map.png" alt="Адрес пансиона Осень жизни" class="benefits-item-icon">
				<p class="benefits-item-desc"><?= $this->set['address'] ?></p>
			</div>

			<div class="benefits-item">
				<img src="<?= TEMPLATE ?>/assets/images/section-01/phone.png" alt="Телефоны пансиона Осень жизни" class="benefits-item-icon">
				<a href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone']) ?>"><?= $this->set['phone'] ?></a>
				<a href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone_two']) ?>"><?= $this->set['phone_two'] ?></a>
			</div>

			<div class="benefits-item">
				<img src="<?= TEMPLATE ?>/assets/images/section-01/free-icon-clock.png" alt="картинка" class="benefits-item-icon">
				<p class="benefits-item-desc"><?= $this->set['work_time'] ?></p>
			</div>

		</div>
	</div>
</section>

<?php if (!empty($information_section)) : ?>

	<h1 class="page-title section-about__title section-about">О пансионе</h1>

	<div class="parent container">

		<?php foreach ($information_section as $item) : ?>

			<div class="about-company">
				<img src="<?= $this->img($item['img']) ?>" alt="<?= $item['name'] ?>">

				<?= $item['content'] ?>

			</div>

		<?php endforeach; ?>

	</div>

<?php endif; ?>

<section class="blog">
	<div class="container">
		<h2 class="title blog__title" style="text-align: center; font-size: 36px;">Поселение:</h2>
		<div style="font-size: 22px;">
			<?= $this->set['content'] ?>
		</div>
		<p class="blog__text" style="font-size: 24px; text-align: center;"><?= $this->set['short_content'] ?></p>
	</div>
</section>

<?php if (!empty($fotos)) : ?>

	<section class="section-about" style="margin-bottom: 75px;">
		<div class="container section-contacts__container">
			<div class="section__header-01" style="margin: 35px 0px;">
				<h1 class="page-title section-about__title">Фото</h1>
			</div>
			<div class="seven__block">
				<div class="seven__items">

					<?php foreach ($fotos as $item) : ?>

						<div class="seven__item">
							<div class="seven__image">
								<img src="<?= $this->img($item['img']) ?>" alt="<?= $item['name'] ?>">
							</div>
						</div>

					<?php endforeach; ?>

				</div>
			</div>
		</div>
	</section>

<?php endif; ?>

<!-- section-contacts -->
<section class="section-contacts">
	<div class="container section-contacts__container">

		<header class="section__header">
			<h2 class="page-title sectoin-contacts__title">Контакты</h2>
		</header>
		<div class="contacts">
			<div class="contacts__start">
				<div class="contacts__map" id="ymap" data-coordinates="<?= $this->set['map_coordinates'] ?>"
					data-address="<?= $this->set['map_address'] ?>"></div>
			</div>
			<div class="contacts__end">
				<div class="contacts__item">
					<h3 class="contacts__title">Адрес</h3>
					<p class="contacts__text"><?= $this->set['address'] ?></p>
					<p class="contacts__text" style="font-weight: 700;"><?= $this->set['work_time'] ?></p>
				</div>
				<div class="contacts__item">
					<h3 class="contacts__title">Телефон</h3>
					<p class="contacts__text" style="padding-bottom: 10px;">
						<a class="contacts__phone" href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone']) ?>"><?= $this->set['phone'] ?></a>
					</p>
					<p class="contacts__text">
						<a class="contacts__phone" href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone_two']) ?>"><?= $this->set['phone_two'] ?></a>
					</p>
				</div>
				<div class="contacts__item">
					<h3 class="contacts__title">Эл. почта</h3>
					<p class="contacts__text" style="padding-bottom: 10px;">
						<a class="contacts__phone" href="mailto:<?= $this->set['email'] ?>"><?= $this->set['email'] ?></a>
					</p>
				</div>

				<?php if (!empty($this->socials)) : ?>

					<div class="contacts__item">
						<h3 class="contacts__title">Социальные сети</h3>
						<ul class="socials">


							<?php foreach ($this->socials as $item) : ?>

								<li class="socials__item" style="padding-right: 10px;">
									<a href="<?= $this->alias($item['external_alias']) ?>" class="socials__link">
										<img style="max-width: 50px" src="<?= $this->img($item['img']) ?>" alt="<?= $item['name'] ?>">
									</a>
								</li>

							<?php endforeach; ?>


						</ul>
					</div>

				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<!-- /.section-contacts -->

<?php if (!empty($questions)) : ?>

	<section8 class="page-eight eight">
		<div class="eight__container">

			<h2 class="title blog__title" style="text-align: center; font-size: 28px;">Часто задаваемые вопросы:</h2>

			<div class="eight__rightside">
				<div data-spollers class="spollers">

					<?php foreach ($questions as $item) : ?>

						<div class="spollers__item">
							<button type="button" data-spoller class="spollers__title"><?= $item['name'] ?></button>
							<div class="spollers__body"><?= $item['content'] ?></div>
						</div>

					<?php endforeach; ?>

				</div>
			</div>

		</div>
	</section8>

<?php endif; ?>