<?php
$unschool_copyright = get_theme_mod('unschool_copyright');
$unschool_design    = get_theme_mod('unschool_design');
?>
<?php if ($unschool_copyright || $unschool_design) { ?>
    <div class="footer-bottom">

        <div class="container">

            <div class="row">
                <div class=" col-md-6 col-sm-12 col-xs-12">

                    <div class="copyright text-left">


                        <?php if (get_theme_mod('unschool_copyright')) { ?>
                            <?php echo esc_html($unschool_copyright); ?>
                        <?php } ?>         
                    </div><!--copyright-->

                </div>
                <div class=" col-md-6 col-sm-12 col-xs-12">

                    <div class="design text-right">

                        <?php if (get_theme_mod('unschool_design')) { ?>
                            <?php echo esc_html($unschool_design); ?>
                        <?php } ?>

                    </div><!--design-->

                </div><!--col-sm-6-->

                



            </div><!--row-->

        </div><!--container-->

    </div><!--footer-bottom-->
    <?php
}?>