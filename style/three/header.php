<!doctype html>
<html lang="cs">
    <head>
        <meta charset="utf-8">
        <title><?= $config['site_name'] ?></title>
        <meta name="description" content="">
        <meta name="keywords" content="">
<?
if(isset($redirect)) {
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=' . $redirect . '">';	
}
?>
        <link rel="shortcut icon" href="<?= $stylePath ?>/favicon.ico">
        <link rel="apple-touch-icon" href="<?= $stylePath ?>/apple-touch-icon.png">
        <link rel="stylesheet" href="<?= $stylePath ?>/css/main.css?v=1.0" media="screen,projection">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
        <script src="<?= $stylePath ?>/js/jquery.mousewheel-3.0.4.pack.js"></script>
        <script src="<?= $stylePath ?>/js/jquery.fancybox-1.3.4.pack.js"></script>
        <script src="<?= $stylePath ?>/js/custom.js"></script>
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>            
        
        <header>
            <div class="wrap">
                <div id="header">   

                    <a id="logo" href="index.php" title="Asterisk">OneApp<span></span></a>
                    
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
                    
                    <a href="affclubs.php" class="button" title="Affiliated Organizations"><span>Affiliated Organizations</span></a>
                    
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
                    
                    <a href="http://www.one-app.org" class="button floatRight" title="Get OneApp"><span>Get OneApp</span></a>

                </div> <!-- / #subIntro -->
                <? } ?>
            </div>
        </header>
                
        <hr>
        
        <div id="container">
            <div id="content" class="wrap">
