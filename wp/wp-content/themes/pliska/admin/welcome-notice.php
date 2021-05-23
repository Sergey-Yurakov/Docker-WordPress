<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class pliska_notice_welcome extends pliska_notice {

	public function __construct() {
		
		add_action( 'wp_loaded', array( $this, 'welcome_notice' ), 20 );
		add_action( 'wp_loaded', array( $this, 'hide_notices' ), 15 );

	}

	public function welcome_notice() {
		
		$this_notice_was_dismissed = $this->get_notice_status('welcome');
		
		if ( !$this_notice_was_dismissed ) {
			if ( isset($_GET['page']) && 'pliska-doc' == $_GET['page'] ) {
				return;
			}

			add_action( 'admin_notices', array( $this, 'welcome_notice_markup' ) ); // Display this notice.
		}
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice_markup() {
		
		$dismiss_url = wp_nonce_url(
			remove_query_arg( array( 'activated' ), add_query_arg( 'pliska-hide-notice', 'welcome' ) ),
			'pliska_hide_notices_nonce',
			'_pliska_notice_nonce'
		);

		$theme_data	 = wp_get_theme();

		?>
		<div id="message" class="notice notice-success nasiothemes-notice nasiothemes-welcome-notice">
			<a class="nasiothemes-message-close notice-dismiss" href="<?php echo esc_url( $dismiss_url ); ?>"></a>

			<div class="nasiothemes-message-content">
				<div class="nasiothemes-message-image">
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=pliska-doc' ) ); ?>"><img class="nasiothemes-screenshot" src="<?php echo esc_url( get_template_directory_uri() ); ?>/admin/img/theme-logo.jpg" alt="<?php esc_attr_e( 'Pliska', 'pliska' ); ?>" /></a>
				</div><!-- ws fix
				--><div class="nasiothemes-message-text">
					<h2 class="nasiothemes-message-heading"><?php echo sprintf(__('Thank you for choosing %1$s!', 'pliska' ), esc_html($theme_data->name)); ?></h2>
					<?php
					echo '<p>';
						/* translators: %1$s: theme name, %2$s link */
						printf( __( 'To take advantage of everything that this theme can offer, please take a look at the <a href="%2$s">Get Started with %1$s</a> page.', 'pliska' ), esc_html( $theme_data->Name ), esc_url( admin_url( 'themes.php?page=pliska-doc' ) ) );
					echo '</p>';

					echo '<p class="notice-buttons"><a href="'. esc_url( admin_url( 'themes.php?page=pliska-doc' ) ) .'" class="button button-primary">';
						/* translators: %s theme name */
						printf( esc_html__( 'Get started with %s', 'pliska' ), esc_html( $theme_data->Name ) );
					echo '</a>';
					echo ' <a href="'. esc_url( 'https://www.youtube.com/watch?v=UeLXh8vk_nc' ) .'" target="_blank" rel="noopener" class="button button-primary nasiothemes-button"><span class="dashicons dashicons-youtube"></span> ';
						/* translators: %s theme name */
						printf( esc_html__( '%s Video Guide', 'pliska' ), esc_html( $theme_data->Name ) );
					echo '</a></p>';
					?>
				</div><!-- .nasiothemes-message-text -->
			</div><!-- .nasiothemes-message-content -->
		</div><!-- #message -->
		<?php
	}

}

new pliska_notice_welcome();