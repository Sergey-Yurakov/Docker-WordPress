(function($) {

  // Toggle Tabs
  $('.spwp-button-group a').click(function() {
    $('.spwp-button-group a.current').removeClass('current');
    $(this).addClass('current');
    let tab = $(this).attr('tab');
    let tabVal = parseInt(tab.replace('tab-', ''));
    $('.spwp-tab-container .tab-item.current').removeClass('current');
    $('.spwp-tab-container .' + tab).addClass('current');
    $('#spwp-type').val(tabVal);
  });

})(jQuery);



