<?php

/**
 * Define Constants
 */
if ( ! defined( 'PLISKA_PAGE_BASENAME' ) ) {
	define( 'PLISKA_PAGE_BASENAME', 'pliska-doc' );
}
if ( ! defined( 'PLISKA_THEME_DETAILS' ) ) {
	define( 'PLISKA_THEME_DETAILS', 'https://nasiothemes.com/themes/pliska/' );
}
if ( ! defined( 'PLISKA_THEME_DEMO' ) ) {
	define( 'PLISKA_THEME_DEMO', 'https://try-pliska.nasiothemes.com/' );
}
if ( ! defined( 'PLISKA_THEME_VIDEO_GUIDE' ) ) {
	define( 'PLISKA_THEME_VIDEO_GUIDE', 'https://www.youtube.com/watch?v=UeLXh8vk_nc' );
}
if ( ! defined( 'PLISKA_THEME_VIDEO_COMPARISON' ) ) {
	define( 'PLISKA_THEME_VIDEO_COMPARISON', 'https://nasiothemes.com/themes/pliska/' );
}
if ( ! defined( 'PLISKA_THEME_DOCUMENTATION_URL' ) ) {
	define( 'PLISKA_THEME_DOCUMENTATION_URL', 'https://nasiothemes.com/2021/03/29/pliska-theme-documentation/' );
}
if ( ! defined( 'PLISKA_THEME_SUPPORT_FORUM_URL' ) ) {
	define( 'PLISKA_THEME_SUPPORT_FORUM_URL', 'https://wordpress.org/support/theme/pliska/' );
}
if ( ! defined( 'PLISKA_THEME_REVIEW_URL' ) ) {
	define( 'PLISKA_THEME_REVIEW_URL', 'https://wordpress.org/support/theme/pliska/reviews/#new-post' );
}
if ( ! defined( 'PLISKA_THEME_UPGRADE_URL' ) ) {
	define( 'PLISKA_THEME_UPGRADE_URL', 'https://nasiothemes.com/themes/pliska/' );
}
if ( ! defined( 'PLISKA_THEME_DEMO_IMPORT_URL' ) ) {
	define( 'PLISKA_THEME_DEMO_IMPORT_URL', false );
}
/**
 * Specify Hooks/Filters
 */
add_action( 'admin_menu', 'pliska_add_menu' );
/**
 * The admin menu pages
 */
function pliska_add_menu() {
	add_theme_page(
		__( 'Pliska Theme', 'pliska' ),
		__( 'Pliska Theme', 'pliska' ),
		'edit_theme_options',
		PLISKA_PAGE_BASENAME,
		'pliska_settings_page_doc'
	);
}

/*
 * Theme Documentation Page HTML
 *
 * @return echoes output
 */
