<?php 
/**
 * Template part for displaying Call to action Section
 *
 *@package Easy Business
 */
?>
    <?php 
        $call_to_action_title              = easy_business_get_option( 'call_to_action_title' );
        $call_to_action_button_label       = easy_business_get_option( 'call_to_action_button_label' );
        $call_to_action_button_url         = easy_business_get_option( 'call_to_action_button_url' );
    ?>

    <div class="overlay"></div>
    <div class="wrapper">
        <?php if ( !empty($call_to_action_title ) )  :?>
            <header class="entry-header">
                <h2 class="entry-title"><?php echo esc_html($call_to_action_title); ?></h2>
            </header><!-- .entry-header -->
        <?php endif;?>

        <?php if ( !empty($call_to_action_button_label ) )  :?>
            <div class="read-more">
                <a href="<?php echo esc_url($call_to_action_button_url); ?>" class="btn"><?php echo esc_html($call_to_action_button_label); ?></a>
            </div><!-- .read-more -->
        <?php endif;?>
    </div><!-- .wrapper -->

