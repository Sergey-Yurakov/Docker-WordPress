<?php
/**
 * Search Form
 *
 * @package faith based blog
 */

?>
<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for='s'>
        <span class="screen-reader-text"><?php esc_html_e( 'Search Here...', 'pliska' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search Here...', 'pliska' ); ?>" value="<?php echo esc_attr(the_search_query()); ?>" name="s">
    </label>
	<button type="submit" aria-label="<?php _e('search', 'pliska')?>">
        <i class="search-icon">
            <?php echo wp_kses( pliska_get_svg('search') , pliska_get_kses_extended_ruleset() ); ?>
        </i>
    </button>
</form>