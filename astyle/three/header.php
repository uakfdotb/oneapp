<!doctype html>
<html lang="cs">
    <head>
        <meta charset="utf-8">
        <title><?= $config['site_name'] ?> | A OneApp Product</title>
<?
if(isset($redirect)) {
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=' . $redirect . '">';	
}
?>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="Favyen Bastani & Vaibhav Gupta">
        <link rel="shortcut icon" href="<?= $stylePath ?>/favicon.ico">
        <link rel="apple-touch-icon" href="<?= $stylePath ?>/apple-touch-icon.png">
        <link rel="stylesheet" href="<?= $stylePath ?>/css/main.css?v=1.0" media="screen,projection">
        <script type="text/javascript" src="<?= $stylePath ?>/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="<?= $stylePath ?>/js/jquery-ui-1.8.22.custom.min.js"></script>
        <script type="text/javascript" src="<?= $stylePath ?>/js/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="<?= $stylePath ?>/js/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="<?= $stylePath ?>/js/confirm.js"></script>
        <script type="text/javascript" src="<?= $stylePath ?>/js/sorttable.js"></script>
		<script type="text/javascript" src="<?= $stylePath ?>/js/jquery.countdown.js"></script>
		<script type="text/javascript" src="<?= $stylePath ?>/js/extra.js"></script>
		<script type="text/javascript" src="<?= $stylePath ?>/js/jquery.easy-confirm-dialog.js"></script>
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		<script type="text/javascript">
			$(function(){
				//Hide messages on click
				enableClickableAlerts();
				enableHoverMovement();
				highlightDiv();
				openclosetabs();
				function highlightMessage() { 
					$("input[type=checkbox]").change(function() {
						var c = this.checked ? '#FFFCDF' : 'inherit';
				  		$(this).parent().parent().css("background-color",c);
					});
				}
				highlightMessage();
				
				// Accordion
				$("#accordion").accordion({ header: "h3" });

				// Tabs
				$('#tabs').tabs();
						
				// Dialog
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() {
							$(this).dialog("close");
						},
						"Cancel": function() {
							$(this).dialog("close");
						}
					}
				});

				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});

				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});

				// Progressbar
				$("#progressbar").progressbar({
					value: 20
				});

				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);

			});
		</script>        
        
    </head>
    <body>            
		<? include("$stylePath/messages.php"); ?>
        <header>
            <div class="wrap">
                <div id="header">   

                    <a id="logo" href="http://<?= $config['site_address'] ?>" title="OneApp">OneApp</a>
                    
                    <hr> 
                    
                    <nav>
                        <ul>
                        <?
							for($i = 0; $i < count($page_display); $i++) {
								echo '<li><a href="' . $page_display[$i] . '"><strong>' . $page_display_names[$i] . '</strong></a></li>';
							}
							?>
                        </ul>          
                    </nav>

                </div> <!-- / #header -->

                <hr>
            </div>
        </header>
                
        <hr>
        
        <div id="container">
            <div id="content" class="wrap">                
                
                <div class="cols marginBottom30 clearFix nav">
            	<div class="col1-4">
					<ul>
						<li class="sidenav"><a href="#">Instructions</a></li>
						<li class="sidenav"><a href="index.php">My Workspace</a></li>
					<?					
						for($i = 0; $i < count($side_display); $i++) {
							echo '<li class="sidenav"><a href="' . $side_display[$i] . '">' . $side_display_names[$i] . '</a>';
								unset($nav_cat);
	
							if(substr($side_display[$i], 0, 10) == "supplement" && isset($_SESSION['user_id'])) {
								
								//display all the supplements this user is working on
								$styleClubsApplied = getUserClubsApplied($_SESSION['user_id']);
		
								echo "<ul>";
								foreach($styleClubsApplied as $styleItem) {
									$style_club_id = $styleItem[0];
									$style_club_name = $styleItem[1];
									echo "<li class=\"sidenav1\"><a href=\"app.php?club_id=$style_club_id&action=view\">$style_club_name</a></li>";
								}
								echo "</ul>";
							} else if(substr($side_display[$i], 0, 4) == "base" && isset($_SESSION['user_id'])) {
								//display the general application categories
								include_once($basePath . "/include/apply_submit.php");
								if(isApplicationStarted($_SESSION['user_id'], 0)) {
									$styleCategoryList = listCategories();
			
									echo "<ul>";
									foreach($styleCategoryList as $styleItem) {
										$style_cat_id = $styleItem[0];
										$style_cat_name = $styleItem[1];
										echo "<li class=\"sidenav1\"><a href=\"app.php?club_id=0&cat_id=$style_cat_id&action=view\">$style_cat_name</a></li>";
									}
									echo "</ul>";
								}
							} else if(substr($side_display[$i], 0, 17) == "root_cat.php?cat=") {
								$nav_cat = urldecode(substr($side_display[$i], 17));
							}

							if(isset($nav_cat)) {
								echo "<ul>";
								$root_display = $config['root_cat_display'][$nav_cat]['links'];
								$root_display_names = $config['root_cat_display'][$nav_cat]['names']; 
								for($j = 0; $j < count($root_display); $j++) {
									echo '<li class="sidenav1"><a href="' . $root_display[$j] . '.php">' . $root_display_names[$j] . '</a></li>';
								}
								echo "</ul>";
							}
						echo '</li>';
						}
						?>
						
					</ul>            		
                </div>
                <div class="col3-4">
