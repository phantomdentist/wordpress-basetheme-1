jQuery(function($) {
	
	<!-- Add parent class to li's with a child ul with class of sub-menu-->  
	$(document).ready(function(){
		$("ul.sub-menu").parents("li").addClass('parent');//Parent class for submenu parents
	});
	
});
