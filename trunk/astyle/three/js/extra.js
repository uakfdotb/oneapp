function enableClickableAlerts(){
	 $(".msgOK").click(function(){
		$(this).fadeOut('slow');
	 });
	 $(".msgInfo").click(function(){
		$(this).fadeOut('slow');
	 });
	 $(".msgWarn").click(function(){
		$(this).fadeOut('slow');
	 });
	 $(".msgError").click(function(){
		$(this).fadeOut('slow');
	 });
}

function fadeMyDiv() {
   	$(".msg").fadeOut('slow');
}

function enableHoverMovement(){
	timer1 = setTimeout(function(){
			$(".msgOk").fadeOut('slow');
		},15000);
	timer2 = setTimeout(function(){
			$(".msgError").fadeOut('slow');
		},15000);
	timer3 = setTimeout(function(){
		$(".msgInfo").fadeOut('slow');
		},15000);
	timer4 = setTimeout(function(){
		$(".msgWarn").fadeOut('slow');
		},15000);	
		
	$(".msgOk").mouseenter(function(){
		$(this).css("z-index",10);
		clearTimeout(timer1);
	});
	$(".msgError").mouseenter(function(){
		$(this).css("z-index",10);
		clearTimeout(timer2);
	});
	$(".msgInfo").mouseenter(function(){
		$(this).css("z-index",10);
		clearTimeout(timer3);
	});
	$(".msgWarn").mouseenter(function(){
		$(this).css("z-index",10);
		clearTimeout(timer4);
	});
	$(".msgOk").mouseleave(function(){
		$(this).css("z-index",5);
		timer1 = setTimeout(function(){
			$(".msgOk").fadeOut('slow');
		},5000);
	});
	$(".msgError").mouseleave(function(){
		$(this).css("z-index",4);
		timer2 = setTimeout(function(){
			$(".msgError").fadeOut('slow');
		},5000);
	});
	$(".msgInfo").mouseleave(function(){
		$(this).css("z-index",2);
		timer3 = setTimeout(function(){
			$(".msgInfo").fadeOut('slow');
		},5000);
	});
	$(".msgWarn").mouseleave(function(){
		$(this).css("z-index",3);
		timer4 = setTimeout(function(){
			$(".msgWarn").fadeOut('slow');
		},5000);
	});
}