function pliska_settings_page_doc() {
	// get the settings sections array
	$theme_data = wp_get_theme();
	?>
	
	<div class="nasiothemes-wrapper">
		<div class="nasiothemes-header">
			<div id="nasiothemes-theme-info">
				<div class="nasiothemes-message-image">
					<img class="nasiothemes-screenshot" src="
					<?php echo esc_url( get_template_directory_uri() ); ?>/admin/img/theme-logo.jpg" alt="
					<?php esc_attr_e( 'Pliska Theme Screenshot', 'pliska' ); ?>" />
				</div><!-- ws fix
				--><p>
						<?php
						echo sprintf(
								/* translators: Theme name and version */
							__( '<span class="theme-name">%1$s Theme</span> <span class="theme-version">(version %2$s)</span>', 'pliska' ),
							esc_html( $theme_data->name ),
							esc_html( $theme_data->version )
						);
						?>
					</p>
					<p class="theme-buttons">
						<a class="button button-primary" href="<?php echo esc_url( PLISKA_THEME_DETAILS ); ?>" rel="noopener" target="_blank">
							<?php esc_html_e( 'Theme Details', 'pliska' ); ?>
						</a>
						<a class="button button-primary" href="<?php echo esc_url( PLISKA_THEME_DEMO ); ?>" rel="noopener" target="_blank">
							<?php esc_html_e( 'Theme Demo', 'pliska' ); ?>
						</a>
						<a class="button button-primary nasiothemes-button nasiothemes-button-youtube" href="
							<?php echo esc_url( PLISKA_THEME_VIDEO_GUIDE ); ?>" rel="noopener" target="_blank"><span class="dashicons dashicons-youtube"></span> 
							<?php esc_html_e( 'Theme Video Tutorial', 'pliska' ); ?>
						</a>
					</p>
			</div><!-- .nasiothemes-header -->
		
		<div class="nasiothemes-documentation">

			<ul class="nasiothemes-doc-columns clearfix">
				<li class="nasiothemes-doc-column nasiothemes-doc-column-1">
					<div class="nasiothemes-doc-column-wrapper">
						<div class="doc-section">
							<h3 class="column-title"><span class="nasiothemes-icon dashicons dashicons-editor-help"></span><span class="nasiothemes-title-text">
							<?php
							esc_html_e( 'Documentation and Support', 'pliska' );
							?>
							</span></h3>
							<div class="nasiothemes-doc-column-text-wrapper">
								<p>
								<?php echo sprintf(
									/* translators: Theme name and link to WordPress.org Support forum for the theme */
									__( 'Please check the theme documentation before using the theme. Support for %1$s Theme is provided in the official WordPress.org community support forum. ', 'pliska' ),
									esc_html( $theme_data->name )
								);?>
								</p>
								<p class="doc-buttons">
									<a class="button button-primary" href="<?php echo esc_url( PLISKA_THEME_DOCUMENTATION_URL );?>" rel="noopener" target="_blank">
									<?php esc_html_e( 'View Pliska Documentation', 'pliska' ); ?>
									</a>
								<?php if ( PLISKA_THEME_SUPPORT_FORUM_URL ) { ?>
									 <a class="button button-secondary" href="<?php echo esc_url( PLISKA_THEME_SUPPORT_FORUM_URL ); ?>" rel="noopener" target="_blank">
									<?php esc_html_e( 'Go to Pliska Support Forum', 'pliska' );
									?>
									</a>
									<?php
								} ?>
								</p>
							</div><!-- .nasiothemes-doc-column-text-wrapper-->
						</div><!-- .doc-section -->
						<div class="doc-section">
							<h3 class="column-title"><span class="nasiothemes-icon dashicons dashicons-editor-help"></span><span class="nasiothemes-title-text">
								<?php esc_html_e( 'FAQ', 'pliska' ); ?></span>
							</h3>
							<div class="nasiothemes-doc-column-text-wrapper">
								<strong><?php esc_html_e( '1. Where are the theme options?', 'pliska' ); ?></strong>
								<p><i><?php esc_html_e( 'Please navigate to Appearance => Customize and customize the theme to taste.', 'pliska' ); ?></i></p>
								<br>
								<strong><?php esc_html_e( '2. Can I make a website that looks exactly like the theme demo?', 'pliska' ); ?></strong>
								<p><i><?php esc_html_e( 'That is easy, all you need to do is upgrade to Pliska PRO and run the one-click demo import. Please check the video tutorial for more info.', 'pliska' ); ?></i></p>
								<br>
								<strong><?php esc_html_e( '3. I have already purchased the premium version. How do I install and activate it?', 'pliska' ); ?></strong>
								<p><i><?php esc_html_e( 'To install the Pliska Pro theme, go to Appearance => Themes => Add new and upload the zip file that you have received upon theme purchase. To activate it, hover over Pliska Pro theme from the theme list on the same page and click "Activate". Finally, you will be asked to enter a license key that you have received by email.', 'pliska' ); ?></i></p>
								<br>
								<strong><?php esc_html_e( '4. Where are the custom block patterns?', 'pliska' ); ?></strong>
								<p><i><?php esc_html_e( 'Go to a post or page you want to edit, click "Edit" from the top admin bar. From the WordPress Gutenberg editor, select the plus icon in the top left corner. From there, pick the "Patterns" tab and select "Pliska" from the pattern dropdown.', 'pliska' ); ?></i></p>
							</div><!-- .nasiothemes-doc-column-text-wrapper-->
						</div><!-- .doc-section -->
						<div class="doc-section">
							<h3 class="column-title"><span class="nasiothemes-icon dashicons dashicons-youtube"></span><span class="nasiothemes-title-text">
							    <?php esc_html_e( 'Theme Video Tutorial', 'pliska' ); ?></span>
                            </h3>
							<div class="nasiothemes-doc-column-text-wrapper">
								<p><strong><?php esc_html_e('Click the image below to open the video guide in a new browser tab.','pliska'); ?></strong></p>
								<p><a href="<?php echo esc_url(PLISKA_THEME_VIDEO_GUIDE); ?>" rel="noopener" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/admin/img/pliska-video-preview.jpg" class="video-preview" alt="<?php esc_attr_e('Pliska Theme Video Tutorial','pliska'); ?>" /></a></p>
							</div><!-- .nasiothemes-doc-column-text-wrapper-->

						</div><!-- .doc-section -->
						
                        <div class="doc-section">
							<h3 class="column-title"><span class="nasiothemes-icon dashicons dashicons-awards"></span><span class="nasiothemes-title-text">
							<?php esc_html_e( 'Leave a Review', 'pliska' );?>
							</span></h3>
							<div class="nasiothemes-doc-column-text-wrapper">
								<p><?php esc_html_e( 'If you enjoy using Pliska Theme, please leave a review for it on WordPress.org. It helps us continue providing updates and support for it.', 'pliska' );?></p>
								<p class="doc-buttons">
                                    <a class="button button-primary" href="<?php echo esc_url( PLISKA_THEME_REVIEW_URL );?>" rel="noopener" target="_blank">
                                        <?php esc_html_e( 'Write a Review for Pliska', 'pliska' );?>
                                    </a>
                                </p>
							</div><!-- .nasiothemes-doc-column-text-wrapper-->
						</div><!-- .doc-section -->
					</div><!-- .nasiothemes-doc-column-wrapper -->
				</li><!-- .nasiothemes-doc-column --><li class="nasiothemes-doc-column nasiothemes-doc-column-2">
				<div class="nasiothemes-doc-column-wrapper">
						<?php

						if ( PLISKA_THEME_UPGRADE_URL ) {
							?>
						<div class="doc-section">
							<h3 class="column-title"><span class="nasiothemes-icon dashicons dashicons-cart"></span><span class="nasiothemes-title-text">
							<?php esc_html_e( 'Upgrade to Pliska PRO', 'pliska' );
							?>
							</span>
                            </h3>
							<div class="nasiothemes-doc-column-text-wrapper">
								<p>
                                    <?php echo sprintf(
                                        /* translators: Theme name and link to WordPress.org Support forum for the theme */
                                        __( 'If you like the free version of %1$s Theme, you will love the PRO version.', 'pliska' ),
                                        esc_html( $theme_data->name )
                                    );
                                    ?>
								</p>
								<p>
								<?php esc_html_e( 'You will be able to create an even more unique website using the additional functionalities and customization options available in the pro version.', 'pliska' );
								?>
								<br>
								<p class="doc-buttons"><a class="button button-primary" href="
								<?php echo esc_url( PLISKA_THEME_UPGRADE_URL );
								?>
								" rel="noopener" target="_blank">
								<?php esc_html_e( 'Upgrade to Pliska PRO', 'pliska' );
								?>
								</a>
								<?php

								if ( PLISKA_THEME_VIDEO_COMPARISON ) {
									?>
									<a class="button button-primary nasiothemes-button nasiothemes-button-youtube" href="
									<?php echo esc_url( PLISKA_THEME_VIDEO_COMPARISON );
									?>
									" rel="noopener" target="_blank">
									<?php esc_html_e( 'View Full List of Features', 'pliska' );
									?>
									</a>
									<?php
								}

								?>
								</p>

								<table class="theme-comparison-table">
									<tr>
										<th class="table-feature-title">
											<?php esc_html_e( 'Feature', 'pliska' ); ?>
										</th>
										<th class="table-lite-value">
											<?php esc_html_e( 'Pliska', 'pliska' ); ?>
										</th>
										<th class="table-pro-value">
											<?php esc_html_e( 'Pliska PRO', 'pliska' ); ?>
										</th>
									</tr>
									<tr>
										<td><div class="nasio-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="nasio-tooltiptext">
											<?php esc_html_e( 'Import demo content with posts, pages and images for an easier start with the theme with a single click.', 'pliska' ); ?></span></div>
												<?php esc_html_e( 'One Click Demo Import', 'pliska' );?>
										</td>
										<td><span class="dashicons dashicons-minus"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
									</tr>
									<tr>
										<td><div class="nasio-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="nasio-tooltiptext">
											<?php esc_html_e( 'Add ready to use gutenberg block patterns with predefined content for an easier start with the theme.', 'pliska' ); ?></span></div>
											<?php esc_html_e( 'Block Patterns', 'pliska' ); ?>
										</td>
										<td>
											<span class="dashicons dashicons-yes-alt"></span>
											<?php esc_html_e( '5', 'pliska' ); ?>
										</td>
										<td>
											<span class="dashicons dashicons-yes-alt"></span>
											<?php esc_html_e( '12', 'pliska' ); ?>
										</td>
									</tr>
									<tr>
										<td>
											<div class="nasio-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="nasio-tooltiptext">
												<?php esc_html_e( 'Choose between 1000+ Google Fonts and change font size for the main elements on the website directly from the Customizer. No coding skills needed!', 'pliska' ); ?></span>
											</div>
											<?php esc_html_e( 'Change Fonts', 'pliska' ); ?>
										</td>
										<td><span class="dashicons dashicons-yes-alt"></span>&nbsp;<strong><?php esc_html_e( '15 Google Fonts', 'pliska' ); ?></strong></td>
										<td><span class="dashicons dashicons-yes-alt"></span>&nbsp;<strong><?php esc_html_e( '1000+ Google Fonts', 'pliska' ); ?></strong></td>
									</tr>
									<tr>
										<td><div class="nasio-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="nasio-tooltiptext">
											<?php esc_html_e( 'Choose font sizes for the main elements on the website directly from the Customizer. No coding skills needed!', 'pliska' ); ?>
											</span></div>
											<?php esc_html_e( 'Change Font Sizes', 'pliska' ); ?>
										</td>
										<td><span class="dashicons dashicons-minus"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
									</tr>
									<tr>
										<td><div class="nasio-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="nasio-tooltiptext">
										<?php esc_html_e( 'Remove theme author credits and add your own text here. Customize the colors of the footer elements directly from the theme customizer. No coding skills needed!', 'pliska' );
										?>
										</span></div>
										<?php esc_html_e( 'Edit Footer Credits', 'pliska' );
										?>
										</td>
										<td><span class="dashicons dashicons-minus"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
									</tr>
									<tr>
										<td><div class="nasio-tooltip"><span class="dashicons dashicons-editor-help"></span><span class="nasio-tooltiptext">
                                            <?php esc_html_e( 'Enables site visitors to vote for posts.', 'pliska' );
                                            ?>
                                            </span></div>
                                            <?php esc_html_e( 'Post rating System', 'pliska' );
                                            ?>
										</td>
										<td><span class="dashicons dashicons-minus"></span></td>
										<td><span class="dashicons dashicons-yes-alt"></span></td>
									</tr>
									<tr>
										<td>
										<?php esc_html_e( 'Support', 'pliska' );
										?>
										</td>
										<td><div class="nasio-tooltip">
                                            <?php esc_html_e( 'Nonpriority', 'pliska' );
                                            ?>
                                            <span class="nasio-tooltiptext">
                                            <?php esc_html_e( 'Support is provided in the WordPress.org community forums.', 'pliska' );
                                            ?>
                                            </span></div>
                                        </td>
										<td><div class="nasio-tooltip"><strong>
                                            <?php esc_html_e( 'Priority Support', 'pliska' );
                                            ?>
                                            </strong><span class="nasio-tooltiptext">
                                            <?php esc_html_e( 'Quick and friendly support is available via email', 'pliska' );
                                            ?>
                                            </span></div>
                                        </td>
									</tr>
									<tr>
										<td colspan="3" style="text-align: center;"><a class="button button-primary" href="
										<?php echo esc_url( PLISKA_THEME_UPGRADE_URL );
										?>
											" rel="noopener" target="_blank">
											<?php esc_html_e( 'Upgrade to Pliska PRO', 'pliska' );
											?>
											</a>
										</td>
									</tr>
								</table>

							</div><!-- .nasiothemes-doc-column-text-wrapper-->
						</div><!-- .doc-section -->
							<?php
						}

						?>
					</div><!-- .nasiothemes-doc-column-wrapper -->
				</li><!-- .nasiothemes-doc-column -->
			</ul><!-- .nasiothemes-doc-columns -->

		</div><!-- .nasiothemes-documentation -->

	</div><!-- .nasiothemes-wrapper -->

	<?php
}
