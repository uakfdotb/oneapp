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

function highlightDiv() { 
				$('.ctrlHolder > input[type=text]').addClass("textInput"); 
				$('.ctrlHolder > input[type=password]').addClass("textInput");
				$('.ctrlHolder > input[type=file]').addClass("fileUpload"); 				
				$('.ctrlHolder > select').addClass("selectInput"); 
				
				$('.ctrlHolder > input[type=text]').addClass("switchcolor"); 
				$('.ctrlHolder > input[type=password]').addClass("switchcolor");
				$('.ctrlHolder > input[type=file]').addClass("switchcolor"); 				
				$('.ctrlHolder > textarea').addClass("switchcolor");  				
				$('.ctrlHolder > select').addClass("switchcolor"); 
				$('.ctrlHolder > input[type=checkbox]').addClass("switchcolor"); 
				$('.ctrlHolder > radio').addClass("switchcolor"); 
				$('.changeBackground').addClass("need_switchcolor");
    $('.switchcolor').focus(function() {  
        var par = $(this).parent();
        par.css("background-color","#FFFCDF");
        par.find('.need_switchcolor').css("background-color","#FFFCDF");
    });  
    $('.switchcolor').blur(function() {  
        var par = $(this).parent();
        par.css("background-color","white");
        par.find('.need_switchcolor').css("background-color","white");
    }); 
}


function openclosetabs() {
		var $tab_title_input = $( "#tab_title"),
			$tab_content_input = $( "#tab_content" );
		var tab_counter = 2;

		// tabs init with a custom tab template and an "add" callback filling in the content
		var $tabs = $( "#tabs").tabs({
			tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close'>Remove Tab</span></li>",
			add: function( event, ui ) {
				var tab_content = $tab_content_input.val() || "Tab " + tab_counter + " content.";
				$( ui.panel ).append( "<p>" + tab_content + "</p>" );
			}
		});

		// modal dialog init: custom buttons and a "close" callback reseting the form inside
		var $dialog = $( "#dialog" ).dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				Add: function() {
					addTab();
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			open: function() {
				$tab_title_input.focus();
			},
			close: function() {
				$form[ 0 ].reset();
			}
		});

		// addTab form: calls addTab function on submit and closes the dialog
		var $form = $( "form", $dialog ).submit(function() {
			addTab();
			$dialog.dialog( "close" );
			return false;
		});
				
		// actual addTab function: adds new tab using the title input from the form above
		function addTab() {
			var tab_title = "Tab NEW";
			$tabs.tabs( "add", "#tabs-new" , tab_title );
			
		}
				
		// addTab button: just opens the dialog
		$( "#add_tab" )
			.button()
			.click(function() {
				$dialog.dialog( "open" );
			});

		// close icon: removing the tab on click
		// note: closable tabs gonna be an option in the future - see http://dev.jqueryui.com/ticket/3924
		$( "#tabs span.ui-icon-close" ).live( "click", function() {
			var index = $( "li", $tabs ).index( $( this ).parent() );
			$tabs.tabs( "remove", index );
		});
}
