console.log('JS has loaded');


$(document).ready(function(){
  $('.graphic').click(function(){
    console.log('click')
    if ($('.studentHero').is(':hidden')) {
      $('.studentHero').slideDown('slow');
    } else {
      $('.studentHero').slideUp('slow');
    }

    if ($('.studentPage').is(':hidden')) {
      $('.studentPage').slideDown('slow');
    } else {
      $('.studentPage').slideUp('slow');
    }
  });
});
