<?php
/**
 * Theme settings page.
 *
 * @package Color Blog Dark
 * 
 * @since 1.0.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'color_blog_dark_Settings' ) ) :

	class color_blog_dark_Settings {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'color_blog_dark_admin_menu' ) );
			add_action( 'wp_loaded', array( __CLASS__, 'color_blog_dark_hide_notices' ) );
			add_action( 'wp_loaded', array( $this, 'color_blog_dark_admin_notice' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'about_theme_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'about_theme_scripts' ) );
			add_filter( 'admin_footer_text', array( $this, 'color_blog_dark_admin_footer_text' ) );

			//about theme review notice
	        add_action( 'after_setup_theme', array( $this, 'color_blog_dark_theme_rating_notice' ) );
			add_action( 'switch_theme', array( $this, 'color_blog_dark_theme_rating_notice_data_remove' ) );

			add_action( 'wp_ajax_activate_demo_importer_plugin', array( $this, 'activate_demo_importer_plugin' ) );
			add_action( 'wp_ajax_install_demo_importer_plugin', array( $this, 'install_demo_importer_plugin' ) );
		}

		/**
		 * Add admin menu.
		 */
		public function color_blog_dark_admin_menu() {
			$theme = wp_get_theme( get_template() );

			$page = add_theme_page( $theme->display( 'Name' ).' '.esc_html__( 'Settings', 'color-blog-dark' ), $theme->display( 'Name' ).' '.' '.esc_html__( 'Settings', 'color-blog-dark' ), 'activate_plugins', 'color-blog-dark-settings', array( $this, 'get_started_screen' ) );
		}

		/**
		 * Enqueue styles.
		 */
		public function about_theme_styles( $hook ) {
			global $color_blog_dark_theme_version;
				wp_enqueue_style( 'mt-theme-review-notice', get_template_directory_uri() . '/inc/theme-settings/assets/css/theme-review-notice.css', array(), esc_attr( $color_blog_dark_theme_version ) );

			if ( 'appearance_page_color-blog-dark-settings' != $hook && 'themes.php' != $hook ) {
				return;
			}

			wp_enqueue_style( 'mt-theme-settings-style', get_template_directory_uri() . '/inc/theme-settings/assets/css/settings.css', array(), $color_blog_dark_theme_version );
		}

		/**
		 * Enqueue scripts.
		 */
		public function about_theme_scripts( $hook ) {
			global $color_blog_dark_theme_version;

			$theme_notice_option = get_option( 'color_blog_dark_admin_notice_welcome' );
			if ( $theme_notice_option ) {
				wp_enqueue_script( 'mt-theme-review-notice', get_template_directory_uri() . '/inc/theme-settings/assets/js/theme-review-notice.js', array( 'jquery' ), esc_attr( $color_blog_dark_theme_version ) );

				$demo_importer_plugin = WP_PLUGIN_DIR . '/mysterythemes-demo-importer/mysterythemes-demo-importer.php';
				if ( file_exists( $demo_importer_plugin ) && !is_plugin_active( 'mysterythemes-demo-importer/mysterythemes-demo-importer.php' ) ) {
					$action = 'activate';
				} elseif ( !file_exists( $demo_importer_plugin ) ) {
					$action = 'install';
				} else {
					$action = 'redirect';
				}

				wp_localize_script( 'mt-theme-review-notice', 'mtaboutObject', array(
					'ajax_url'	=> esc_url( admin_url( 'admin-ajax.php' ) ),
					'_wpnonce'	=> wp_create_nonce( 'color_blog_dark_admin_plugin_install_nonce' ),
					'action'	=> esc_html( $action )
				));
			}

			if ( 'appearance_page_color-blog-dark-settings' != $hook ) {
				return;
			}

			$activated_plugins = apply_filters( 'color_blog_dark_active_plugins', get_option('active_plugins') );
			$demo_import_plugin = in_array( 'mysterythemes-demo-importer/mysterythemes-demo-importer.php', $activated_plugins );
			if ( $demo_import_plugin ) {
				return;
			}

			wp_enqueue_script( 'mt-theme-settings-script', get_template_directory_uri() . '/inc/theme-settings/assets/js/settings.js', array( 'jquery' ), esc_attr( $color_blog_dark_theme_version ) );

			$demo_importer_plugin = WP_PLUGIN_DIR . '/mysterythemes-demo-importer/mysterythemes-demo-importer.php';
			if ( file_exists( $demo_importer_plugin ) && !is_plugin_active( 'mysterythemes-demo-importer/mysterythemes-demo-importer.php' ) ) {
				$action = 'activate';
			} else {
				$action = 'install';
			}

			wp_localize_script( 'mt-theme-settings-script', 'mtaboutObject', array(
				'ajax_url'	=> esc_url( admin_url( 'admin-ajax.php' ) ),
				'_wpnonce'	=> wp_create_nonce( 'color_blog_dark_admin_plugin_install_nonce' ),
				'action'	=> esc_html( $action )
			));
		}

		/**
		 * Add admin notice.
		 */
		public function color_blog_dark_admin_notice() {

			if ( isset( $_GET['activated'] ) ) {
				update_option( 'color_blog_dark_admin_notice_welcome', true );
			}

			$theme_notice_option = get_option( 'color_blog_dark_admin_notice_welcome' );
			// Let's bail on theme activation.
			if ( $theme_notice_option ) {
				add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			}
		}

		/**
		 * Hide a notice if the GET variable is set.
		 */
		public static function color_blog_dark_hide_notices() {
			if ( isset( $_GET['color-blog-dark-hide-notice'] ) && isset( $_GET['_color_blog_dark_notice_nonce'] ) ) {
				if ( ! wp_verify_nonce( $_GET['_color_blog_dark_notice_nonce'], 'color_blog_dark_hide_notices_nonce' ) ) {
					wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'color-blog-dark' ) );
				}

				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( esc_html__( 'Cheat in &#8217; huh?', 'color-blog-dark' ) );
				}

				$hide_notice = sanitize_text_field( $_GET['color-blog-dark-hide-notice'] );
				update_option( 'color_blog_dark_admin_notice_' . $hide_notice, false );
			}
		}

		/**
		 * Show welcome notice.
		 */
		public function welcome_notice() {
			$theme 		= wp_get_theme( get_template() );
			$theme_name = $theme->get( 'Name' );
	?>
			<div id="mt-theme-message" class="updated notice color-blog-dark-message">
				<a class="color-blog-dark-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'color-blog-dark-hide-notice', 'welcome' ) ), 'color_blog_dark_hide_notices_nonce', '_color_blog_dark_notice_nonce' ) ); ?>">
					<span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'color-blog-dark' ); ?>
				</a>
				<h2 class="welcome-title"><?php printf( esc_html__( 'Welcome to %s', 'color-blog-dark' ), $theme_name ); ?></h2>
				<p>
					<?php printf( esc_html__( 'Welcome! Thank you for choosing %1$s ! To fully take advantage of the best our theme can offer please make sure you visit our %2$s theme settings page %3$s.', 'color-blog-dark' ), '<strong>'. esc_html( $theme_name ).'</strong>', '<a href="' . esc_url( admin_url( 'themes.php?page=color-blog-dark-settings' ) ) . '">', '</a>' ); ?>
				</p>
				<p>
					<?php printf( esc_html__( 'Clicking get started will process to installation of %1$s Mystery Themes Demo Importer %2$s Plugin in your dashboard. After success it will redirect to the theme settings page.', 'color-blog-dark' ), '<strong>', '</strong>' ); ?>
				</p>
				<div class="submit">
					<button class="mt-get-started button button-primary button-hero" data-done="<?php esc_attr_e( 'Done!', 'color-blog-dark' ); ?>" data-process="<?php esc_attr_e( 'Processing', 'color-blog-dark' ); ?>" data-redirect="<?php echo esc_url( wp_nonce_url( add_query_arg( 'color-blog-dark-hide-notice', 'welcome', admin_url( 'themes.php' ).'?page=color-blog-dark-settings&tab=demos' ) , 'color_blog_dark_hide_notices_nonce', '_color_blog_dark_notice_nonce' ) ); ?>">
						<?php printf( esc_html__( 'Get started with %1$s', 'color-blog-dark' ), esc_html( $theme_name ) ); ?>
					</button>
				</div>
				
			</div><!-- #mt-theme-message -->
	<?php
		}

		/**
		 * Intro text/links shown to all about pages.
		 *
		 * @access private
		 */
		private function intro() {
			global $color_blog_dark_theme_version;
			$theme 				= wp_get_theme( get_template() );
			$theme_name 		= $theme->get( 'Name' );
			$author_uri 		= $theme->get( 'AuthorURI' );
			$author_name 		= $theme->get( 'Author' );

			// Drop minor version if 0
	?>
			<div class="color-blog-dark-theme-info mt-theme-info mt-clearfix">
				<h1 class="mt-about-title"> <?php echo esc_html( $theme_name ); ?> </h1>
				<div class="author-credit">
					<span class="theme-version"><?php printf( esc_html__( 'Version: %1$s', 'color-blog-dark' ), $color_blog_dark_theme_version ); ?></span>
					<span class="author-link"><?php printf( wp_kses_post( 'By <a href="%1$s" target="_blank">%2$s</a>', 'color-blog-dark' ), $author_uri, $author_name ); ?></span>
				</div>
			</div><!-- .color-blog-dark-theme-info -->

			<div class="mt-upgrader-pro">
				<div class="mt-upgrade-title-wrap">
					<h3 class="mt-upgrader-title"><?php esc_html_e( 'Upgrade to Premium Version', 'color-blog-dark' ); ?></h3>
					<div class="mt-upgrader-text"><?php esc_html_e( 'Upgrade to pro version for additional features and better supports.', 'color-blog-dark' ); ?></div>
				</div>
				<div class="mt-upgrader-btn"> <a href="<?php echo esc_url( 'https://mysterythemes.com/wp-themes/color-blog-pro/' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Unlock Features With Pro', 'color-blog-dark' ); ?></a> </div>
			</div><!-- .mt-upgrader-pro -->

			<div class="mt-nav-tab-content-wrapper">
				<div class="nav-tab-wrapper">

					<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'color-blog-dark-settings' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'color-blog-dark-settings' ), 'themes.php' ) ) ); ?>">
						<span class="dashicons dashicons-admin-appearance"></span> <?php esc_html_e( 'Get Started', 'color-blog-dark' ); ?>
					</a>

					<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'demos' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'color-blog-dark-settings', 'tab' => 'demos' ), 'themes.php' ) ) ); ?>">
						<span class="dashicons dashicons-download"></span> <?php esc_html_e( 'Demos', 'color-blog-dark' ); ?>
					</a>
					
					<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'color-blog-dark-settings', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>">
						<span class="dashicons dashicons-dashboard"></span> <?php esc_html_e( 'Free Vs Pro', 'color-blog-dark' ); ?>
					</a>

					<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'color-blog-dark-settings', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>">
						<span class="dashicons dashicons-flag"></span> <?php esc_html_e( 'Changelog', 'color-blog-dark' ); ?>
					</a>
				</div><!-- .nav-tab-wrapper -->
	<?php
		}

		/**
		 * Get started screen page.
		 */
		public function get_started_screen() {
			$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

			// Look for a {$current_tab}_screen method.
			if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
				return $this->{ $current_tab . '_screen' }();
			}

			// Fallback to about screen.
			return $this->about_screen();
		}

		/**
		 * Output the about screen.
		 */
		public function about_screen() {

			$theme 			= wp_get_theme( get_template() );
			$theme_name 	= $theme->template;

			$doc_url 		= 'https://docs.mysterythemes.com/color-blog';
			$pro_theme_url 	= 'https://mysterythemes.com/wp-themes/color-blog-pro';
			$support_url	= 'https://wordpress.org/support/theme/'. $theme_name;
			$review_url		= 'https://wordpress.org/support/theme/'. $theme_name .'/reviews/?filter=5#new-post';
	?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>
					<div class="mt-nav-content-wrap">
						<div class="theme-features-wrap welcome-panel">
							<h4><?php esc_html_e( 'Here are some useful links for you to get started', 'color-blog-dark' ); ?></h4>
							<div class="under-the-hood two-col">
								<div class="col">
									<h3><?php esc_html_e( 'Next Steps', 'color-blog-dark' ); ?></h3>
									<ul>
										<li>
											<a href="<?php echo esc_url( admin_url( 'customize.php' ).'?autofocus[section]=title_tagline' ); ?>" target="_blank" class="welcome-icon dashicons-visibility"><?php esc_html_e( 'Set site logo', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( admin_url( 'customize.php' ).'?autofocus[section]=color_blog_dark_section_site' ); ?>" target="_blank" class="welcome-icon dashicons-admin-page"><?php esc_html_e( 'Setup site layout', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( admin_url( 'customize.php' ).'?autofocus[panel]=color_blog_dark_header_panel' ); ?>" target="_blank" class="welcome-icon dashicons-editor-kitchensink"><?php esc_html_e( 'Manage header section', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( admin_url( 'customize.php' ).'?autofocus[section]=color_blog_dark_section_post_settings' ); ?>" target="_blank" class="welcome-icon dashicons-text-page"><?php esc_html_e( 'Single page sidebar layouts', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( admin_url( 'customize.php' ).'?autofocus[section]=color_blog_dark_section_social_icons' ); ?>" target="_blank" class="welcome-icon dashicons-networking"><?php esc_html_e( 'Manage Social Icons', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( admin_url( 'customize.php' ).'?autofocus[section]=color_blog_dark_section_footer_widget_area' ); ?>" target="_blank" class="welcome-icon dashicons-archive"><?php esc_html_e( 'Manage footer widget area', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" target="_blank" class="welcome-icon welcome-menus"><?php esc_html_e( 'Manage menus', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>" target="_blank" class="welcome-icon welcome-widgets"><?php esc_html_e( 'Manage widgets', 'color-blog-dark' ); ?></a>
										</li>
									</ul>
								</div>

								<div class="col">
									<h3><?php esc_html_e( 'More Actions', 'color-blog-dark' ); ?></h3>
									<ul>
										<li>
											<a href="<?php echo esc_url( $doc_url ); ?>" target="_blank" class="welcome-icon dashicons-media-text"><?php esc_html_e( 'Documentation', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( $pro_theme_url ); ?>" target="_blank" class="welcome-icon dashicons-migrate"><?php esc_html_e( 'Premium version', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( $support_url ); ?>" target="_blank" class="welcome-icon dashicons-businesswoman"><?php esc_html_e( 'Need theme support?', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( $review_url ); ?>" target="_blank" class="welcome-icon dashicons-thumbs-up"><?php esc_html_e( 'Review theme', 'color-blog-dark' ); ?></a>
										</li>
										<li>
											<a href="<?php echo esc_url( 'https://wpallresources.com/' ); ?>" target="_blank" class="welcome-icon dashicons-admin-users"><?php esc_html_e( 'WP Tutorials', 'color-blog-dark' ); ?></a>
										</li>
									</ul>
								</div>
							</div>
						</div><!-- .theme-features-wrap -->

						<div class="return-to-dashboard color-blog-dark">
							<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
								<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
									<?php is_multisite() ? esc_html_e( 'Return to Updates', 'color-blog-dark' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'color-blog-dark' ); ?>
								</a> |
							<?php endif; ?>
							<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'color-blog-dark' ) : esc_html_e( 'Go to Dashboard', 'color-blog-dark' ); ?></a>
						</div><!-- .return-to-dashboard -->
					</div><!-- .mt-nav-content-wrap -->
				</div><!-- .mt-nav-tab-content-wrapper -->
			</div><!-- .about-wrap -->
	<?php
		}

		/**
		 * Output the more themes screen
		 */
		public function demos_screen() {
			$activated_theme 	= get_template();
			$demodata 			= get_transient( 'color_blog_dark_demo_packages' );
			
			if ( empty( $demodata ) || $demodata == false ) {
				$demodata = get_transient( 'mtdi_theme_packages' );
				if ( $demodata ) {
					set_transient( 'color_blog_dark_demo_packages', $demodata, WEEK_IN_SECONDS );
				}
			}

			$activated_demo_check 	= get_option( 'mtdi_activated_check' );
	?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>
					<div class="mt-nav-content-wrap">
						<div class="mt-theme-demos rendered">
							<?php $this->install_demo_import_plugin_popup(); ?>
							<div class="demos wp-clearfix">
							<?php
								if ( isset( $demodata ) && empty( $demodata ) ) {
							?>
									<span class="configure-msg"><?php esc_html_e( 'No demos are configured for this theme, please contact the theme author', 'color-blog-dark' ); ?></span>
							<?php
								} else {
							?>
									<div class="mt-demo-wrapper mtdi_gl js-ocdi-gl">
										<div class="themes wp-clearfix">
										<?php
											foreach ( $demodata as $value ) {
												$theme_name 		= $value['name'];
												$theme_slug 		= $value['theme_slug'];
												$preview_screenshot = $value['preview_screen'];
												$demourl 			= $value['preview_url'];
												if ( ( strpos( $activated_theme, 'pro' ) !== false && strpos( $theme_slug, 'pro' ) !== false ) || ( strpos( $activated_theme, 'pro' ) == false ) ) {
										?>
													<div class="mt-each-demo<?php if  ( strpos( $activated_theme, 'pro' ) == false && strpos( $theme_slug, 'pro' ) !== false ) { echo ' mt-demo-pro'; } ?> theme mtdi_gl-item js-ocdi-gl-item" data-categories="ltrdemo" data-name="<?php echo esc_attr ( $theme_slug ); ?>" style="display: block;">
														<div class="mtdi-preview-screenshot mtdi_gl-item-image-container">
															<a href="<?php echo esc_url ( $demourl ); ?>" target="_blank">
																<img class="mtdi_gl-item-image" src="<?php echo esc_url ( $preview_screenshot ); ?>" />
															</a>
														</div><!-- .mtdi-preview-screenshot -->
														<div class="theme-id-container">
															<h2 class="mtdi-theme-name theme-name" id="nokri-name"><?php echo esc_html ( $theme_name ); ?></h2>
															<div class="mtdi-theme-actions theme-actions">
																<?php
																	if ( $activated_demo_check != '' && $activated_demo_check == $theme_slug ) {
																?>
																		<a class="button disabled button-primary hide-if-no-js" href="javascript:void(0);" data-name="<?php echo esc_attr ( $theme_name ); ?>" data-slug="<?php echo esc_attr ( $theme_slug ); ?>" aria-label="<?php printf ( esc_html__( 'Imported %1$s', 'color-blog-dark' ), $theme_name ); ?>">
																			<?php esc_html_e( 'Imported', 'color-blog-dark' ); ?>
																		</a>
																<?php
																	} else {
																		if ( strpos( $activated_theme, 'pro' ) == false && strpos( $theme_slug, 'pro' ) !== false ) {
																			$s_slug = explode( "-pro", $theme_slug );
																			$purchaseurl = 'https://mysterythemes.com/wp-themes/'.$s_slug[0].'-pro';
																?>
																			<a class="button button-primary mtdi-purchasenow" href="<?php echo esc_url( $purchaseurl ); ?>" target="_blank" data-name="<?php echo esc_attr ( $theme_name ); ?>" data-slug="<?php echo esc_attr ( $theme_slug ); ?>" aria-label="<?php printf ( esc_html__( 'Purchase Now', 'color-blog-dark' ), $theme_name ); ?>">
																				<?php esc_html_e( 'Buy Now', 'color-blog-dark' ); ?>
																			</a>
																<?php
																		} else {
																			if ( is_plugin_active( 'mysterythemes-demo-importer/mysterythemes-demo-importer.php' ) ) {
																				$button_tooltip = esc_html__( 'Click to import demo', 'color-blog-dark' );
																			} else {
																				$button_tooltip = esc_html__( 'Demo importer plugin is not installed or activated', 'color-blog-dark' );
																			}
																?>
																			<a title="<?php echo esc_attr( $button_tooltip ); ?>" class="button button-primary hide-if-no-js mtdi-demo-import" href="javascript:void(0);" data-name="<?php echo esc_attr ( $theme_name ); ?>" data-slug="<?php echo esc_attr ( $theme_slug ); ?>" aria-label="<?php printf ( esc_attr__( 'Import %1$s', 'color-blog-dark' ), $theme_name ); ?>">
																				<?php esc_html_e( 'Import', 'color-blog-dark' ); ?>
																			</a>
																<?php
																		}
																	}
																?>
																	<a class="button preview install-demo-preview" target="_blank" href="<?php echo esc_url ( $demourl ); ?>">
																		<?php esc_html_e( 'View Demo', 'color-blog-dark' ); ?>
																	</a>
															</div><!-- .mtdi-theme-actions -->
														</div><!-- .theme-id-container -->
													</div><!-- .mtdi-each-demo -->
										<?php
												}
											}
										?>
										</div><!-- .themes -->
									</div><!-- .mtdi-demo-wrapper -->
							<?php
								}
							?>
							</div>
						</div><!-- .theme-browser -->
					</div><!-- .mt-nav-content-wrap -->
				</div><!-- .mt-nav-tab-content-wrapper -->
			</div><!-- .wrap.about-wrap -->
	<?php
		}
		
		/**
		 * Output the changelog screen.
		 */
		public function changelog_screen() {
			global $wp_filesystem;

		?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>
					<div class="mt-nav-content-wrap">
						<h4><?php esc_html_e( 'View changelog below:', 'color-blog-dark' ); ?></h4>

						<?php
							$changelog_file = apply_filters( 'color_blog_dark_changelog_file', get_template_directory() . '/readme.txt' );

							// Check if the changelog file exists and is readable.
							if ( $changelog_file && is_readable( $changelog_file ) ) {
								WP_Filesystem();
								$changelog 		= $wp_filesystem->get_contents( $changelog_file );
								$changelog_list = $this->parse_changelog( $changelog );
								echo wp_kses_post( $changelog_list );
							}
						?>
					</div><!-- .mt-nav-content-wrap -->
				</div><!-- .mt-nav-tab-content-wrapper -->
			</div>
		<?php
		}

		/**
		 * Parse changelog from readme file.
		 * @param  string $content
		 * @return string
		 */
		private function parse_changelog( $content ) {
			$matches   = null;
			$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
			$changelog = '';

			if ( preg_match( $regexp, $content, $matches ) ) {
				$changes 	= explode( '\r\n', trim( $matches[1] ) );
				$changelog .= '<pre class="changelog">';

				foreach ( $changes as $index => $line ) {
					$changelog .= wp_kses_post( preg_replace( '~(=\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
				}

				$changelog .= '</pre>';
			}

			return wp_kses_post( $changelog );
		}

		/**
		 * Output the free vs pro screen.
		 */
		public function free_vs_pro_screen() {
		?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>
					<div class="mt-nav-content-wrap">
						<h4><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'color-blog-dark' ); ?></h4>
						<table>
							<thead>
								<tr>
									<th class="table-feature-title"><h3><?php esc_html_e( 'Features', 'color-blog-dark' ); ?></h3></th>
									<th><h3><?php esc_html_e( 'Color Blog Dark', 'color-blog-dark' ); ?></h3></th>
									<th><h3><?php esc_html_e( 'Color Blog Pro', 'color-blog-dark' ); ?></h3></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><h3><?php esc_html_e( 'Price', 'color-blog-dark' ); ?></h3></td>
									<td><?php esc_html_e( 'Free', 'color-blog-dark' ); ?></td>
									<td><?php esc_html_e( '$59.99', 'color-blog-dark' ); ?></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'Import Demo Data', 'color-blog-dark' ); ?></h3></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'Pre Loaders Layouts', 'color-blog-dark' ); ?></h3></td>
									<td><span class="dashicons mt-dashicons-no"></span></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'Header Layouts', 'color-blog-dark' ); ?></h3></td>
									<td><?php esc_html_e( '1', 'color-blog-dark' ); ?></td>
									<td><?php esc_html_e( '4', 'color-blog-dark' ); ?></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'Multiple Layouts', 'color-blog-dark' ); ?></h3></td>
									<td><span class="dashicons mt-dashicons-no"></span></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'Google Fonts', 'color-blog-dark' ); ?></h3></td>
									<td><?php esc_html_e( '2', 'color-blog-dark' );?></td>
									<td><?php esc_html_e( '600+', 'color-blog-dark' ); ?></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'WordPress Page Builder Compatible', 'color-blog-dark' ); ?></h3></td>
									<td><span class="dashicons mt-dashicons-no"></span></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'Custom 404 Page', 'color-blog-dark' ); ?></h3></td>
									<td><span class="dashicons mt-dashicons-no"></span></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'Typography Options', 'color-blog-dark' ); ?></h3></td>
									<td><span class="dashicons mt-dashicons-no"></span></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'Footer Layout Options', 'color-blog-dark' ); ?></h3></td>
									<td><span class="dashicons mt-dashicons-no"></span></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'WooCommerce Plugin Compatible', 'color-blog-dark' ); ?></h3></td>
									<td><span class="dashicons mt-dashicons-no"></span></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
								</tr>
								<tr>
									<td><h3><?php esc_html_e( 'GDPR Compatible', 'color-blog-dark' ); ?></h3></td>
									<td><span class="dashicons mt-dashicons-no"></span></td>
									<td><span class="dashicons mt-dashicons-yes"></span></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td class="btn-wrapper">
									<a href="<?php echo esc_url( apply_filters( 'color-blog-dark_theme_url', 'https://mysterythemes.com/wp-themes/color-blog-pro/' ) ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Buy Pro', 'color-blog-dark' ); ?></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- .mt-nav-content-wrap -->
				</div><!-- .mt-nav-tab-content-wrapper -->
			</div><!-- .about-wrap -->
	<?php
		}

		/**
		 * Set the required option value as needed for theme review notice.
		 */
		public function color_blog_dark_theme_rating_notice() {

			// Set the installed time in `color_blog_dark_theme_installed_time` option table.
			$option = get_option( 'color_blog_dark_theme_installed_time' );

			if ( ! $option ) {
				update_option( 'color_blog_dark_theme_installed_time', time() );
			}

			add_action( 'admin_notices', array( $this, 'color_blog_dark_theme_review_notice' ), 0 );
			add_action( 'admin_init', array( $this, 'color_blog_dark_ignore_theme_review_notice' ), 0 );
			add_action( 'admin_init', array( $this, 'color_blog_dark_ignore_theme_review_notice_partially' ), 0 );

		}

		/**
		 * Display the theme review notice.
		 */
		public function color_blog_dark_theme_review_notice() {

			global $current_user;
			$user_id                  = $current_user->ID;
			$ignored_notice           = get_user_meta( $user_id, 'color_blog_dark_ignore_theme_review_notice', true );
			$ignored_notice_partially = get_user_meta( $user_id, 'mt_color_blog_dark_ignore_theme_review_notice_partially', true );

			/**
			 * Return from notice display if:
			 *
			 * 1. The theme installed is less than 15 days ago.
			 * 2. If the user has ignored the message partially for 15 days.
			 * 3. Dismiss always if clicked on 'I Already Did' button.
			 */
			if ( ( get_option( 'color_blog_dark_theme_installed_time' ) > strtotime( '- 15 days' ) ) || ( $ignored_notice_partially > time() ) || ( $ignored_notice ) ) {
				return;
			}
	?>
			<div class="notice updated theme-review-notice">
				<p>
					<?php
						printf( esc_html__(
								'Howdy, %1$s! It seems that you have been using this theme for more than 15 days. We hope you are happy with everything that the theme has to offer. If you can spare a minute, please help us by leaving a 5-star review on WordPress.org.  By spreading the love, we can continue to develop new amazing features in the future, for free!', 'color-blog-dark'
							),
							'<strong>' . esc_html( $current_user->display_name ) . '</strong>'
						);
					?>
				</p>

				<div class="links">
					<a href="https://wordpress.org/support/theme/color-blog-dark/reviews/?filter=5#new-post" class="btn button-primary" target="_blank">
						<span class="dashicons dashicons-thumbs-up"></span>
						<span><?php esc_html_e( 'Sure', 'color-blog-dark' ); ?></span>
					</a>

					<a href="?mt_color_blog_dark_ignore_theme_review_notice_partially=0" class="btn button-secondary">
						<span class="dashicons dashicons-calendar"></span>
						<span><?php esc_html_e( 'Maybe later', 'color-blog-dark' ); ?></span>
					</a>

					<a href="?mt_color_blog_dark_ignore_theme_review_notice=0" class="btn button-secondary">
						<span class="dashicons dashicons-smiley"></span>
						<span><?php esc_html_e( 'I already did', 'color-blog-dark' ); ?></span>
					</a>

					<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/color-blog-dark/' ); ?>" class="btn button-secondary" target="_blank">
						<span class="dashicons dashicons-edit"></span>
						<span><?php esc_html_e( 'Got theme support question?', 'color-blog-dark' ); ?></span>
					</a>
				</div>

				<a class="notice-dismiss" href="?mt_color_blog_dark_ignore_theme_review_notice_partially=0"></a>
			</div>

	<?php
		}

		/**
		 * Function to remove the theme review notice permanently as requested by the user.
		 */
		public function color_blog_dark_ignore_theme_review_notice() {

			global $current_user;
			$user_id = $current_user->ID;

			/* If user clicks to ignore the notice, add that to their user meta */
			if ( isset( $_GET['mt_color_blog_dark_ignore_theme_review_notice'] ) && '0' == $_GET['mt_color_blog_dark_ignore_theme_review_notice'] ) {
				add_user_meta( $user_id, 'color_blog_dark_ignore_theme_review_notice', 'true', true );
			}

		}

		/**
		 * Function to remove the theme review notice partially as requested by the user.
		 */
		public function color_blog_dark_ignore_theme_review_notice_partially() {

			global $current_user;
			$user_id = $current_user->ID;

			/* If user clicks to ignore the notice, add that to their user meta */
			if ( isset( $_GET['mt_color_blog_dark_ignore_theme_review_notice_partially'] ) && '0' == $_GET['mt_color_blog_dark_ignore_theme_review_notice_partially'] ) {
				update_user_meta( $user_id, 'mt_color_blog_dark_ignore_theme_review_notice_partially', strtotime( '+ 7 days' ) );
			}

		}

		/**
		 * Remove the data set after the theme has been switched to other theme.
		 */
		public function color_blog_dark_theme_rating_notice_data_remove() {

			global $current_user;
			$user_id                  = $current_user->ID;
			$theme_installed_time     = get_option( 'color_blog_dark_theme_installed_time' );
			$ignored_notice           = get_user_meta( $user_id, 'color_blog_dark_ignore_theme_review_notice', true );
			$ignored_notice_partially = get_user_meta( $user_id, 'mt_color_blog_dark_ignore_theme_review_notice_partially', true );

			// Delete options data.
			if ( $theme_installed_time ) {
				delete_option( 'color_blog_dark_theme_installed_time' );
			}

			// Delete permanent notice remove data.
			if ( $ignored_notice ) {
				delete_user_meta( $user_id, 'color_blog_dark_ignore_theme_review_notice' );
			}

			// Delete partial notice remove data.
			if ( $ignored_notice_partially ) {
				delete_user_meta( $user_id, 'mt_color_blog_dark_ignore_theme_review_notice_partially' );
			}

		}

		/**
	     * Display custom text on theme settings page
	     *
	     * @param string $text
	     */
	    public function color_blog_dark_admin_footer_text( $text ) {
	        $screen = get_current_screen();

	        if ( 'appearance_page_color-blog-dark-settings' == $screen->id ) {

	        	$theme 		= wp_get_theme( get_template() );
				$theme_name = $theme->get( 'Name' );

	            $text = sprintf( __( 'If you like <strong>%1$s</strong> please leave us a %2$s rating. A huge thank you from <strong>Mystery Themes</strong> in advance &#128515!', 'color-blog-dark' ), esc_html( $theme_name ), '<a href="https://wordpress.org/support/theme/color-blog-dark/reviews/?filter=5#new-post" class="theme-rating" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a>' );

	        }
	        return $text;
		}
		
		/**
		 * Popup alert for mystery themes demo importer plugin install.
		 *
		 * @since 1.0.7
		 */
		public function install_demo_import_plugin_popup() {
			$demo_importer_plugin = WP_PLUGIN_DIR . '/mysterythemes-demo-importer/mysterythemes-demo-importer.php';
		?>
				<div id="mt-demo-import-plugin-popup">
					<div class="mt-popup-inner-wrap">
						<?php
							if ( is_plugin_active( 'mysterythemes-demo-importer/mysterythemes-demo-importer.php' ) ) {
								echo '<span class="mt-plugin-message">'.esc_html__( 'You can import available demos now!', 'color-blog-dark' ).'</span>';
							} else {
								if ( ! file_exists( $demo_importer_plugin ) ) {
						?>
									<span class="mt-plugin-message"><?php esc_html_e( 'Mystery Themes Demo Importer Plugin is not installed!', 'color-blog-dark' ); ?></span>
									<a href="javascript:void(0)" class="mt-install-demo-import-plugin" data-process="<?php esc_attr_e( 'Installing & Activating', 'color-blog-dark' ); ?>" data-done="<?php esc_attr_e( 'Installed & Activated', 'color-blog-dark' ); ?>">
										<?php esc_html_e( 'Install and Activate', 'color-blog-dark' ); ?>
									</a>
						<?php
								} else {
						?>
									<span class="mt-plugin-message"><?php esc_html_e( 'Mystery Themes Demo Importer Plugin is installed but not activated!', 'color-blog-dark' ); ?></span>
									<a href="javascript:void(0)" class="mt-activate-demo-import-plugin" data-process="<?php esc_attr_e( 'Activating', 'color-blog-dark' ); ?>" data-done="<?php esc_attr_e( 'Activated', 'color-blog-dark' ); ?>">
										<?php esc_html_e( 'Activate Now', 'color-blog-dark' ); ?>
									</a>
						<?php
								}
							}
						?>
					</div><!-- .mt-popup-inner-wrap -->
				</div><!-- .mt-demo-import-plugin-popup -->
			<?php
		}

		/**
		 * Activate Demo Importer Plugins Ajax Method
		 *
		 * @since 1.0.7
		 */
		public function activate_demo_importer_plugin() {
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'color_blog_dark_admin_plugin_install_nonce' ) ) {
				die( 'This action was stopped for security purposes.' );
			}

			$result = activate_plugin( '/mysterythemes-demo-importer/mysterythemes-demo-importer.php' );
			if ( is_wp_error( $result ) ) {
				// Process Error
				wp_send_json_error(
					array(
						'success' => false,
						'message' => $result->get_error_message(),
					)
				);
			} else {
				wp_send_json_success(
					array(
						'success' => true,
						'message' => __( 'Plugin Successfully Activated.', 'color-blog-dark' ),
					)
				);
			}
		}

		/**
		 * Activate Demo Importer Plugins Ajax Method
		 *
		 * @since 1.0.7
		 */
		function install_demo_importer_plugin() {

			if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'color_blog_dark_admin_plugin_install_nonce' ) ) {
				die( 'This action was stopped for security purposes.' );
			}

			if ( ! current_user_can( 'install_plugins' ) ) {
				$status['message'] = __( 'Sorry, you are not allowed to install plugins on this site.', 'color-blog-dark' );
				wp_send_json_error( $status );
			}

			include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

			$api = plugins_api(
				'plugin_information',
				array(
					'slug'   => esc_html( 'mysterythemes-demo-importer' ),
					'fields' => array(
						'sections' => false,
					),
				)
			);
			if ( is_wp_error( $api ) ) {
				$status['message'] = $api->get_error_message();
				wp_send_json_error( $status );
			}

			$status['pluginName'] 	= $api->name;
			$skin     				= new WP_Ajax_Upgrader_Skin();
			$upgrader 				= new Plugin_Upgrader( $skin );
			$result   				= $upgrader->install( $api->download_link );

			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$status['debug'] = $skin->get_upgrade_messages();
			}

			if ( is_wp_error( $result ) ) {
				$status['errorCode']    = $result->get_error_code();
				$status['message'] 		= $result->get_error_message();
				wp_send_json_error( $status );
			} elseif ( is_wp_error( $skin->result ) ) {
				$status['errorCode']    = $skin->result->get_error_code();
				$status['message'] 		= $skin->result->get_error_message();
				wp_send_json_error( $status );
			} elseif ( $skin->get_errors()->get_error_code() ) {
				$status['message'] 		= $skin->get_error_messages();
				wp_send_json_error( $status );
			} elseif ( is_null( $result ) ) {
				global $wp_filesystem;

				$status['errorCode']    = 'unable_to_connect_to_filesystem';
				$status['message'] 		= __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'color-blog-dark' );

				// Pass through the error from WP_Filesystem if one was raised.
				if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
					$status['message'] = esc_html( $wp_filesystem->errors->get_error_message() );
				}

				wp_send_json_error( $status );
			}

			if ( current_user_can( 'activate_plugin' ) ) {
				$result = activate_plugin( '/mysterythemes-demo-importer/mysterythemes-demo-importer.php' );
				if ( is_wp_error( $result ) ) {
					$status['errorCode']    = $result->get_error_code();
					$status['message'] 		= $result->get_error_message();
					wp_send_json_error( $status );
				}
			}
			$status['message'] = esc_html__( 'Plugin installed successfully', 'color-blog-dark' );
			wp_send_json_success( $status );
		}
	}

endif;

return new color_blog_dark_Settings();