// JavaScript Document
jQuery.fn.widthSiteChange = function(){ 
	var wBrowser = 1200;
	var paddingLeft;
	/*
	if($(window).width()>1250) {
		wBrowser = 1250;
	} else if($(window).width()>1014) {
		$("#manga_title").show();
		wBrowser = $(window).width();
	} else {
		$("#manga_title").hide();
		wBrowser = 1014-230;
	}	
	*/
	paddingLeft = parseInt(($(window).width()-wBrowser)/2);

	$("#manga_body, #manga_bar").css('width', wBrowser);
	$("#manga_body").css('height', ($(window).height()-4));
	$("#manga_background").css('padding-left', paddingLeft);
	$("#manga_background").css('width', ($(window).width() - paddingLeft)-1);
	
} 
