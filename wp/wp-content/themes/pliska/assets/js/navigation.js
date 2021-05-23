/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {
	//mobile menu
	var mainNavigation, mainMenu;
	mainNavigation = document.getElementById('main-navigation') || '';
	mainMenu = mainNavigation.getElementsByTagName('ul')[0];
	if (mainMenu.className.indexOf('nav-menu' == -1)) {
		mainMenu.className += ' nav-menu';
	}

	//hamburger menu
	var menuButtons = document.querySelectorAll('.site-menu .menu-toggle');
	// Toggle the .toggled class and the aria-expanded value each time a hamburger menu button is clicked or the enter button is pressed.
	for (i = 0; i < menuButtons.length; ++i) {
		menuButtons[i].addEventListener('click', function (e) {
			toggleMobileMenu(e, this)
		})
		menuButtons[i].addEventListener("keydown", function (e) {
			// Number 13 is the "Enter" key on the keyboard
			if (e.keyCode === 13) {
				toggleMobileMenu(e, this);
				mobileMenuFocusTrap(this);
			}
		});
	}

	function toggleMobileMenu(e, $self) {
		e.preventDefault();
		var toggledIcon = $self.childNodes[1].childNodes[1] || '';
		toggledIcon.checked = !toggledIcon.checked;

		var toggledMenu = $self.parentNode;
		toggledMenu.classList.toggle('toggled');
		document.body.classList.toggle('modal-open');

		if ($self.getAttribute('aria-expanded') === 'true') {
			$self.setAttribute('aria-expanded', 'false');
		} else {
			$self.setAttribute('aria-expanded', 'true');
		}
		// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
		document.addEventListener('click', function (e) {
			// make a list of elements that will keep modal from closing
			var tagNames = ['LABEL', 'INPUT', 'A', 'I', 'svg'];
			var isClickInside = false;
			for (var i = 0; i < tagNames.length; i++) {
				if (tagNames[i] == e.target.tagName) {
					isClickInside = true;
				}
			}
			//Close the modal when user clicks outside the menu links and the hamburger
			if (!isClickInside) {
				toggledMenu.className = toggledMenu.className.replace('toggled', '');
				$self.setAttribute('aria-expanded', 'false');
				toggledIcon.checked = false;
			}
		})
	}

	// Get all the link elements within the site menu
	var links = mainMenu ? mainMenu.getElementsByTagName('a') : '';

	// Get all the link elements with children within the menu.
	var linksWithChildren = document.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

	// Toggle focus each time a menu link is focused or blurred.
	for (i = 0, len = links.length; i < len; i++) {
		links[i].addEventListener('focus', toggleFocus, true);
		links[i].addEventListener('blur', toggleFocus, true);
	}

	// Toggle focus each time a menu link with children receive a touch event.
	for (i = 0, len = linksWithChildren.length; i < len; i++) {
		linksWithChildren[i].addEventListener('touchstart', toggleFocus, false);
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus(e) {
		if (window.matchMedia('(max-width: 600px)').matches) return;
		if (e.type === 'focus' || e.type === 'blur') {
			var self = this;
			// Move up through the ancestors of the current link until we hit .nav-menu.
			while (-1 === self.className.indexOf('nav-menu')) {
				// On li elements toggle the class .focus.
				if ('li' === self.tagName.toLowerCase()) {
					if (-1 !== self.className.indexOf('focus')) {
						self.className = self.className.replace(' focus', '');
					} else {
						self.className += ' focus';
					}
				}
				self = self.parentNode;
			}
		}

		if (e.type === 'touchstart') {
			var menuItem = this.parentNode;
			e.preventDefault();
			for (i = 0; i < menuItem.parentNode.children.length; ++i) {
				var link = menuItem.parentNode.children[i];
				if (menuItem !== link) {
					link.classList.remove('focus');
				}
			}
			menuItem.classList.toggle('focus');
		}
	}
	// Loop through mobile menu items on focus until the menu is closed
	function mobileMenuFocusTrap($self) {
		if (window.matchMedia('(min-width: 600px)').matches) return;
		var focusableItems = mainNavigation.querySelectorAll('.menu-toggle, .menu-item > a, .cart-contents, .search-item button');
		var firstFocusableElement = focusableItems[0]; // get first element to be focused inside modal
		var lastFocusableElement = focusableItems[focusableItems.length - 1]; // get last element to be focused inside modal

		mainNavigation.addEventListener('keydown', function (e) {
			if ($self.getAttribute('aria-expanded') == 'false') return;
			focusElements(firstFocusableElement, lastFocusableElement, e);
		});

	}

	// Search modal focus trap
	function searchModalFocusTrap() {
		if (window.matchMedia('(max-width: 600px)').matches) return;
		var focusableItems = this.querySelectorAll('input, .search-form button, .close');
		var firstFocusableElement = focusableItems[0]; // get first element to be focused inside modal
		var lastFocusableElement = focusableItems[focusableItems.length - 1]; // get last element to be focused inside modal

		this.addEventListener('keydown', function (e) {
			focusElements(firstFocusableElement, lastFocusableElement, e);
		});

	}

	document.getElementById('search-open').addEventListener("keydown", searchModalFocusTrap);

	// Resume keyboard navigation after search modal is closed via keyboard
	document.querySelector('#search-open .close').addEventListener("keydown", function(e){
		// Number 13 is the "Enter" key on the keyboard
		if (e.keyCode === 13) {
			setTimeout(function(){
				document.querySelector('.search-item a').focus();
			}, 100);
		}
	});
	// Resume keyboard navigation after search modal is closed via button click
	document.querySelector('#search-open .close').addEventListener("click", function(e){
		setTimeout(function(){
			document.querySelector('.search-item a').focus();
		}, 100);
	});

	// helper function for the focus trap
	function focusElements(firstEl, lastEl, e){
		if (e.key !== 'Tab' || e.keyCode !== 9) return;
		if (e.shiftKey) { // if shift key pressed for shift + tab combination
			if (document.activeElement === firstEl) {
				lastEl.focus(); // add focus for the last focusable element
				e.preventDefault();
			}
		} 
		else { // if tab key is pressed
			if (document.activeElement==lastEl) { // if focused has reached to last focusable element then focus first focusable element after pressing tab
				firstEl.focus(); // add focus for the first focusable element
				e.preventDefault();
			}
		}
	}

}());