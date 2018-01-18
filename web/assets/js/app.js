$("#competences *[role=navigation] li").hover(function(){
	var target = $(this).children('a').attr('target');
	$(target).toggleClass("active");
});