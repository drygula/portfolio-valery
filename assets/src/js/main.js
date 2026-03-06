jQuery(function ($) {
	$(document).ready(function () {
		$('#preloader').fadeOut(1000);

		headerInit();
		navigationInit();
		slidersInit();
		modalsInit();
	});

	function headerInit() {
		/* ---------- ELEMENTS ---------- */
		var $header = $('.header');
		var $toggle = $('[data-menu-toggle]');
		var $drawer = $('[data-menu-drawer]');
		var $links = $('[data-menu-link]');

		/* ---------- SCROLL STATE ---------- */
		function setScrolled() {
			if ($(window).scrollTop() > 12) {
				$header.addClass('_scrolled');
			} else {
				$header.removeClass('_scrolled');
			}
		}

		/* ---------- MENU STATE ---------- */
		function setMenu(open) {
			$header.toggleClass('header--menu-open', open);
			$toggle.attr('aria-expanded', open.toString());
		}

		/* ---------- INIT ---------- */
		setScrolled();

		$(window).on('scroll', function () {
			setScrolled();
		});

		/* ---------- EVENTS ---------- */
		if ($toggle.length && $drawer.length) {
			$toggle.on('click', function () {
				var open = !$header.hasClass('header--menu-open');
				setMenu(open);
			});

			$links.on('click', function () {
				setMenu(false);
			});
		}
	}

	function modalsInit() {
		const POPUP_INDEX = window.popupsData.popupsIndex;

		let lastFocus = null;

		$(document).on('click', '[data-modal-close]', closeModal);
		$(document).on('keydown', function (e) {
			if (e.key === 'Escape' && !$('#modal').attr('hidden')) closeModal();
		});

		$(document).on('click', '.js-open-popup', function () {
			const card = $(this).closest('[data-id]'),
				id = card.data('id'),
				cardType = card.hasClass('course-card') ? 'course' : 'service',
				data = POPUP_INDEX[cardType][id],
				symbols = {
					'UAH': '₴',
					'USD': '$',
					'EUR': '€',
				};

			if (!data) return;

			$('#modal__image').attr('src', data.image || '');
			$('#modal__title').text(data.title || '');
			$('#modal__description').html(data.description || '');
			$('#modal__price').text(data.price + symbols[data.currency] || '');
			$('#order-item-id').val(id || '');
			$('#order-title').val(data.title || '');
			$('#order-price').val(data.price || '');

			openModal();
		});

		document.addEventListener('wpcf7mailsent', function (event) {
			if (event.detail.contactFormId != 116) return;

			$('#liqpay-form').submit();
		});

		function openModal() {
			lastFocus = document.activeElement;
			const $modal = $('#modal');
			$modal.addClass('_active');
			$('body').addClass('_locked');

			$modal.find('.modal__dialog')[0].focus();
			updateSignature($modal.find('#liqpay-form')[0]);
		}

		function closeModal() {
			const $modal = $('#modal');
			$modal.removeClass('_active');
			$('body').removeClass('_locked');
			if (lastFocus) lastFocus.focus();
		}

		function updateSignature(form) {
			const data_field = $(form).find('[name="data"]'),
				signature_field = $(form).find('[name="signature"]'),
				formData = $(form).serialize();

			$.ajax({
				url: ajax_object.ajax_url,
				type: 'POST',
				data: {
					action: 'handle_order_form_ajax',
					form_data: formData,
				},
				success: function (response) {
					if (response.success) {
						data_field.val(response.data.data);
						signature_field.val(response.data.signature);
						console.log(response.data);
					}
				},
				error: function () {
					console.error('AJAX error');
				},
			});
		}
	}

	function navigationInit() {
		const nav = $('.js-nav'),
			button = $('.js-nav-button'),
			body = $('body');
		button.on('click', function () {
			if (button.hasClass('_active')) {
				button.removeClass('_active');
				nav.removeClass('_active');
				body.removeClass('_locked');
			} else {
				button.addClass('_active');
				nav.addClass('_active');
				body.addClass('_locked');
			}
		});
		$('.js-navigation').on('click', function (e) {
			button.removeClass('_active');
			nav.removeClass('_active');
			body.removeClass('_locked');

			const url = new URL(this.href);
			const current = new URL(window.location.href);

			if (url.pathname === current.pathname && url.origin === current.origin) {
				const $target = $(url.hash);

				if ($target.length) {
					e.preventDefault();
					$('html, body').animate(
						{
							scrollTop: $target.offset().top - 30,
						},
						600,
					);

					history.pushState(null, '', url.hash);
				}
			}
		});
	}

	function slidersInit() {
		const coursesSlider = $('.courses__slider'),
			servicesSlider = $('.services__slider');
		if (coursesSlider.length) {
			coursesSlider.each(function (index, slider) {
				new Swiper(slider, {
					slidesPerView: 1.2,
					spaceBetween: 12,
					loop: false,
					centeredSlides: false,
					speed: 600,
					keyboard: {
						enabled: true,
						onlyInViewport: false,
					},
					breakpoints: {
						768: {
							slidesPerView: 2.4,
							spaceBetween: 20,
						},
						1024: {
							spaceBetween: 0,
						},
					},
				});
			});
		}
		if (servicesSlider.length) {
			servicesSlider.each(function (index, slider) {
				new Swiper(slider, {
					slidesPerView: 1.2,
					spaceBetween: 12,
					loop: false,
					centeredSlides: false,
					speed: 600,
					keyboard: {
						enabled: true,
						onlyInViewport: false,
					},
					breakpoints: {
						768: {
							spaceBetween: 20,
							slidesPerView: 2.1,
						},
						1024: {
							spaceBetween: 0,
						},
					},
				});
			});
		}
	}
});
