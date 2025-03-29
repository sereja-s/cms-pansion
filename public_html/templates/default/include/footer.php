</main>

<!-- footer-page -->
<footer class="footer-page">
	<div class="container">
		<div class="footer__props" style="text-align: center;">
			<div><?= date('Y') ?> г.</div><br>
			<span style="padding-right: 5px;">сделано в</span>
			<a href="<?= $this->set['external_alias'] ?>" style="text-decoration: none;">САЙТ ПОСТРОЕН</a>
		</div>
		<!-- <div class="footer-page__text">SaitPostroen 2025</div> -->
	</div>
</footer>
<!-- /.footer-page -->


<!-- popup-menu -->
<div class="popup popup-menu">
	<div class="popup__wrapper">
		<div class="popup__inner">
			<div class="popup__content popup__content--fluid popup__content--centered">
				<button class="btn-close popup__btn-close popup-close"></button>
				<nav class="mobile-menu popup__mobile-menu">
					<ul class="mobile-menu__ul">
						<li class="mobile-menu__li">
							<a class="mobile-menu__link popup-close" href="#" data-scroll-to="section-about">О нас</a>
						</li>
						<li class="mobile-menu__li">
							<a class="mobile-menu__link popup-close" href="#" data-scroll-to="blog">Поселение</a>
						</li>
						<li class="mobile-menu__li">
							<a class="mobile-menu__link popup-close" href="#" data-scroll-to="section-contacts">Контакты</a>
						</li>
					</ul>
				</nav>
				<div class="phone popup__phone">
					<a class="phone__item phone__item--accent" href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone']) ?>"><?= $this->set['phone'] ?></a>
				</div>
				<div class="phone popup__phone">
					<a class="phone__item phone__item--accent" href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone_two']) ?>"><?= $this->set['phone_two'] ?></a>
				</div>
				<div class="phone popup__phone">
					<a class="phone__item phone__item--accent" style="color: rgb(44, 125, 212);" href="mailto:<?= $this->set['email'] ?>"><?= $this->set['email'] ?></a>
				</div>

				<?php if (!empty($this->socials)) : ?>

					<ul class="socials">

						<?php foreach ($this->socials as $item) : ?>

							<li class="socials__item" style="padding-right: 10px;">
								<a href="<?= $this->alias($item['external_alias']) ?>" class="socials__link">
									<img style="max-width: 45px;" src="<?= $this->img($item['img']) ?>" alt="<?= $item['name'] ?>">
								</a>
							</li>

						<?php endforeach; ?>

					</ul>

				<?php endif; ?>

			</div>
		</div>
	</div>
</div>
<!-- /.popup-menu -->

<?php $this->getScripts() ?>

</body>

</html>