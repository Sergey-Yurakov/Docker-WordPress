/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
	// Site title and description.
	wp.customize('blogname', function (value) {
		value.bind(function (to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function (value) {
		value.bind(function (to) {
			$('.site-description').text(to);
		});
	});

	// Header text color.
	wp.customize('header_textcolor', function (value) {
		value.bind(function (to) {
			if ('blank' === to) {
				$('.site-title, .site-description').css({
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				});
			} else {
				$('.site-title, .site-description').css({
					clip: 'auto',
					position: 'relative',
				});
				$('.site-title a, .site-description').addClass('has-custom-color');
				$('head').append('<style>.fixed-header .site-title .has-custom-color, .site-title .has-custom-color{color:' + to + '}</style>');
			}
		});
	});

	// Call to action edit text
	wp.customize('banner_label_one', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.left-btn .btn').text(to);
				$('.left-btn').removeClass('hide');
			}
			else {
				$('.left-btn').addClass('hide');
			}
		});
	});

	wp.customize('banner_link_one', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.left-btn').removeClass('hide');
			}
			else {
				$('.left-btn').addClass('hide');
			}
		});
	});

	// Call to action edit text
	wp.customize('banner_label_two', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.right-btn .btn').text(to);
				$('.right-btn').removeClass('hide');
			}
			else {
				$('.right-btn').addClass('hide');
			}
		});
	});

	wp.customize('banner_link_two', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.right-btn').removeClass('hide');
			}
			else {
				$('.right-btn').addClass('hide');
			}
		});
	});

	/* Hide/Show Header arrow */
	wp.customize('show_meta_arrow', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.meta-arrow a').show();
				$('.meta-arrow').removeClass('hide');
			} else {
				$('.meta-arrow a').hide();
				$('.meta-arrow').addClass('hide');
			}

		});
	});

	// Post Categories

	wp.customize('show_post_categories', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.cat-links').show();
				$('.cat-links').removeClass('hide');
			} else {
				$('.cat-links').hide();
				$('.cat-links').addClass('hide');
			}

		});
	});

	//Post date
	wp.customize('show_post_date', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.posted-on').show();
				$('.posted-on').removeClass('hide');
			} else {
				$('.posted-on').hide();
				$('.posted-on').addClass('hide');
			}

		});
	});

	// Modified Date
	wp.customize('show_modified_date', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.updated-on').show();
				$('.updated-on').removeClass('hide');
			} else {
				$('.updated-on').hide();
				$('.updated-on').addClass('hide');
			}

		});
	});

	// Show read time
	wp.customize('show_time_to_read', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.time-read-links').show();
				$('.time-read-links').removeClass('hide');
			} else {
				$('.time-read-links').hide();
				$('.time-read-links').addClass('hide');
			}

		});
	});

	// Post Author
	wp.customize('show_post_author', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.byline').show();
				$('.byline').removeClass('hide');
			} else {
				$('.byline').hide();
				$('.byline').addClass('hide');
			}

		});
	});

	// Tags
	wp.customize('show_post_tags', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.tags-links').show();
				$('.tags-links').removeClass('hide');
			} else {
				$('.tags-links').hide();
				$('.tags-links').addClass('hide');
			}

		});
	});

	wp.customize('show_post_likes', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.user_like').show();
				$('.like-counter').show();
				$('.user_like').removeClass('hide');
			} else {
				$('.user_like').hide();
				$('.like-counter').hide();
				$('.user_like').addClass('hide');
			}

		});
	});

	wp.customize('show_post_share_btns', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.post-share-wrap').show();
				$('.post-share-wrap').removeClass('hide');
			} else {
				$('.post-share-wrap').hide();
				$('.post-share-wrap').addClass('hide');
			}

		});
	});

	wp.customize('show_author_box', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.about-author').show();
				$('.about-author').removeClass('hide');
			} else {
				$('.about-author').hide();
				$('.about-author').addClass('hide');
			}

		});
	});

	wp.customize('show_related_posts', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.related-posts-wrapper').show();
				$('.related-posts').removeClass('hide');
			} else {
				$('.related-posts-wrapper').hide();
				$('.related-posts').addClass('hide');
			}

		});
	});

	// Comments
	wp.customize('show_post_comments', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.comments-link').show();
				$('.comments-link').removeClass('hide');
			} else {
				$('.comments-link').hide();
				$('.comments-link').addClass('hide');
			}

		});
	});

	/* Hide/Show Breadcrumbs */
	wp.customize('show_breadcrumbs', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.breadcrumbs').show();
				$('.breadcrumbs').removeClass('hide');
			} else {
				$('.breadcrumbs').hide();
				$('.breadcrumbs').addClass('hide');
			}

		});
	});

	wp.customize('show_page_breadcrumbs', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.breadcrumbs').show();
				$('.breadcrumbs').removeClass('hide');
			} else {
				$('.breadcrumbs').hide();
				$('.breadcrumbs').addClass('hide');
			}

		});
	});

	wp.customize('header_background_size', function (cb) {
		cb.bind(function (size) {
			if (size) {
				$('head').append('<style>.header-image-wrapper{background-size:' + size + '}</style>');
			}
		});
	});

	wp.customize('header_background_position', function (cb) {
		cb.bind(function (position) {
			if (position) {
				$('head').append('<style>.header-image-wrapper{background-position:' + position + '}</style>');
			}
		});
	});

	wp.customize('header_image_height', function (cb) {
		cb.bind(function (height) {
			if (height) {
				$('head').append('<style>.header-image-wrapper{height:' + height + '}</style>');
			}
		});
	});
	//paralax
	wp.customize('header_background_attachment', function (cb) {
		cb.bind(function (attachment) {
			if (attachment) {
				$('head').append('<style>.header-image-wrapper{background-attachment:' + 'fixed' + '}</style>');
			} else {
				$('head').append('<style>.header-image-wrapper{background-attachment:' + 'scroll' + '}</style>');
			}
		});
	});

	// Hide or show Dark mode toggle button

	wp.customize('enable_dark_mode', function (cb) {
		cb.bind(function (to) {
			if (to) {
				$('.dark-mode-widget').show();
				$('.dark-mode-widget').removeClass('hide');
			} else {
				$('.dark-mode-widget').hide();
				$('.dark-mode-widget').addClass('hide');
			}

		});
	});

}(jQuery));