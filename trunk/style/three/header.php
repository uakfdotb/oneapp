<!doctype html>
<html lang="cs">
    <head>
        <meta charset="utf-8">
        <title><?= $config['site_name'] ?></title>
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
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		<script type="text/javascript">
			$(function(){ 
				//Hide messages on click
				enableClickableAlerts();
				enableHoverMovement();
				highlightDiv();
				
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

                    <a id="logo" href="index.php" title="OneApp">OneApp<span></span></a>
                    
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
				<? if(isset($home)) { ?>
                <div id="intro">
                        
                    <h1>Welcome to OneApp!</h1>
                    <h2><?= $config['organization_name'] ?></h2>
                    
                    <p>You can add a short description about your school here.</p>
                    
                    <a href="affclubs.php" class="button_style" title="Affiliated Organizations"><span>Affiliated Organizations</span></a>
                    
                    <div id="macbook">
                        <img src="http://placehold.it/366x227" alt="Screen">
                    </div>

                </div> <!-- / #intro -->
                
                <hr>

                <div id="subIntro">
                        
                    <div class="floatLeft">
                        <h2>Want to improve your organization with OneApp?</h2>                    
                        <p class="large">Go here to check if you are eligible!</p>
                    </div>
                    
                    <a href="http://www.one-app.org" class="button_style floatRight" title="Get OneApp"><span>Get OneApp</span></a>

                </div> <!-- / #subIntro -->
                <? } ?>
            </div>
        </header>
                
        <hr>
        
        <div id="container">
            <div id="content" class="wrap">
            <div class="cols marginBottom30 clearFix nav">
