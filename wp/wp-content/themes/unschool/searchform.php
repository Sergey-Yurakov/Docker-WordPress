<?php
/**
 * @package unschool
 */
?>
<div class="container">
	<div class="row">
		<form role="search" method="get" class="form-inline"  action="<?php echo esc_url( home_url( '/','unschool' ) ); ?>">
			<div class="form-group">
				<input type="search" class="form-control" placeholder="<?php echo esc_attr_x('Search here...', 'placeholder', 'unschool' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
			</div><!--form-group-->
			<input type="submit" class="btn btn-default" value="<?php echo esc_attr_x('Search', 'submit button','unschool' ); ?>">
		</form>
	</div><!--row-->
</div><!--container-->