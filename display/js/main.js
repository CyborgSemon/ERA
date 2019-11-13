console.log('JS has loaded');


$(".graphic").click(function(){
  console.log('click');
if( $(".studentHero").is( ":hidden" ) ){
  $(".studentHero").slideDown(800);
  $(".studentPage").slideUp(800);
} else {
  $(".studentHero").slideDown(800);
  $(".studentPage").slideUp(800);
}


});
