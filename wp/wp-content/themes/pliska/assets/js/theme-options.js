(function () {
	// global count variable
	var counter = 0;

	/* Header image paralax effect. Opacity animation on page scroll. */
	function headerParallax() {

		//Return if the option is not set in the theme customizer 
		if (!pliska_customizer_object.animation) return;

		//Return if there is no featured image:
		if (!pliska_customizer_object.has_header_image) return;

		var overlayImg = document.getElementsByClassName('img-overlay')[0];

		if (!overlayImg) return;

		var visible = isInViewport(overlayImg);

		//check if element is visible
		if (!visible) return;

		var scrolled = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
		//default opacity is 0.1
		var alpha = +('0.' + pliska_customizer_object.overlay);
		var background;

		var initY = overlayImg.offsetTop;
		var height = overlayImg.offsetHeight;

		var diff = scrolled - initY;
		var ratio = Math.round((diff / height) * 100);
		var newAlpha = (parseInt(ratio) * 1 / 100);

		if ((parseInt(ratio) > 0)) {
			background = 'rgba(0,0,0,' + (alpha + newAlpha) + ')';
			overlayImg.style.backgroundColor = background;

		} else {
			background = 'rgba(0,0,0,' + alpha + ')';
			overlayImg.style.backgroundColor = background;
		}

	}
	/* add fixed and sticky menu classes */
	function fixedMenu() {
		var fixedHeader = pliska_customizer_object.fixed_header;
		var stickyHeader = pliska_customizer_object.sticky_header;

		//Return if static header 
		if (!fixedHeader && !stickyHeader) return;

		var scrollBarPosition = window.pageYOffset | document.body.scrollTop;
		var topMenu = document.getElementsByClassName('main-navigation-container')[0];

		if (scrollBarPosition > 50) {
			if (topMenu.className.indexOf('fixed-header') == -1) {
				topMenu.className += ' fixed-header';
			}
		} else {
			topMenu.className = topMenu.className.replace('fixed-header', '');
		}

		if (stickyHeader) {
			if (scrollBarPosition > 50) {
				if (topMenu.className.indexOf('sticky-header') == -1) {
					topMenu.className += ' sticky-header';
				}
			} else {
				topMenu.className = topMenu.className.replace('sticky-header', '');
			}
		}
	}

	function noHeaderImagePadding() {
		if (pliska_customizer_object.has_header_image) return;
		if (document.body.className.indexOf('static-header') == -1) {
			var menuHeight = document.getElementById("main-navigation").offsetHeight + 30;
			menuHeight += 'px'
			document.getElementById('masthead').style.paddingBottom = menuHeight;
		}
	}

	// animate post archives
	function postLoopAnimation() {
		if (document.body.className.indexOf('single') > -1 || document.body.classList.contains('page')) return;
		var articles = document.getElementsByClassName('hentry');
		animator(articles);
	}
	//animate the static homepage
	function homePageAnimation() {
		if (document.body.className.indexOf('page') == -1) return;
		var sections = document.querySelectorAll('.entry-content > div');
		var form = document.getElementsByClassName('mc4wp-form');
		animator(sections);
		animator(form);
	}

	function backToTop() {
		var backToTopBtn = document.getElementById('back-to-top');
		if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
			backToTopBtn.style.display = "block";

		} else {
			backToTopBtn.style.display = "none";
		}
	}

	// Site preloader
	function preloader() {
		var spinner = document.getElementsByClassName('preloader')[0];
		if (!spinner) return;
		if (spinner.length) {
			spinner.style.animation = 'none';
		}
		spinner.style.opacity = 0;
		setTimeout(function () {
			spinner.parentNode.removeChild(spinner);
		}, 350);
	}

	// Helper to check if element is in viewport
	function isInViewport(element) {
		var rect = element.getBoundingClientRect();
		var elemTop = rect.top + 35;
		var elemBottom = rect.bottom;
		isVisible = elemTop < window.innerHeight && elemBottom >= 0;
		return isVisible;
	}

	// Helper function to animate all elements in viewport
	function animator(articles) {
		for (var i = 0; i < articles.length; i++) {
			var article = articles[i];
			var visible = isInViewport(article);

			if (visible) {
				if (article.className.indexOf('animated') == -1) {
					article.className += ' animated'
				}
			}
		}
	}

	// Helper function to optimize the expensive on-scroll events
	function debounce(func, wait, immediate) {
		var timeout;
		return function () {
			var context = this,
				args = arguments;
			var later = function () {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};

	// header bounce animation
	function animateSiteHeadline() {
		//Return if the option is not set in the theme customize
		if (!pliska_customizer_object.has_header_image) return;
		if (pliska_customizer_object.site_title_animation !== 'bounce') return;
		var pageTitle = document.getElementsByClassName('entry-title')[0],
			newCount = '';
		if (!pageTitle) return;
		
		for (i = 0; i < pageTitle.innerText.length; i++) {
			if (pageTitle.innerText[i] !== ' ') {
				newCount += '<span>' + pageTitle.innerText[i] + '</span>';
			}
			else {
				newCount += '&nbsp'
			}
		}
		pageTitle.innerHTML = newCount;

		var pageTitlevarters = pageTitle.getElementsByTagName('span');
		var animationDelayCounter = 1;

		for (i = 0; i < pageTitlevarters.length; i++) {
			animationDelayCounter += 0.05;
			pageTitlevarters[i].style.animationDelay = animationDelayCounter + 's';
		}
	}

	//stats counter animation
	function animateValue(obj, start, beforeChars, end, afterChars, duration) {
		var startTimestamp = null;
		var step = function (timestamp) {
			if (!startTimestamp) startTimestamp = timestamp;
			var progress = Math.min((timestamp - startTimestamp) / duration, 1);
			obj.innerHTML = beforeChars + Math.floor(progress * (end - start) + start) + afterChars;
			if (progress < 1) {
				window.requestAnimationFrame(step);
			}
		}
		window.requestAnimationFrame(step);
	}

	function runStatsAnimation() {
		var objects = document.querySelectorAll('.section-stats-counter .increase h2');
		if (counter > 0) return;
		for (i = 0; i < objects.length; i++) {
			var obj = objects[i];
			var objNumber = obj.textContent.replace(/\D/g, '');
			var objBeforeChars = obj.textContent.match(/[^0-9]*/);
			var objAfterChars = obj.textContent.match(/[^0-9]*$/);
			var visible = isInViewport(obj);
			if (visible) {
				animateValue(obj, 0, objBeforeChars, objNumber, objAfterChars, 2250);
				counter++;
			}
		}
	}

	//trigger animations
	window.addEventListener('scroll', fixedMenu);
	window.addEventListener('scroll', headerParallax);
	window.addEventListener('scroll', debounce(postLoopAnimation, 100));
	window.addEventListener('scroll', debounce(homePageAnimation, 100));
	window.addEventListener('scroll', debounce(backToTop, 150));
	window.addEventListener('load', preloader);
	window.addEventListener('scroll', debounce(runStatsAnimation, 150));
	document.addEventListener('DOMContentLoaded', function () {
		animateSiteHeadline();
		noHeaderImagePadding();
	})

})();

// Sticky Header functionality
(function () {
	if (pliska_customizer_object.sticky_header !== '1') return;
	var doc = document.documentElement;
	var w = window;

	var prevScroll = w.scrollY || doc.scrollTop;
	var curScroll;
	var direction = 0;
	var prevDirection = 0;

	function checkScroll() {

		curScroll = w.scrollY || doc.scrollTop;
		if (curScroll > prevScroll) {
			//scrolled up
			direction = 'up';
		} else if (curScroll < prevScroll) {
			//scrolled down
			direction = 'down';
		}

		if (direction !== prevDirection) {
			toggleHeader(direction, curScroll);
		}

		prevScroll = curScroll;
	};

	function toggleHeader(direction, curScroll) {
		var header = document.getElementsByClassName('main-navigation-container')[0];
		if (direction === 'up' && curScroll > 50) {
			header.classList.remove('show');
			prevDirection = direction;
		} else if (direction === 'down') {
			header.classList.add('show');
			prevDirection = direction;
		}
	};

	window.addEventListener('scroll', checkScroll);

})();