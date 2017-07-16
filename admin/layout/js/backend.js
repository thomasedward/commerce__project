$(function () {
    'use strict';


//HOme page latest
$('.toggle-info').click(function (){
$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
if($(this).hasClass('selected'))
{
    $(this).html('<i class="fa fa-minus fa-lg"></i>');
}
else
{
$(this).html('<i class="fa fa-plus fa-lg"></i>')
}
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
    

    //add asterisk on required field
  $('input').each(function () {
  if ($(this).attr('required') === 'required') {
      $(this).after('<span class="asterisk ">*</span>');
  }

});

//convert password to text filed

var passfield = $('.password');
$('.show-pass').hover(function (){
    passfield.attr('type','text');
},function(){

 passfield.attr('type','password');
});



/*
//to show button in categories manager


$('.category .cat').hover(function (){
    $( ' .hidden-btn').css('display','inline');
},function(){

  $('.hidden-btn').css('display','none');
});

*/

//confirmation message on button

$('.confirm').click(function(){

return confirm('are you sure ?');
});


//category show
$('.cat h3').click(function (){

$(this).next('.full-view').fadeToggle();
 
});

$('.option span').click(function(){

$(this).addClass('active').siblings('span').removeClass('active');

if($(this).data('view' ) === 'full')
{
    $('.cat .full-view').fadeIn(200);
}
else
{
    $('.cat .full-view').fadeOut(200);
}
});


 // show delete buttom on child cats  method one 
//class = child-n in <a> link sub category
// $('.child-cat li').hover(function (){

// $(".child-n").siblings().removeClass('show-delete');

// },function (){

// $(".child-n").siblings().addClass('show-delete');
// });

// show delete buttom on child cats  method two

// class = child-n in <li> 
$('.child-n').hover(function (){

$(this).find('.show-delete').fadeIn(400);

},function (){

$(this).find('.show-delete').fadeOut(400);
});

});