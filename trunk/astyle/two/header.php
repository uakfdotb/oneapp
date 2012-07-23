<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link href="<?= $stylePath ?>/style/style.css" rel="stylesheet" type="text/css">
<link href="<?= $stylePath ?>/style/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css">
<script src="<?= $stylePath ?>/js/sorttable.js"></script>
<script src="<?= $stylePath ?>/js/extra.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= $stylePath ?>/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?= $stylePath ?>/js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="<?= $stylePath ?>/js/timepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){	
    $('.example2').stop(true, true).hide().before('<a href="#" id="toggle-example2" class="button">Show/Hide Details</a>');
	$('a#toggle-example2').click(function() {
		$('.example2').stop(true, true).slideToggle(1000);
		return false;
	});
});

var fade_out = function() {
  $("#message").fadeOut().empty();
}

setTimeout(fade_out, 15000);

$(function(){
	$('.example-container > pre').each(function(i){
		eval($(this).text());
	});
});

$(function(){
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

tday  =new Array("Sun","Mon","Tue","Wed","Thur","Fri","Sat");
tmonth=new Array("Jan","Feb","Mar","April","May","June","July","Aug","Sept","Oct","Nov","Dec");
window.onload=GetClock;
</script>


<title><?=$config['site_name'] ?></title>
</head>

<body>
<div id="container">
	<div id="topbar">
		<table width=100%>
			<tr><td><table>
				<tr><a href="../index.php"><img src="<?= $stylePath ?>/images/logo.jpg" alt="logo" height="60" border="0" /></a></tr>
			</table></td><td><table>
				<tr><p class="location_heading">
				
				<? if($context!="apply") echo'<a href="../application">Applicant</a>'; else echo "Applicant"; ?>  | 
				<? if($context!="admin") echo'<a href="../admin">Administrator</a>'; else echo "Administrator"; ?>  | 
				<? if($context!="root") echo'<a href="../root">Root</a>'; else echo "Root"; ?> 
				</p></tr>
				
				<tr><p class="schooltop"><?= $config['organization_name'] ?></p></tr>
			</table></td><tr>
		</table>
	</div>
	<div id="navbar">
		<table width=100%>
			<tr>
				<td><p id="clockbox"><?= $timeString ?></p></td>
				<td align="right">
					<?
					for($i = 0; $i < count($page_display); $i++) {
						echo '<a href="' . $page_display[$i] . '">' . $page_display_names[$i] . '</a> ';
					}
					?>
				</td>
			</tr>
		</table>
	</div>
	<div><img src="<?= $stylePath ?>/images/top_rule.png" alt="logo" height="2px" width=100% border="0" /></div>
	<div id="col_holder">
		<div id="col_left">
			<div class="side_bar">
				<div class="userbox">
				<? if($context == "root" && isset($_SESSION['user_id'])) {?>
                                                <?$adminInfo = getUserInformation($_SESSION['user_id']); ?>
                                                <p class="box_name"><?= $adminInfo[2]?></p>
                                                <p class="box_id"><?=$config['site_name'] ?> ID: <?= $_SESSION['user_id']?></p>
                                                <p class="box_date">Site Root</p>
				<? } else if($context == "admin" && isset($_SESSION['user_id'])) {?>
						<?$adminInfo = getUserInformation($_SESSION['user_id']); ?>
						<p class="box_name"><?= $adminInfo[2]?></p>
						<p class="box_id"><?=$config['site_name'] ?> ID: <?= $_SESSION['user_id']?></p>
						<p class="box_date">Club Administrator</p>
				<? } else if($context == "apply" && isset($_SESSION['user_id'])) {?>
						<?$userInfo = getUserInformation($_SESSION['user_id']); ?>
						<p class="box_name"><?= $userInfo[2]?></p>
						<p class="box_id"><?=$config['site_name'] ?> ID: <?= $_SESSION['user_id']?></p>
						<p class="box_date"></p>
				<? } ?>
				</div>
				<div class="sidemenu">
					<ul>
						<a href="#"><li class="topsidenav">Instructions</li></a>
						<a href="index.php"><li class="topsidenav">My Workspace</li></a>
					<?					
						for($i = 0; $i < count($side_display); $i++) {
							echo '<a href="' . $side_display[$i] . '">';
							unset($nav_cat);
							
							if($i<2 & $context="apply") echo '<li class="topsidenav">';
							else echo '<li class="sidenav">';
							
							echo  $side_display_names[$i] . '</li></a>';
	
							if(substr($side_display[$i], 0, 10) == "supplement" && isset($_SESSION['user_id'])) {
								unset($nav_cat);
								
								//display all the supplements this user is working on
								$styleClubsApplied = getUserClubsApplied($_SESSION['user_id']);
		
								echo "<ul>";
								foreach($styleClubsApplied as $styleItem) {
									$style_club_id = $styleItem[0];
									$style_club_name = $styleItem[1];
									echo "<a href=\"app.php?club_id=$style_club_id&action=view\">";
									echo "<li class=\"sidenav1\">";
									echo $style_club_name;
									echo "</li></a>";
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
										echo "<a href=\"app.php?club_id=0&cat_id=$style_cat_id&action=view\">";
										echo "<li class=\"sidenav1\">";
										echo $style_cat_name;
										echo "</li></a>";
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
									echo '<a href="' . $root_display[$j] . '.php"><li class="sidenav1">' . $root_display_names[$j] . '</li></a>';
								}
								echo "</ul>";
							}
						}
						?>
						<li class="endsidenav"></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="col_right">
			<div class="message" id="message_appear">
			<?
			if(isset($warning)) {
				echo "<div id=\"message\" class=\"warning\"><p>" . $warning . "</p></div>";
			}
			if(isset($error)) {
				echo "<div id=\"message\" class=\"error\"><p>" . $error . "</p></div>";
			}
			if(isset($info)) {
				echo "<div id=\"message\" class=\"info\"><p>" . $info . "</p></div>";
			}
			if(isset($success)) {
				echo "<div id=\"message\" class=\"success\"><p>" . $success . "</p></div>";
			}
			if(isset($validation)) {
				echo "<div id=\"message\" class=\"validation\"><p>" . $validation . "</p></div>";
			}
			?>
			</div>
			<div id="box">
