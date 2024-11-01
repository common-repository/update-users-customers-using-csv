jQuery(document).ready(function(){
    jQuery('.div-up-scroll').css({
      'width': (jQuery('table.user-data').width() + 'px')
    });
    jQuery('#modal1').modal();  //intiating model for revoke access
    jQuery('.tabs').tabs();     //initiating tabs for auto and manual connect
    M.updateTextFields();
    jQuery('select').formSelect();
});
jQuery(function(){
  jQuery(".wrapper1").scroll(function(){
    jQuery(".wrapper2").scrollLeft(jQuery(".wrapper1").scrollLeft());
  });
  jQuery(".wrapper2").scroll(function(){
    jQuery(".wrapper1").scrollLeft(jQuery(".wrapper2").scrollLeft());
  });
});
