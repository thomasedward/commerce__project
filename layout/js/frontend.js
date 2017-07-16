$(function () {
    'use strict';

    //switch between login /signup
     $('.login-page h1 span ').click(function(){
         
         $(this).addClass('selected').siblings().removeClass('selected');
         $('.login-page form').hide();
         $('.' + $(this).data('class')).fadeIn(100);
     });

    // trigger the select boxit
    $("select").selectBoxIt({
        autoWidth:false
    }); 
    //hide placeholder on form foucs

    $('[placeholder]').focus(function () {

   $(this).attr('data-text', $(this).attr('placeholder'));
  
   $(this).attr('placeholder', '');
   
 }).blur(function(){
     $(this).attr('placeholder',$(this).attr('data-text'));

 });
    

//confirmation message on button

$('.confirm').click(function(){

return confirm('are you sure ?');
});
/*
//live view  create ads v1
$('.live-name').keyup(function(){
$('.live-preview .caption h3').text($(this).val());
});
$('.live-desc').keyup(function(){
$('.live-preview .caption p').text($(this).val());
});
$('.live-price').keyup(function(){
$('.live-preview span').text(  '$' + $(this).val());
});
*/

//view create ads v2
$('.live').keyup(function(){
$($(this).data('class')).text( $(this).val());
});



});