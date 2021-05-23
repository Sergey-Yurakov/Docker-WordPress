( function($) {
	$('.toggle-mobile-menu').click(function(e) {
			e.preventDefault();  // don't grab focus
			$("#smobile-menu #primary-menu li a").first().focus();

		if($('body').hasClass('mobile-menu-active') ) {
			$( document ).on( 'keydown', function ( e ) {
				if ( e.keyCode === 27 ) { 
					$("#accessibility-close-mobile-menu").trigger("focusin");
				}
			});
			
			$('#smobile-menu .smenu-hide').on('keydown', function (e) {
				if((e.keyCode === 9 && e.shiftKey) || e.keyCode === 13) {
					   //shift tab or enter on "menu" close menu
					$('.toggle-mobile-menu').trigger("click");
					$( document ).off("keydown");
					setTimeout(function(){
						$('.toggle-mobile-menu').focus();
					}, 10);
					$('.toggle-mobile-menu').focus();
				}
			});
		}

	});
	$('.toggle-mobile-menu').keydown(function(event){ 
		var keyCode = (event.keyCode ? event.keyCode : event.which);   
		if (keyCode == 13) {
			$('.toggle-mobile-menu').trigger('click');
		}
	});


	$(document).ready(function(){

		$("#smobile-menu #primary-menu").append(
			'<li><a href="" id="accessibility-close-mobile-menu" style="padding:0;height:0;"></a></li>'
		);

		$("#accessibility-close-mobile-menu").focusin(function(e){
			$('.toggle-mobile-menu').click();
			$('#primary a').first().focus();
			$( document ).off("keydown");
		});

	});
	
	
})(jQuery);