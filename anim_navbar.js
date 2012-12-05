$(document).ready(function(){
	var check=0;
	var i;
	for(i=0;i<20;i++){
		if($(".a"+i+"").attr("id")){
		check=$(".a"+i+"").attr("id").slice(1,2);
		}
	}
	
	var selected=check*($("#b0").outerWidth());
	var position;
		
	$("#anim").css({backgroundPosition:''+selected+'px 4px'});
		
	$("#b0,#b1,#b2,#b3,#b4,#b5).css({backgroundPosition:'0px 0px'}).mouseover(function(){
	position=$(this).attr("id").slice(1,2)*($("#b0").outerWidth())/*width of your list item*/;
	$("#anim").stop().animate({backgroundPosition:''+position+'px 4px'},{duration:300});
	});
	
	$("#b0,#b1,#b2,#b3,#b4,#b5).css({backgroundPosition:'0px 0px'}).mouseout(function(){
	$("#anim").stop().animate({backgroundPosition:''+selected+'px 4px'},{duration:300});
	});
});