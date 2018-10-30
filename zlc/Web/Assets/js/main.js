var mySwiper = new Swiper('.swiper-container', {
  pagination: '.swiper-pagination',
  paginationClickable: true,
  autoplay: 5000,
  speed: 1000,
})
$("#nav-switch-btn").click(function(){
  var $navList = $("#js-nav-list")
  $navList.toggleClass("hidden-xs");
})


$("#js-nav-list").find("li:has(.child)").hover(function(){
	$(this).find(".child").stop(true,true).slideDown()
},function(){$(this).find(".child").stop(true,true).slideUp();})

$("#js-go-search").click(function(){
  var form = $(this).parents("form");
  if($.trim(form.find("input[name='keyword']").val()) == '') return;
  form.submit();
})